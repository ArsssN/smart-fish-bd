<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Notifications\UserRegisterNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * @O-A\Post(
     *     path="/api/v1/register",
     *     operationId="register",
     *     tags={"Auth"},
     *     summary="Register",
     *     @O-A\RequestBody(
     *         required=true,
     *         @O-A\MediaType(
     *             mediaType="application/json",
     *             @O-A\Schema(
     *                 required={"first_name", "last_name", "username", "email", "farm_name", "password", "phone",
                       "password_confirmation", "account_holder_id"},
     *                 @O-A\Property(
     *                     property="first_name",
     *                     type="string",
     *                     example="John",
     *                 ),
     *                 @O-A\Property(
     *                     property="last_name",
     *                     type="string",
     *                     example="Doe",
     *                 ),
     *                 @O-A\Property(
     *                     property="username",
     *                     type="string",
     *                     example="johndoe",
     *                 ),
     *                 @O-A\Property(
     *                     property="email",
     *                     type="string",
     *                     example="johndoe@smartfishbd.com",
     *                 ),
     *                 @O-A\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="01700000000",
     *                 ),
     *                 @O-A\Property(
     *                     property="farm_name",
     *                     type="string",
     *                     example="Smart Fish BD",
     *                 ),
     *                 @O-A\Property(
     *                     property="password",
     *                     type="string",
     *                     example="password",
     *                 ),
     *                 @O-A\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     example="password",
     *                 ),
     *                 @O-A\Property(
     *                     property="account_holder_id",
     *                     type="string",
     *                     example="123456789",
     *                 ),
     *             )
     *         )
     *      ),
     *     @O-A\Response(
     *         response=200,
     *         description="Successful operation",
     *         @O-A\JsonContent(ref="#/components/schemas/AccessToken")
     *     ),
     * )
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        request()->merge([
            'userDetails' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'farm_name' => $request->farm_name,
                'phone' => $request->phone,
                'account_holder_id' => $request->account_holder_id,
            ],
        ]);

        $user = User::query()->create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
        ]);

        $user->assignRole('customer');

        $user->userDetails()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'farm_name' => $request->farm_name,
            'phone' => $request->phone,
            'account_holder_id' => $request->account_holder_id,
        ]);

//        $user->notify(new UserRegisterNotification(Str::random(60)));

        $response = (new LoginController)($request);

        return response()->json($response->getOriginalContent());
    }
}
