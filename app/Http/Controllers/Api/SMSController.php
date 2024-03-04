<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SMSHelper;
use App\Http\Controllers\Controller;

class SMSController extends Controller
{
    /**
     * @return mixed
     */
    public function balance()
    {
        return SMSHelper::balance()->getResponseJson();
    }

    /**
     * @return mixed
     */
    public function sendSMS()
    {
        //$to      = '01748893740';
        $to       = request()->to ?? '01721571954';
        $message  = request()->message ?? 'Test message from ' . config('app.name') . '. Powered by: ArsssN';
        $schedule = request()->schedule ?? null;

        return SMSHelper::sendSMS($to, $message)
            ->saveToDatabase()
            ->getResponseJson();
    }
}
