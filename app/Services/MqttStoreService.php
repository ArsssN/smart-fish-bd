<?php

namespace App\Services;

use App\Models\MqttData;
use App\Models\MqttDataSwitchUnitHistory;
use App\Models\Pond;
use App\Models\SensorUnit;
use App\Models\SwitchUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use stdClass;

class MqttStoreService
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
     * @var array
     */
    public static array $mqttDataHistory = [];

    /**
     * @var Builder|MqttData
     */
    public static Builder|MqttData $newMqttDataBuilder;

    /**
     * Here we have:
     *  - sensor unit
     *      - sensor types array
     *      - ponds array
     *          - project object
     *
     * @var Builder|SwitchUnit
     */
    public static Builder|SwitchUnit $switchUnit;

    /**
     * @var Builder|MqttDataSwitchUnitHistory
     */
    public static Builder|MqttDataSwitchUnitHistory $mqttDataSwitchUnitHistory;

    /**
     * @var Builder|SensorUnit
     */
    public static Builder|SensorUnit $sensorUnit;

    /**
     * @var Builder|Pond
     */
    public static Builder|Pond $pond;

    /**
     * Mqtt data switch unit history details
     *
     * @var array
     */
    public static array $historyDetails;

    /**
     * @var array $relayArr - relay array
     */
    public static array $relayArr = [];

    /**
     * @param string $publishTopic
     * @param Builder|MqttData|stdClass $mqttData
     * @param Builder|SwitchUnit $switchUnit
     * @param array $historyDetails
     * @param string $dataSource
     *
     * @return MqttStoreService
     */
    public static function init(string $publishTopic, Builder|MqttData|stdClass $mqttData, Builder|SwitchUnit $switchUnit, array $historyDetails, string $dataSource = 'scheduler'): MqttStoreService
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
    public static function mqttDataSave(): MqttStoreService
    {
        $newMqttDataBuilder = MqttData::query()->create([
            'type' => self::$mqttData['type'],
            'project_id' => self::$mqttData['project_id'],
            'data' => self::$mqttData['data'],
            'data_source' => self::$mqttData['data_source'],
            'original_data' => self::$mqttData['original_data'],
            'publish_message' => self::$mqttData['publish_message'],
            'publish_topic' => self::$mqttData['publish_topic'],
        ]);

        self::$newMqttDataBuilder = $newMqttDataBuilder->with('project.ponds.sensorUnits.sensorTypes')->find($newMqttDataBuilder->id);

        return new self();
    }

    /**
     * Update relay
     *
     * @return MqttStoreService
     */
    public static function mqttDataPublishMessageUpdate(): MqttStoreService
    {
        $relay = implode('', self::$relayArr);
        $publishMessage = json_decode(self::$newMqttDataBuilder->publish_message ?? '{}');
        $publishMessage->relay = $relay;
        self::$newMqttDataBuilder->publish_message = json_encode($publishMessage);
        self::$newMqttDataBuilder->save();

        return new self();
    }

    /**
     * Save mqtt data history for all sensors
     *
     * @return MqttStoreService
     */
    public static function mqttDataHistoriesSave(): MqttStoreService
    {
        self::$relayArr = array_fill(0, 12, 0);

        self::$sensorUnit->sensorTypes->each(function ($sensorType) {
            self::mqttDataHistorySave($sensorType, null, MqttListenerService::$responseMessage, self::$relayArr);
        });

        return self::mqttDataPublishMessageUpdate();
    }

    /**
     * Save mqtt data history
     *
     * @table mqtt_data_history
     *
     * @param $sensorType
     * @param $sensorUnit
     * @param $responseMessage
     * @param $relayArr
     *
     * @return void
     */
    public static function mqttDataHistorySave($sensorType, $sensorUnit, $responseMessage, &$relayArr): void
    {
        if (!isset($responseMessage->data->{$sensorType->remote_name})) {
            return;
        }

        self::$sensorUnit = $sensorUnit ?? self::$sensorUnit;

        $sensorMessage = self::getSensorMessage($sensorType, $value = $responseMessage->data->{$sensorType->remote_name}, $relayArr);

        // Save mqtt data history
        $histories = [];
        self::$sensorUnit->ponds->each(function ($pond) use ($sensorType, $value, $sensorMessage, &$histories) {
            $histories[] = [
                'pond_id' => $pond->id,
                "sensor_unit_id" => self::$sensorUnit->id,
                "sensor_type_id" => $sensorType->id,
                'value' => $value,
                'type' => 'sensor',
                'message' => $sensorMessage,
            ];
        });
        self::$newMqttDataBuilder->histories()->createMany($histories);
    }

    /**
     * @param $sensorType
     * @param $value
     * @param $relayArr
     * @return string
     */
    private static function getSensorMessage($sensorType, $value, &$relayArr): string
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
            $relayArr = $sensorType->can_switch_sensor
                ? mergeSwitchArray(
                    $sensorMessage,
                    $relayArr
                ) : $relayArr;

            $sensorMessage = implode(', ', $sensorMessage);
        }

        return $sensorMessage;
    }

    /**
     * Save mqtt data switch unit history
     *
     * @table mqtt_data_switch_unit_history
     *
     * @return MqttStoreService
     */
    public static function mqttDataSwitchUnitHistorySave(): MqttStoreService
    {
        self::$switchUnit->ponds->each(function ($pond) {
            self::$mqttDataSwitchUnitHistory[] = MqttDataSwitchUnitHistory::query()->create([
                'mqtt_data_id' => self::$newMqttDataBuilder->id,
                'pond_id' => $pond->id,
                'switch_unit_id' => self::$switchUnit->id,
            ]);
        });

        return new self();
    }

    /**
     * @return void
     */
    public static function switchUnitSwitchesStatusUpdate()
    {
        self::$sensorUnit->ponds->each(function ($pond) {
            $pond->switchUnits->each(function ($switchUnit) {
                $mqttDataSwitchUnitHistories = [];
                $switchUnit->switchUnitSwitches->each(function ($switchUnitSwitch) use ($switchUnit) {
                    $switchUnitSwitch->update([
                        'status' => self::$relayArr[$switchUnitSwitch->number - 1] == 1 ? 'on' : 'off',
                    ]);

                    $mqttDataSwitchUnitHistories[] = [
                        'mqtt_data_id' => self::$mqttData->id,
                        'pond_id' => $switchUnit->pivot->pond_id,
                        'switch_unit_id' => $switchUnit->id,
                        //'switches' => json_encode($switches),
                        'switches' => json_encode(collect()),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                });

                $switchUnit->switchUnitSwitchHistories()->createMany($mqttDataSwitchUnitHistories);
            });
        });
    }
}
