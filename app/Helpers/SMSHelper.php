<?php

namespace App\Helpers;

use App\Models\SMSHistory;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\NoReturn;

class SMSHelper
{
    private static             $response;
    private static string      $to;
    private static string      $message;
    private static string|null $sender_id = null;
    private static string|null $schedule  = null;
    private static             $smsService;

    /**
     * @param string $to
     * @param string $message
     * @param string|null $sender_id
     * @param string|null $schedule
     * @return SMSHelper
     */
    public static function init(string $to, string $message, string|null $sender_id = null, string|null $schedule = null): SMSHelper
    {
        self::$to         = $to;
        self::$message    = $message;
        self::$sender_id  = $sender_id;
        self::$schedule   = $schedule;
        self::$smsService = json_decode(getSettingValue('sms_service'))[0];

        //Log::info('SMS Service: ' . json_encode(self::$smsService));

        return new SMSHelper;
    }

    /**
     * @param string|null $to
     * @param string|null $message
     * @param string|null $schedule
     * @return SMSHelper
     */
    public static function sendSMS(string|null $to = null, string|null $message = null, string|null $schedule = null): SMSHelper
    {
        self::$smsService = self::$smsService ?? json_decode(getSettingValue('sms_service'))[0];

        self::$to        = $to ?? self::$to;
        self::$message   = $message ?? self::$message;
        self::$schedule  = $schedule ?? self::$schedule;
        self::$sender_id = self::$sender_id ?? self::$smsService->sender_id;

        $options = [
            'api_key' => self::$smsService->api_key,
            'to'        => self::$to,
            'msg'       => self::$message,
        ];

        if (self::$schedule) {
            $options['schedule'] = self::$schedule;
        }

        if (self::$smsService->sender_id ?? false) {
            $options['sender_id'] = self::$smsService->sender_id;
        }

        try {
            self::$response = Http::retry(5, 60 * 1000)
                ->timeout(59)
                ->connectTimeout(59)
                ->get(self::$smsService->url . '/sendsms', $options);
        }
        catch (\Exception $e) {
            Log::error('SMS Error: ' . $e->getMessage());
        }

        return new SMSHelper;
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public static function report($id): mixed
    {
        $response = Http::get(self::$smsService->url . '/report', [
            'api_token' => self::$smsService->api_key,
            'id'        => $id,
        ]);

        return $response->json();
    }

    /**
     * @return mixed
     */
    public static function getResponse()
    {
        return self::$response;
    }

    /**
     * @return JsonResponse
     */
    public static function getResponseJson(): JsonResponse
    {
        return response()->json(self::getResponse()->json());
    }

    /**
     * @return mixed
     */
    public static function saveToDatabase()
    {
        $response = self::$response
            ? self::$response->json()
            : null;

        if ($response && ($response['error'] ?? 404) == 0) {
            SMSHistory::query()->create([
                'to'        => self::$to,
                'message'   => self::$message,
                'sender_id' => self::$smsService->sender_id ?? '',
                'response'  => json_encode($response),
                'sent_at'   => now(),
            ]);
        } else {
            Log::error('SMS Error: ' . json_encode($response));
        }

        return $response;
    }

    /**
     * @return static
     */
    public static function balance(): static
    {
        self::$smsService = json_decode(getSettingValue('sms_service'))[0];

        self::$response = Http::get(self::$smsService->url . '/user/balance', [
            'api_token' => self::$smsService->api_key,
        ]);

        return new SMSHelper;
    }
}
