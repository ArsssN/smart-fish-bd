<?php

namespace App\Services;

use App\Models\MqttData;
use App\Models\MqttDataSwitchUnitHistory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class MqttHistoryDataService
{
    /**
     * @var MqttData|Builder
     */
    public static MqttData|Builder $newMqttData;

    /**
     * @param $mqttData
     * @param $publishTopic
     * @param string $dataSource
     * @return void
     */
    public static function mqttDataSave($mqttData, $publishTopic, string $dataSource = 'scheduler'): void
    {
        self::$newMqttData = MqttData::query()->create([
            'type' => 'sensor',
            'project_id' => $mqttData->project_id,
            'data' => $mqttData->data,
            'data_source' => $dataSource,
            'original_data' => $mqttData?->original_data ?? $mqttData?->data,
            'publish_message' => json_encode(MqttPublishService::$publishMessage),
            'publish_topic' => $publishTopic,
        ]);
    }

    /**
     * Save mqtt data history
     *
     * @param $sensorType
     * @param $sensorUnit
     * @param $responseMessage
     * @param $switchState
     *
     * @return void
     */
    public static function mqttDataHistorySave($sensorType, $sensorUnit, $responseMessage, &$switchState): void
    {
        if (!isset($responseMessage->data->{$sensorType->remote_name})) {
            return;
        }

        $sensorMessage = self::getSensorMessage($sensorType, $value = $responseMessage->data->{$sensorType->remote_name}, $switchState);

        // Save mqtt data history
        $histories = [];
        $sensorUnit->ponds->each(function ($pond) use ($sensorUnit, $sensorType, $value, $sensorMessage, &$histories) {
            $histories[] = [
                'pond_id' => $pond->id,
                "sensor_unit_id" => $sensorUnit->id,
                "sensor_type_id" => $sensorType->id,
                'value' => $value,
                'type' => 'sensor',
                'message' => $sensorMessage,
            ];
        });
        self::$newMqttData->histories()->createMany($histories);
    }

    /**
     * @param $switchUnit
     * @param $historyDetails
     * @return void
     */
    public static function mqttDataSwitchUnitHistorySave($switchUnit, $historyDetails): void
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

    /**
     * @param $sensorType
     * @param $value
     * @param $switchState
     * @return string
     */
    private static function getSensorMessage($sensorType, $value, &$switchState): string
    {
        $typeName = Str::replace(' ', '', $sensorType->name);
        $helperMethodName = "get{$typeName}Update";

        $sensorMessage = "No helper method found for sensor: $sensorType->name";
        if (function_exists($helperMethodName)) {
            $sensorMessage = ($helperMethodName(
                $value,
            ));
        }
        // if array
        if (is_array($sensorMessage)) {
            $switchState = $sensorType->can_switch_sensor
                ? mergeSwitchArray(
                    $sensorMessage,
                    $switchState
                ) : $switchState;

            $sensorMessage = implode(', ', $sensorMessage);
        }

        return $sensorMessage;
    }
}
