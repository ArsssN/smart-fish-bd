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
     * @param string $topic
     * @param string $relay
     * @param string $addr
     * @param string $type
     * @param string $previousRelay
     * @return MqttPublishService
     */
    public static function init(string $topic, string $relay, string $addr, string $previousRelay = '', string $type = 'sw'): MqttPublishService
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
    public static function relayPublish(): void
    {
        if (self::$publishMessage['relay'] === self::$previousRelay) {
            return;
        }

        $publishMessageStr = json_encode(self::$publishMessage);

        Log::channel('aerator_status')->info('Publish Topics : ' . self::$topic . '--' . ', Message: ' . $publishMessageStr);
        if (config('app.env') === 'production') {
            MQTT::publish(self::$topic, $publishMessageStr);
        }
    }

    /**
     * @return array|string[]
     */
    public static function getPublishMessage(): array
    {
        return self::$publishMessage;
    }

    /**
     * @param string|string[] $value
     * @param string|null $key
     * @return void
     */
    public static function setPublishMessage(array|string $value, string $key = null): void
    {
        if ($key) {
            self::$publishMessage[$key] = $value;
        } else {
            self::$publishMessage = $value;
        }
    }
}
