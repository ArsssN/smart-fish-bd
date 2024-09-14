<?php

namespace App\Services;

use App\Console\Commands\__MqttListener;
use App\Models\MqttData;
use App\Models\Project;
use App\Models\SensorUnit;
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
     * MqttListenerService constructor.
     *
     * @param string $message
     * @param string $topic
     */
    public function __construct(string $topic, string $message)
    {
        $this->message = $message;
        $this->responseMessage = json_decode($message ?: '{}');
        $this->topic = Str::replaceLast('/PUB', '/SUB', $topic);

        self::$publishMessageArr = [
            'addr' => '',
            'type' => 'sw',
            'relay' => implode('', array_fill(0, 12, 0)),
        ];
    }

    /**
     * The message to be displayed when the command is executed.
     *
     * @var string
     */
    protected string $message;

    /**
     * @var array $publishMessageArr - publish message array
     */
    public static array $publishMessageArr = [
        'addr' => '',
        'type' => '',
        'relay' => '',
    ];

    /**
     * The original message from the mqtt in json format.
     *
     * @var object
     */
    protected object $responseMessage;

    /**
     * The topic to be subscribed to.
     *
     * @var string
     */
    protected string $topic;

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

    public function processResponse(): void
    {
        $this->currentTime = now()->format('H:i');
        $this->currentDateTime = now()->format('Y-m-d H:i:s');

        if (isset($this->responseMessage->update)) {
            $this->isUpdateResponse();
            return;
        }

        $this->convertDOValue()->saveData();

        return $this->saveMqttData($this->responseMessage);
    }

    /**
     * @return $this
     */
    public function convertDOValue(): self
    {
        if (isset($this->responseMessage->data->o2) && $this->responseMessage->data->o2 < self::upperLimitOfCustomDOValue) {
            $o2 = convertDOValue($this->responseMessage->data->o2, $this->currentTime);
            $echo = 'Converted DO value: from ' . $this->responseMessage->data->o2 . ' to ' . $o2 . ' at ' . $this->currentTime . '<br>';
            echo $echo;
            Log::channel('mqtt_listener')->info($echo);
            $this->responseMessage->data->o2 = $o2;
        }

        return $this;
    }

    /**
     * @return void
     */
    public function isUpdateResponse(): void
    {
        sleep(2);
        $gatewaySerialNumberLast4Digit = Str::before(Str::after($this->topic, '/'), '/');
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

            MqttPublishService::relayPublish($publishTopic, '', $publishMessage->addr, $previousRelay);
        }
    }

    /**
     * gw_id is gateway_serial_number
     * addr is serial_number
     *
     * @return void
     */
    public function saveData(): void
    {
        $newResponseMessage = new \stdClass();
        $newResponseMessage->gateway_serial_number = $this->responseMessage->gw_id;
        $newResponseMessage->type = 'sensor';
        $newResponseMessage->serial_number = hexdec($this->responseMessage->addr);
        $newResponseMessage->data = $this->responseMessage->data;

        $remoteNames = collect($this->responseMessage->data)->keys()->toArray();
        $serialNumber = hexdec($this->responseMessage->addr);

        $sensorUnit = SensorUnit::query()
            ->where('serial_number', $serialNumber)
            ->with(['sensorTypes', 'ponds'])
            ->whereHas('sensorTypes', fn($q) => $q->whereIn('remote_name', $remoteNames))
            ->whereHas('ponds', function ($query) use ($newResponseMessage) {
                $query->whereHas('project', function ($query) use ($newResponseMessage) {
                    $query->where('gateway_serial_number', $newResponseMessage->gateway_serial_number);
                });
            })
            ->firstOrFail();

        $pond = $sensorUnit->ponds->firstOrFail();

        $switchUnit = $pond->switchUnits->firstOrFail();
        $addr = dechex((int)$switchUnit->serial_number);
        self::$publishMessageArr['addr'] = Str::startsWith($addr, '0x') ? $addr : '0x' . $addr;
        self::$switchUnitStatus = $switchUnit->status;
        $project = $pond->project;

        $switchState = array_fill(0, 12, 0);

        $projectID = $project->id;

        self::$mqttData = MqttData::query();
        self::$mqttData = self::$mqttData->create([
            'type' => 'sensor',
            'data_source' => 'mqtt',
            'project_id' => $projectID,
            'data' => json_encode($this->responseMessage),
            'original_data' => __MqttListener::getOriginalMessage(),
            'publish_topic' => $this->topic,
            'publish_message' => json_encode([
                'addr' => $this->responseMessage->addr,
                'type' => $this->responseMessage->type,
                'relay' => implode('', $switchState),
            ])
        ]);

        $sensorUnit
            ->sensorTypes
            ->each(function ($sensorType) use ($sensorUnit, $newResponseMessage, &$switchState) {
                MqttHistoryDataService::mqttDataHistorySave($sensorType, $sensorUnit, $newResponseMessage, $switchState);
            });

        $runTimeSwitchState = $switchState;
        self::changeSwitchStateOfSensorUnit($typeUnit->ponds, $switchState, $runTimeSwitchState);
    }

    public function saveMqttData($responseMessage, $type = 'sensor')
    {
        $newResponseMessage = new stdClass();
        $newResponseMessage->gateway_serial_number = $responseMessage->gw_id;
        $newResponseMessage->type = $type;
        $newResponseMessage->serial_number = hexdec($responseMessage->addr);
        $newResponseMessage->data = $responseMessage->data;

        $remoteNames = collect($responseMessage->data)->keys()->toArray();
        $serialNumber = hexdec($responseMessage->addr);

        $typeUnit = SensorUnit::query()
            ->where('serial_number', $serialNumber)
            ->with(['sensorTypes', 'ponds'])
            ->whereHas('sensorTypes', fn($q) => $q->whereIn('remote_name', $remoteNames))
            ->whereHas('ponds', function ($query) use ($newResponseMessage) {
                $query->whereHas('project', function ($query) use ($newResponseMessage) {
                    $query->where('gateway_serial_number', $newResponseMessage->gateway_serial_number);
                });
            })
            ->firstOrFail();

        $pond = $typeUnit->ponds->firstOrFail();
        $switchUnit = $pond->switchUnits->firstOrFail();
        $project = $pond->project;

        if ($switchUnit->status == 'active' && $switchUnit->run_status == 'on') {

        }
        $addr = dechex((int)$switchUnit->serial_number);
//        self::$feedBackArray['addr'] = Str::startsWith($addr, '0x') ? $addr : '0x' . $addr;
//        self::$switchUnitStatus = $switchUnit->status;


        $switchState = array_fill(0, 12, 0);

        $projectID = $project->id;

        $mqttData = MqttData::query();
        if (self::$isSaveMqttData) {
            $mqttData = $mqttData->create([
                'type' => $type,
                'data_source' => 'mqtt',
                'project_id' => $projectID,
                'data' => json_encode($responseMessage),
                'original_data' => __MqttListener::getOriginalMessage(),
                'publish_topic' => $topic,
                'publish_message' => json_encode([
                    'addr' => $responseMessage->addr,
                    'type' => $responseMessage->type,
                    'relay' => implode('', $switchState),
                ])
            ]);
        }
        self::$mqttData = $mqttData;

        $typeUnit->{$type . 'Types'}
            ->each(
                function ($typeType)
                use ($typeUnit, $type, $responseMessage, &$switchState) {
                    self::saveMqttDataHistory($typeType, $typeUnit, $type, $responseMessage, $switchState);
                }
            );

        $runTimeSwitchState = $switchState;

        if (self::$isSaveMqttData) {
            self::changeSwitchStateOfSensorUnit($typeUnit->ponds, $switchState, $runTimeSwitchState);
        }

        self::$feedBackArray['relay'] = implode('', $runTimeSwitchState);

        // Confirms if the relay is empty or null, if empty or null then set it to 000000000000
        if (!(bool)self::$feedBackArray['relay']) {
            self::$feedBackArray['relay'] = implode('', array_fill(0, 12, 0));
        }
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
