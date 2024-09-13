<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;

class MqttPublishService
{

    public static array $publishMessage;

    /**
     * relay publish to mqtt if app.env == production
     *
     * @param string $relay
     * @param string $previousRelay
     * @param string $publishTopic
     * @param string $addr
     * @param string $type
     * @return void
     */
    public static function relayPublish(string $relay, string $previousRelay, string $publishTopic, string $addr, string $type = 'sw'): void
    {
        $publishMessage = [
            'relay' => $relay,
            'type' => $type,
            'addr' => $addr
        ];

        self::$publishMessage = $publishMessage;

        if ($relay === $previousRelay) {
            return;
        }

        Log::channel('aerator_status')->info('Publish Topics : ' . $publishTopic . '--' . ', Message: ' . json_encode($publishMessage));
        if (config('app.env') === 'production') {
            MQTT::publish($publishTopic, json_encode($publishMessage));
        }
    }
}
