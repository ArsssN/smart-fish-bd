<?php

namespace App\Services;

use App\Console\Commands\MqttListener;
use App\Http\Controllers\MqttCommandController;
use App\Models\MqttData;
use App\Models\Project;
use App\Models\SensorUnit;
use App\Models\SwitchUnit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpMqtt\Client\Facades\MQTT;

class MqttListenerService
{
    /**
     * The message to be displayed when the command is executed.
     *
     * @var string
     */
    protected string $message;

    /**
     * The original message.
     *
     * @var string
     */
    protected static string $originalMessage;

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

    public function processResponse($message, $topic)
    {
        $this->currentTime = now()->format('H:i');
        $this->currentDateTime = now()->format('Y-m-d H:i:s');

        $this->topic = Str::replaceLast('/PUB', '/SUB', $topic);
        $this->message = $message;

        self::$originalMessage = $message;
        $responseMessage = json_decode($this->message);

        if (isset($responseMessage->update)) {
            return $this->isUpdateResponse();
        }

        if (isset($responseMessage->data->o2) && $responseMessage->data->o2 < 1.5) {
            $o2 = convertDOValue($responseMessage->data->o2, $this->currentTime);
            $echo = 'Converted DO value: from ' . $responseMessage->data->o2 . ' to ' . $o2 . ' at ' . $this->currentTime . '<br>';;
            Log::channel('mqtt_listener')->info($echo);

            $responseMessage->data->o2 = $o2;
        }

        return $this->saveMqttData($responseMessage);
    }

    /**
     * @return void
     */
    public function isUpdateResponse(): void
    {
        sleep(2);
        $gatewaySerialNumberLast4Digit = Str::before(Str::after($this->topic, '/'), '/');
        $project = Project::select('id')->with('mqttDataLast:id,publish_topic,publish_message')
            ->where('gateway_serial_number', 'LIKE', "%{$gatewaySerialNumberLast4Digit}")
            ->firstOrFail();

        $mqttData = $project->mqttData;
        $publishMessage = json_decode($mqttData->publish_message ?? '{}');
        $publishTopic = $mqttData->publish_topic;
        $previousRelay = $publishMessage->relay
            ?: implode('', array_fill(1, 12, 0));

        //TODO::history data save

        MqttPublishService::relayPublish($previousRelay, '', $publishTopic, $publishMessage->addr);
    }


    public function saveMqttData($responseMessage, $type = 'sensor')
    {
        $newResponseMessage = new \stdClass();
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

        if ($switchUnit->status =='active' && $switchUnit->run_status == 'on'){

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
                'original_data' => MqttListener::getOriginalMessage(),
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
}
