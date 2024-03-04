<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\SMSHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UsernameRecoveryNotification;
use App\Notifications\PasswordRecoveryNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RecoveryController extends Controller
{
    private null|string             $phone;
    private null|string             $email;
    private null|Model|User|Builder $user = null;

    public function __invoke(Request $request, string $type): JsonResponse
    {
        return $this->{"recover" . ucfirst($type)}($request);
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    private function recoverUsername($request): JsonResponse
    {
        try {
            $request->validate([
                'email'  => 'nullable|email',
                'phone' => 'nullable|min:11',
            ]);

            $this->phone = Str::substr($request->phone, -11);
            $this->email  = $request->email;

            $this->user = User::query()
                ->where('email', $this->email)
                ->with('userDetails')
                ->orWhere(
                    fn($q) => $q->whereHas(
                        'userDetails',
                        fn($q) => $q->where('phone', $this->phone)
                    )
                )
                ->firstOrFail();

            if ($this->phone) {
                $sms = "Your username is: {$this->user->username}. Please keep it safe. From " . config('app.name');
                SMSHelper::init($this->phone, $sms)->sendSMS()->saveToDatabase();
                $message = "Your username is sent to your mobile number";
            } else {
                $this->user->notify(new UsernameRecoveryNotification());
                $message = "Your username is sent to your email address";
            }

            return response()->json([
                'message' => $message
            ]);
        }
        catch (\Exception $e) {
            $message = $e->getMessage() ?? 'Something went wrong';

            if (!$this->user) {
                if ($this->phone) {
                    $message = 'No user found with this mobile number: ' . $this->phone;
                } else {
                    $message = 'No user found with this email address: ' . $this->email;
                }
            }

            return response()->json([
                'message' => $message,
            ], 401);
        }
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    private function recoverPassword($request): JsonResponse
    {
        try {
            $request->validate([
                'username' => 'required|min:4|max:191',
            ]);

            $this->user = User::query()
                ->where('username', $request->username)
                ->firstOrFail();

            $token         = Str::random(64);
            $passwordReset = $this->user->passwordReset();
            (clone $passwordReset)->updateOrCreate(
                ['email' => $this->user->email],
                ['token' => bcrypt($token), 'created_at' => now()]
            );

            $this->user->notify(new PasswordRecoveryNotification($token));

            if (!$this->user->email_verified_at) {
                $this->user->update(['email_verified_at' => now()]);
            }

            return response()->json([
                'message' => 'Password recovery link is sent to your email address',
            ]);
        }
        catch (\Exception $e) {
            $message = $e->getMessage() ?? 'Something went wrong';

            if (!$this->user) {
                $message = 'No user found with this username: ' . $request->username;
            }

            return response()->json([
                'message' => $message,
            ], 401);
        }
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    private function recoverResetPassword(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'token'            => 'required',
                'email'            => 'required|email',
                'password'         => 'required|min:6|max:80',
                'confirm_password' => 'required|min:6|max:80|same:password',
            ]);

            $this->user = User::query()
                ->where('email', $request->email)
                ->firstOrFail();

            $passwordReset  = $this->user->passwordReset();
            $aPasswordReset = (clone $passwordReset)->first();

            if (!$aPasswordReset) {
                throw new \Exception('Token expired or invalid');
            }

            // password validation
            if (Hash::check($request->token, $aPasswordReset->token)) {
                $this->user->update([
                    'password' => Hash::make($request->password)
                ]);

                $passwordReset->delete();

                return response()->json([
                    'message' => 'Password reset successfully',
                ]);
            } else {
                throw new \Exception('Token expired or invalid');
            }
        }
        catch (\Exception $e) {
            $message = $e->getMessage() ?? 'Something went wrong';

            if (!$this->user) {
                $message = 'No user found with this email address: ' . $request->email;
            }

            return response()->json([
                'message' => $message,
            ], 401);
        }
    }
}
