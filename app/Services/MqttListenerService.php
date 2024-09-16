<?php

namespace App\Services;

use App\Models\MqttData;
use App\Models\Project;
use App\Models\SensorUnit;
use App\Models\SwitchUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MqttListenerService
{
    /**
     * The upper limit of the custom DO value.
     */
    const upperLimitOfCustomDOValue = 1.5;

    /**
     * @var string $switchUnitStatus - switch unit status
     */
    private static string $switchUnitStatus = 'active';

    /**
     * @var MqttData|Model|Builder $mqttDataInstance - mqtt data
     */
    public static MqttData|Model|Builder $mqttDataInstance;

    /**
     * @var MqttData|Model|Builder $previousMqttData - mqtt data
     */
    public static MqttData|Model|Builder $previousMqttData;

    /**
     * @var string
     */
    public static string $previousRelay;

    /**
     * @var bool
     */
    public static bool $isAlreadyPublished = false;

    /**
     * @var Builder|SwitchUnit
     */
    public static Builder|SwitchUnit $switchUnit;

    /**
     * Mqtt data switch unit history details.
     * AKA: $mqttDataSwitchUnitHistoryDetails array
     *
     * @var array
     */
    public static array $historyDetails;

    /**
     * The message to be displayed when the command is executed.
     *
     * @var string
     */
    protected string $message;

    /**
     * The original message from the mqtt in json format.
     *
     * @var object
     */
    public static object $responseMessage;

    /**
     * The original clone of message.
     *
     * @var string
     */
    public static string $originalMessage;

    /**
     * @var array $relayArr - relay array
     */
    public static array $relayArr = [];

    /**
     * @var array|string[]
     */
    public static array $publishMessage = [
        'addr' => '',
        'type' => '',
        'relay' => '',
    ];

    /**
     * The topic to be subscribed to.
     *
     * @var string
     */
    public static string $topic;

    /**
     * The flag to check if the message is an update.
     *
     * @var bool
     */
    public static bool $isUpdate = false;

    /**
     * The flag to check if the command is publishable.
     *
     * @var bool
     */
    public static bool $isPublishable = false;

    /**
     * The flag to check if the command is publishable.
     *
     * @var bool
     */
    public static bool $isSaveMqttData = true;

    /**
     * The flag to check if the command is in test mode.
     *
     * @var bool $isTest - flag to check if the command is in test mode
     */
    protected bool $isTest = false;

    /**
     * The current time.
     *
     * @var string
     */
    protected string $currentTime;

    /**
     * The current date time.
     *
     * @var string $currentDateTime - current date time
     */
    protected string $currentDateTime;

    /**
     * MqttListenerService constructor.
     *
     * @param string $message
     * @param string $topic
     */
    public function __construct(string $topic, string $message)
    {
        $this->message = $message;
        $this->setUpdate(false);
        self::$originalMessage = $message;
        self::$responseMessage = json_decode($message ?: '{}');
        self::$topic = $topic;

        $this->currentTime = now()->format('H:i');
        $this->currentDateTime = now()->format('Y-m-d H:i:s');
        self::$isPublishable = true;
    }

    /**
     * @return $this
     */
    public function convertDOValue(): self
    {
        if (isset(self::$responseMessage->data->o2) && self::$responseMessage->data->o2 < self::upperLimitOfCustomDOValue) {
            $o2 = convertDOValue(self::$responseMessage->data->o2, $this->currentTime);
            $echo = 'Converted DO value: from ' . self::$responseMessage->data->o2 . ' to ' . $o2 . ' at ' . $this->currentTime . '<br>';
            echo $echo;
            Log::channel('mqtt_listener')->info($echo);
            self::$responseMessage->data->o2 = $o2;
        }

        return $this;
    }

    /**
     * @return $this|null
     */
    public function republishLastResponse(): self|null
    {
        if (!isset(self::$responseMessage->update) || !self::$responseMessage->update) {
            return $this;
        }

        sleep(2);
        $this->setUpdate();
        $gatewaySerialNumberLast4Digit = Str::before(Str::after(self::$topic, '/'), '/');
        $project = Project::query()
            ->with('mqttDataLast:id,publish_topic,publish_message,project_id')
            ->where('gateway_serial_number', 'LIKE', "%$gatewaySerialNumberLast4Digit")
            ->firstOrFail();

        $mqttData = $project->mqttDataLast ?? null;
        if ($mqttData) {
            $publishMessage = json_decode($mqttData->publish_message ?? '{}');
            $publishTopic = $mqttData->publish_topic;

            self::$publishMessage = [
                'addr' => $publishMessage->addr,
                'type' => $publishMessage->type,
                'relay' => $publishMessage->relay,
            ];

            MqttPublishService::init($publishTopic, $publishMessage->relay, $publishMessage->addr, '');
        }

        return null;
    }

    /**
     * @return array - All prepared data
     */
    public function prepareData(): array
    {
        $this->prepareRelayAndMqttDataHistory()
            ->prepareMqttData()
            ->prepareMqttDataSwitchUnitHistory()
            ->prepareMqttDataSwitchUnitHistoryDetails();

        MqttStoreService::$relayArr = self::$relayArr;

        MqttPublishService::init(self::$topic, self::$publishMessage['relay'], self::$publishMessage['addr'], self::$previousRelay);

        return [
            'relayArr' => MqttStoreService::$relayArr,
            'mqttData' => self::$mqttDataInstance->toArray(),
            'mqttDataHistory' => MqttStoreService::$mqttDataHistory,
            'mqttDataSwitchUnitHistory' => MqttStoreService::$mqttDataSwitchUnitHistory,
            'mqttDataSwitchUnitHistoryDetails' => self::$historyDetails,
        ];
    }

    /**
     * @return $this
     */
    public function prepareRelayAndMqttDataHistory(): MqttListenerService
    {
        return $this->setSensorUnitAndPond()->setRelayAndMqttDataHistory();
    }

    /**
     * @return MqttListenerService
     */
    private function setSensorUnitAndPond(): MqttListenerService
    {
        $remoteNames = collect(self::$responseMessage->data)->keys()->toArray();
        $serialNumber = hexdec(self::$responseMessage->addr);

        MqttStoreService::$sensorUnit = SensorUnit::query()
            ->where('serial_number', $serialNumber)
            ->with(['sensorTypes', 'ponds.project', 'ponds.switchUnits.switchUnitSwitches'])
            ->whereHas('sensorTypes', fn($q) => $q->whereIn('remote_name', $remoteNames))
            ->whereHas('ponds', function ($query) {
                $query->whereHas('project', function ($query) {
                    $query->where('gateway_serial_number', self::$responseMessage->gw_id);
                });
            })
            ->firstOrFail();
        MqttStoreService::$pond = MqttStoreService::$sensorUnit->ponds->firstOrFail();

        return $this;
    }

    /**
     * @return MqttListenerService
     */
    private function setRelayAndMqttDataHistory(): MqttListenerService
    {
        self::$relayArr = array_fill(0, 12, 0);

        MqttStoreService::$sensorUnit->sensorTypes->each(function ($sensorType) {
            if (!isset(self::$responseMessage->data->{$sensorType->remote_name})) {
                return;
            }
            $value = self::$responseMessage->data->{$sensorType->remote_name};

            $sensorName = Str::replace(' ', '', $sensorType->name);
            $helperMethodName = "get{$sensorName}Update";

            $typeMessage = "No helper method found for sensor: $sensorType->name";
            if (function_exists($helperMethodName)) {
                $typeMessage = ($helperMethodName(
                    $value,
                ));
            }
            // if array
            if (is_array($typeMessage)) {
                self::$relayArr = $sensorType->can_switch_sensor
                    ? mergeSwitchArray(
                        $typeMessage,
                        self::$relayArr
                    ) : self::$relayArr;

                $typeMessage = implode(', ', $typeMessage);
            }

            MqttStoreService::$mqttDataHistory[] = [
                'pond_id' => MqttStoreService::$pond->id,
                'sensor_unit_id' => MqttStoreService::$sensorUnit->id,
                'sensor_type_id' => $sensorType->id,
                'value' => $value,
                'message' => $typeMessage,
            ];
        });

        Log::channel('mqtt_listener')->info('MqttDataHistory: ' . json_encode(MqttStoreService::$mqttDataHistory));

        return $this;
    }

    /**
     * gw_id is gateway_serial_number
     * addr is serial_number
     *
     * @return $this
     */
    public function prepareMqttData(): self
    {
        // considering the first switch unit
        self::$switchUnit = MqttStoreService::$pond->switchUnits->firstOrFail();

        $addr = dechex((int)self::$switchUnit->serial_number);
        self::$publishMessage = [
            'addr' => Str::startsWith($addr, '0x') ? $addr : '0x' . $addr,
            'type' => 'sw',
            'relay' => implode('', self::$relayArr),
        ];

        self::$mqttDataInstance = new MqttData();
        self::$mqttDataInstance->project_id = MqttStoreService::$pond->project->id;
        self::$mqttDataInstance->data = json_encode(self::$responseMessage);
        self::$mqttDataInstance->data_source = 'mqtt';
        self::$mqttDataInstance->original_data = self::$originalMessage;
        self::$mqttDataInstance->publish_message = json_encode(self::$publishMessage);
        self::$mqttDataInstance->publish_topic = self::$topic;
        self::$historyDetails = [];

        self::$switchUnitStatus = self::$switchUnit->status;

        // It'll help to get the previous mqtt data so that we can check relay
        self::$previousMqttData = MqttData::query()
            ->where('project_id', MqttStoreService::$pond->project->id)
            ->orderByDesc('id')
            ->first();

        self::$previousRelay = (json_decode(self::$previousMqttData->publish_message, true)['relay'] ?? '');

        self::$isAlreadyPublished = self::$publishMessage['relay'] === self::$previousRelay;

        return $this;
    }

    /**
     * Save mqtt data switch unit history details
     *
     * @table mqtt_data_switch_unit_history_details
     *
     * @return MqttListenerService
     */
    public function prepareMqttDataSwitchUnitHistoryDetails(): MqttListenerService
    {
        self::$switchUnit->switchUnitSwitches->each(function ($switchUnitSwitch, $index) {
            self::$historyDetails[$index] = [
                'number' => $switchUnitSwitch->number,
                'status' => self::$relayArr[$index] ? 'on' : 'off',
                'comment' => $switchUnitSwitch->comment,
                'switch_type_id' => $switchUnitSwitch->switchType,
            ];
        });

        return $this;
    }

    /**
     * Save mqtt data switch unit history
     *
     * @table mqtt_data_switch_unit_history
     *
     * @return MqttListenerService
     */
    public function prepareMqttDataSwitchUnitHistory(): MqttListenerService
    {
        MqttStoreService::$mqttDataSwitchUnitHistory = [
            'pond_id' => MqttStoreService::$pond->id,
            'switch_unit_id' => self::$switchUnit->id,
        ];

        return $this;
    }

    /**
     * @return bool
     */
    public static function checkIfPublishable(): bool
    {
        Log::channel('aerator_status')->info('isUpdate : ' . self::$isUpdate . '--' . ', isPublishable: ' . self::$isPublishable .', Run status At'. self::$switchUnit->run_status_updated_at);
        return (self::$isUpdate || self::$isPublishable) && empty(self::$switchUnit->run_status_updated_at);
    }

    /**
     * Save if the mqtt data is savable and is not same as the previous one.
     *
     * @return bool
     */
    public static function checkIfSavable(): bool
    {
        Log::channel('aerator_status')->info('isSaveMqttData : ' . self::$isSaveMqttData . '--' . ', isAlreadyPublished: ' . self::$isAlreadyPublished);
        return self::$isSaveMqttData && !self::$isAlreadyPublished;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return $this
     */
    public function setTestMode($isTest = true): MqttListenerService
    {
        $this->isTest = $isTest;

        self::$isSaveMqttData = !$isTest; // if test mode is on, don't save mqtt data

        return $this;
    }

    /**
     * @return bool
     */
    public function getTestMode(): bool
    {
        return $this->isTest;
    }

    /**
     * @return $this
     */
    public function setUpdate($isUpdate = true): MqttListenerService
    {
        self::$isUpdate = $isUpdate;

        self::$isSaveMqttData = !$isUpdate; // if update mode is on, don't save mqtt data

        return $this;
    }
}
