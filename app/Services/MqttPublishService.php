<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;

class MqttPublishService
{

    public static array $publishMessage;

    /**
     * Publish mqtt if in production mode
     *
     * @param string $relay
     * @param string $previousRelay
     * @param string $publishTopic
     * @param string $addr
     * @param string $type
     * @return void
     */
    public static function relayPublish(string $publishTopic, string $relay, string $addr, string $previousRelay = '', string $type = 'sw'): void
    {
        self::$publishMessage = [
            'relay' => $relay,
            'type' => $type,
            'addr' => $addr
        ];

        if ($relay === $previousRelay) {
            return;
        }

        $publishMessageStr = json_encode(self::$publishMessage);

        Log::channel('aerator_status')->info('Publish Topics : ' . $publishTopic . '--' . ', Message: ' . $publishMessageStr);
        if (config('app.env') === 'production') {
            MQTT::publish($publishTopic, $publishMessageStr);
        }
    }
}
