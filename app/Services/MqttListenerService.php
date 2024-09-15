<?php

namespace App\Services;

use App\Console\Commands\MqttListener;
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
    private static mixed $switchUnitStatus = 'active';

    /**
     * @var MqttData|Model|Builder $mqttData - mqtt data
     */
    public static MqttData|Model|Builder $mqttData;

    /**
     * @var Builder|SwitchUnit
     */
    public static Builder|SwitchUnit $switchUnit;

    /**
     * Mqtt data switch unit history details
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
     * The topic to be subscribed to.
     *
     * @var string
     */
    protected static string $topic;

    /**
     * The flag to check if the message is an update.
     *
     * @var bool
     */
    protected bool $isUpdate = false;

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
        self::$originalMessage = $message;
        self::$responseMessage = json_decode($message ?: '{}');
        self::$topic = Str::replaceLast('/PUB', '/SUB', $topic);

        $this->currentTime = now()->format('H:i');
        $this->currentDateTime = now()->format('Y-m-d H:i:s');
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
        $gatewaySerialNumberLast4Digit = Str::before(Str::after(self::$topic, '/'), '/');
        $project = Project::query()
            ->select('id')
            ->with('mqttDataLast:id,publish_topic,publish_message')
            ->where('gateway_serial_number', 'LIKE', "%$gatewaySerialNumberLast4Digit")
            ->firstOrFail();

        $mqttData = $project->mqttDataLast ?? null;
        if ($mqttData) {
            $publishMessage = json_decode($mqttData->publish_message ?? '{}');
            $publishTopic = $mqttData->publish_topic;
            $previousRelay = $publishMessage->relay
                ?: implode('', array_fill(1, 12, 0));

            MqttPublishService::init($publishTopic, $publishMessage->relay, $publishMessage->addr, $previousRelay);
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

        return [
            'relayArr' => self::$relayArr,
            'mqttData' => self::$mqttData->toArray(),
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

        return $this;
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
        MqttPublishService::setPublishMessage(Str::startsWith($addr, '0x') ? $addr : '0x' . $addr, 'addr');
        MqttPublishService::setPublishMessage('sw', 'type');
        MqttPublishService::setPublishMessage(implode('', self::$relayArr), 'relay');

        self::$mqttData = new MqttData();
        self::$mqttData->project_id = MqttStoreService::$pond->project->id;
        self::$mqttData->data = json_encode(self::$responseMessage);
        self::$mqttData->data_source = 'mqtt';
        self::$mqttData->original_data = self::$originalMessage;
        self::$mqttData->publish_message = json_encode(MqttPublishService::getPublishMessage());
        self::$mqttData->publish_topic = self::$topic;
        self::$historyDetails = [];

        self::$switchUnitStatus = self::$switchUnit->status;

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
     * Save mqtt data switch unit history
     *
     * @table mqtt_data_switch_unit_history
     *
     * @return MqttListenerService
     */
    public function prepareSwitchUnitSwitches(): MqttListenerService
    {
        MqttStoreService::$mqttDataSwitchUnitHistory = [
            'pond_id' => MqttStoreService::$pond->id,
            'switch_unit_id' => self::$switchUnit->id,
        ];

        return $this;
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

        return $this;
    }

    /**
     * @return $this
     */
    public function setUpdate($isUpdate = true): MqttListenerService
    {
        $this->isUpdate = $isUpdate;

        return $this;
    }
}
