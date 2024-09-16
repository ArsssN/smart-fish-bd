<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;

class MqttPublishService
{
    private static array $publishMessage = [
        'addr' => '',
        'type' => '',
        'relay' => '',
    ];

    /**
     * @var string
     */
    private static string $topic;

    /**
     * @var string
     */
    private static string $previousRelay;

    /**
     * Mqtt publish must be initiated before store.
     *
     * @param string $topic
     * @param string $relay
     * @param string $addr
     * @param string $type
     * @param string $previousRelay
     * @return MqttPublishService
     */
    public static function init(string $topic, string $relay, string $addr, string $previousRelay, string $type = 'sw'): MqttPublishService
    {
        self::$topic = $topic;
        self::$previousRelay = $previousRelay;
        self::$publishMessage = [
            'relay' => $relay,
            'addr' => $addr,
            'type' => $type,
        ];

        return new self();
    }

    /**
     * Publish mqtt if in production mode
     *
     * @return void
     */
    public static function relayPublish($cond = true): void
    {
        if ((self::$publishMessage['relay'] === self::$previousRelay) && $cond) {
            Log::channel('mqtt_listener')->info('Relay is same as previous for Topics: '. self::$topic);
            return;
        }

        $publishMessageStr = json_encode(self::$publishMessage);

        Log::channel('aerator_status')->info('Publish Topics : ' . self::$topic . '--' . ', Message: ' . $publishMessageStr);
        MQTT::publish(self::$topic, $publishMessageStr);
    }

    /**
     * @return array|string[]
     */
    public static function getPublishMessage($key = null): array
    {
        if ($key) {
            return self::$publishMessage[$key];
        } else {
            return self::$publishMessage;
        }
    }
}
