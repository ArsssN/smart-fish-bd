<?php

namespace App\Services;

use App\Models\MqttData;
use App\Models\MqttDataSwitchUnitHistory;
use App\Models\MqttDataSwitchUnitHistoryDetail;
use App\Models\SensorUnit;
use App\Models\SwitchUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use stdClass;

class MqttHistoryDataService
{
    /**
     * @var array
     */
    public static array $mqttData = [
        'type' => 'sensor',
        'project_id' => '',
        'data' => '',
        'data_source' => '',
        'original_data' => '',
        'publish_message' => '',
        'publish_topic' => '',
    ];

    /**
     * @var Builder|MqttData
     */
    public static Builder|MqttData $newMqttDataBuilder;

    /**
     * @var Builder|SwitchUnit
     */
    public static Builder|SwitchUnit $switchUnit;

    /**
     * @var Builder|SensorUnit
     */
    public static Builder|SensorUnit $sensorUnit;

    /**
     * Mqtt data switch unit history details
     *
     * @var array
     */
    public static array $historyDetails;

    /**
     * @param string $publishTopic
     * @param MqttData|Builder $mqttData
     * @param Builder|SwitchUnit $switchUnit
     * @param array $historyDetails
     * @param string $dataSource
     *
     * @return MqttHistoryDataService
     */
    public static function init(string $publishTopic, Builder|MqttData|stdClass $mqttData, Builder|SwitchUnit $switchUnit, array $historyDetails, string $dataSource = 'scheduler'): MqttHistoryDataService
    {
        self::$mqttData = [
            'type' => 'sensor',
            'project_id' => $mqttData->project_id,
            'data' => $mqttData->data,
            'data_source' => $dataSource,
            'original_data' => $mqttData->original_data ?? $mqttData->data,
            'publish_message' => json_encode(MqttPublishService::getPublishMessage()),
            'publish_topic' => $publishTopic,
        ];
        self::$switchUnit = $switchUnit;
        self::$historyDetails = $historyDetails;

        self::$newMqttDataBuilder = MqttData::query();

        return new self();
    }

    /**
     * Save mqtt data
     *
     * @table mqtt_data
     *
     * @return $this
     */
    public static function mqttDataSave(): MqttHistoryDataService
    {
        self::$newMqttDataBuilder = MqttData::query()->create([
            'type' => self::$mqttData['type'],
            'project_id' => self::$mqttData['project_id'],
            'data' => self::$mqttData['data'],
            'data_source' => self::$mqttData['data_source'],
            'original_data' => self::$mqttData['original_data'],
            'publish_message' => self::$mqttData['publish_message'],
            'publish_topic' => self::$mqttData['publish_topic'],
        ]);

        return new self();
    }

    /**
     * Save mqtt data history
     *
     * @table mqtt_data_history
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
        self::$newMqttDataBuilder->histories()->createMany($histories);
    }

    /**
     * Save mqtt data switch unit history
     *
     * @table mqtt_data_switch_unit_history
     *
     * @return MqttHistoryDataService
     */
    public static function mqttDataSwitchUnitHistorySave(): MqttHistoryDataService
    {
        self::$switchUnit
            ->ponds
            ->each(function ($pond) {
                $mqttDataSwitchUnitHistory = MqttDataSwitchUnitHistory::query()->create([
                    'mqtt_data_id' => self::$newMqttDataBuilder->id,
                    'pond_id' => $pond->id,
                    'switch_unit_id' => self::$switchUnit->id,
                ]);

                $mqttDataSwitchUnitHistory?->switchUnitHistoryDetails()->createMany(self::$historyDetails);
            });

        return new self();
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

    /**
     * @return void
     */
    public static function switchUnitSwitchesStatusUpdate()
    {
        //TODO: Implement this method
    }
}
