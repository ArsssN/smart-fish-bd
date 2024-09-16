<?php

namespace App\Services;

use App\Models\MqttData;
use App\Models\MqttDataSwitchUnitHistory;
use App\Models\Pond;
use App\Models\SensorUnit;
use App\Models\SwitchUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use stdClass;

class MqttStoreService
{
    /**
     * @var array
     */
    public static array $mqttDataArr = [
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
     * @var Builder|MqttDataSwitchUnitHistory
     */
    public static Builder|MqttDataSwitchUnitHistory $newSwitchUnitHistory;

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
     * @var array
     */
    public static array $mqttDataSwitchUnitHistory;

    /**
     * @var Builder|SensorUnit
     */
    public static Builder|SensorUnit $sensorUnit;

    /**
     * @var Builder|Pond
     */
    public static Builder|Pond $pond;

    /**
     * Mqtt data switch unit history details.
     * AKA: $mqttDataSwitchUnitHistoryDetails array
     *
     * @var array
     */
    public static array $historyDetails;

    /**
     * @var array $relayArr - relay array
     */
    public static array $relayArr = [];

    /**
     * Mqtt publish must be initiated before store.
     *
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
        self::$mqttDataArr = [
            'type' => 'sensor',
            'project_id' => $mqttData->project_id,
            'data' => $mqttData->data ?? null,
            'data_source' => $dataSource,
            'original_data' => $mqttData->original_data ?? $mqttData->data ?? null,
            'publish_message' => json_encode(MqttPublishService::getPublishMessage()), // assuming before initiating store, mqtt has been published
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
        /** @var MqttData $newMqttData */
        $newMqttData = MqttData::query()->create([
            'type' => self::$mqttDataArr['type'],
            'project_id' => self::$mqttDataArr['project_id'],
            'data' => self::$mqttDataArr['data'] ?? null,
            'data_source' => self::$mqttDataArr['data_source'],
            'original_data' => self::$mqttDataArr['original_data'],
            'publish_message' => self::$mqttDataArr['publish_message'],
            'publish_topic' => self::$mqttDataArr['publish_topic'],
        ]);

        self::$newMqttDataBuilder = $newMqttData
            ->with('project.ponds.sensorUnits.sensorTypes')
            ->find($newMqttData->id);

        return new self();
    }

    /**
     * Save mqtt data history for all sensors
     *
     * @return MqttStoreService
     */
    public static function mqttDataHistoriesSave(): MqttStoreService
    {
        self::$newMqttDataBuilder->histories()->createMany(self::$mqttDataHistory);

        return new self();
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
        self::$newSwitchUnitHistory = self::$newMqttDataBuilder->switchUnitHistory()->create(self::$mqttDataSwitchUnitHistory);

        return new self();
    }

    /**
     * Save mqtt data switch unit history
     *
     * @table mqtt_data_switch_unit_history_details
     *
     * @return MqttStoreService
     */
    public static function mqttDataSwitchUnitHistoryDetailsSave(): MqttStoreService
    {
        self::$newSwitchUnitHistory->switchUnitHistoryDetails()->createMany(self::$historyDetails);

        return new self();
    }

    /**
     * @return void
     */
    public static function switchUnitSwitchesStatusUpdate(): void
    {
        $previousRelay = MqttListenerService::$previousRelay;
        $currentRelay = [];
        $matchingFound = false;

        self::$switchUnit->switchUnitSwitches->each(function ($switchUnitSwitch, $index) use (&$currentRelay, $previousRelay, &$matchingFound) {
            $switchUnitSwitch->status = self::$relayArr[$index] ? 'on' : 'off';
            $switchUnitSwitch->save();

            $currentRelay[] = $switchUnitSwitch->status === 'off' ? 0 : 1;

            if (isset($previousRelay[$index]) && $previousRelay[$index] === '1' && $currentRelay[$index] === 1) {
                $matchingFound = true;
            }
        });

        Log::channel('mqtt_listener')->info("relayArr: " . implode('', self::$relayArr) . "; O-Relay: " . implode('', array_fill(0, count(self::$relayArr), 0)));

        if (implode('', self::$relayArr) !== implode('', array_fill(0, count(self::$relayArr), 0)) && (empty(self::$switchUnit->run_status_updated_at) || !$matchingFound)) {
            Log::channel('mqtt_listener')->info("run_status_updated_at");
            self::$switchUnit->run_status_updated_at = now();
            self::$switchUnit->save();
        }
    }
}
