<?php

namespace App\Services;

use App\Models\MqttData;
use App\Models\MqttDataSwitchUnitHistory;

class MqttHistoryDataService
{
    public static $newMqttData;

    /**
     * @param $mqttData
     * @param $publishTopic
     * @param string $dataSource
     * @return void
     */
    public static function mqttDataSave($mqttData, $publishTopic, string $dataSource = 'scheduler'): void
    {
        $newMqttData = MqttData::query()->create([
            'type' => 'sensor',
            'project_id' => $mqttData->project_id,
            'data' => $mqttData->data,
            'data_source' => $dataSource,
            'original_data' => $mqttData?->original_data ?? $mqttData?->data,
            'publish_message' => json_encode(MqttPublishService::$publishMessage),
            'publish_topic' => $publishTopic,
        ]);

        self::$newMqttData = $newMqttData;
    }

    /**
     * @param $switchUnit
     * @param $historyDetails
     * @return void
     */
    public static function mqttDataSwitchUnitHistorySave($switchUnit, $historyDetails)
    {
        $switchUnit->ponds->each(function ($pond) use ($switchUnit, $historyDetails) {
            $mqttDataSwitchUnitHistory = MqttDataSwitchUnitHistory::query()->create([
                'mqtt_data_id' => self::$newMqttData->id,
                'pond_id' => $pond->id,
                'switch_unit_id' => $switchUnit->id,
            ]);

            $mqttDataSwitchUnitHistory->switchUnitHistoryDetails()->createMany($historyDetails);
        });
    }
}
