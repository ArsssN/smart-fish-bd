<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Helpers\SMSHelper;
use App\Http\Resources\Api\EventResource;
use App\Http\Resources\Api\InvitationResource;
use App\Http\Resources\Api\InviteeResource;
use App\Models\Invitation;
use App\Models\InvitationOtp;
use App\Models\Invitee;
use App\Notifications\InviteeOTPNotification;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public bool $sendSms   = true;
    public bool $sendEmail = true;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkInvitation(Request $request)
    {
        $with = ['event'];

        //TODO: Send otp to user
        // in 5 minutes maximum 3 otp can be sent to user
        // if user send more than 3 otp in 5 minutes then return error saying "You have exceeded the limit of sending otp"
        // if last otp is not expired while asking new one then delete it and send new otp

        $code       = $request->get('code');
        $invitation = Invitation::query()->where('code', $code)
            ->with(...$with)
            ->firstOrFail();

        if ($invitation) {
            if ($request->get('sendOtp')) {
                try {
                    $this->sendOtp($invitation);
                }
                catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                        'data'    => [
                            'code'       => $code,
                            'send_sms'   => $this->sendSms,
                            'send_email' => $this->sendEmail,
                        ]
                    ]);
                }
            }

            $invitation->setAttribute('sendSms', $this->sendSms);
            $invitation->setAttribute('sendEmail', $this->sendEmail);

            $otpSendTo = '';
            if ($this->sendSms) $otpSendTo = 'sms';
            if ($this->sendEmail) $otpSendTo = 'email';
            if ($this->sendSms && $this->sendEmail) $otpSendTo = 'sms and/or email';
            if ($otpSendTo) $otpSendTo = "OTP sent to $otpSendTo.";

            return response()->json([
                'success' => true,
                'message' => "Invitation code is valid. $otpSendTo",
                'data'    => InvitationResource::make($invitation),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invitation code is invalid.',
                'data'    => [
                    'code' => $code
                ]
            ], 404);
        }
    }

    /**
     * Send OTP to invitee
     *
     * @param Builder|Model|Invitation $invitation
     * @return void
     * @throws Exception
     */
    private function sendOtp(Builder|Model|Invitation $invitation): void
    {
        $code         = $invitation->code;
        $smsService   = json_decode(getSettingValue('sms_service'))[0];
        $emailService = json_decode(getSettingValue('email_service'))[0];

        $otp = getOtp($smsService->otp_length ?? 8);
        $url = config('app.frontend_base_url') . "/invitation?code=$code&otp=$otp";

        // delete old otp
        $invitation->invitationOtp()->delete();

        $invitationOTPCount = $invitation->invitationOtp()
            ->where('created_at', '>=', now()->subMinutes($smsService->max_sms_time ?? 30))
            ->withTrashed()
            ->count();

        if ($invitationOTPCount >= (int)($smsService->max_sms_number ?? 4)) {
            $this->sendSms = false;
        }

        if ($invitationOTPCount >= (int)($emailService->max_email_number ?? 8)) {
            $this->sendEmail = false;
        }

        if (!($this->sendSms || $this->sendEmail)) {
            throw new Exception('You have exceeded the limit of sending otp. Please try again later.');
        }

        $invitation->invitationOtp()->create([
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(InvitationOtp::EXPIRY_TIME),
        ]);

        try {
            $invitee = (clone $invitation)->invitee;

            if (canSendEmail() && $this->sendEmail) {
                $invitee->notify(new InviteeOTPNotification($invitation, $url));
            }

            if (canSendSMS() && $this->sendSms) {
                $message = getInvitationOTPMessage($otp);
                SMSHelper::init($invitee->phone, $message)->sendSMS()->saveToDatabase();
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkInvitationOtp(Request $request)
    {
        $code            = $request->get('code');
        $otp             = $request->get('otp');
        $isAuthenticated = $request->get('isAuthenticated');

        $invitee = Invitee::query()
            ->whereHas(
                'invitation',
                fn($query) => $query->where('code', $code)
            );
        if (config('app.check_otp', true)) {
            $invitee = $invitee->whereHas(
                'invitation.invitationOtp',
                fn($query) => $query->where('otp', $otp)
            );
        }
        $invitee = $invitee->first();

        if ($invitee) {
            $invitation = (clone $invitee)->invitation;
            $event      = EventResource::make((clone $invitation)->event);
            $invitation->invitationOtp()->delete();

            return response()->json([
                'success' => true,
                'message' => 'OTP is valid.',
                'data'    => [
                    'card'    => $invitation->card,
                    'code'    => $code,
                    'event'   => $event,
                    'auth'    => !$isAuthenticated
                        ? AuthHelper::getAccessToken($invitee->user)
                        : null,
                    'invitee' => InviteeResource::make($invitee),
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP',
            ], 404);
        }
    }
}
