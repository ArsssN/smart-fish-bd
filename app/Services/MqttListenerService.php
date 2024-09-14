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

        $this->currentTime = now()->format('H:i');
        $this->currentDateTime = now()->format('Y-m-d H:i:s');
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
     * @return $this|null
     */
    public function republishLastResponse(): self|null
    {
        if (isset($this->responseMessage->update) && !$this->responseMessage->update) {
            return null;
        }

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

            MqttPublishService::init($publishTopic, $publishMessage->relay, $publishMessage->addr, $previousRelay);
        }

        return $this;
    }

    /**
     * gw_id is gateway_serial_number
     * addr is serial_number
     *
     * @return void
     */
    public function prepareDataSave(): void
    {
        $remoteNames = collect($this->responseMessage->data)->keys()->toArray();
        $serialNumber = hexdec($this->responseMessage->addr);

        MqttHistoryDataService::$sensorUnit = SensorUnit::query()
            ->where('serial_number', $serialNumber)
            ->with(['sensorTypes', 'ponds'])
            ->whereHas('sensorTypes', fn($q) => $q->whereIn('remote_name', $remoteNames))
            ->whereHas('ponds', function ($query) {
                $query->whereHas('project', function ($query) {
                    $query->where('gateway_serial_number', $this->responseMessage->gw_id);
                });
            })
            ->firstOrFail();

        $pond = MqttHistoryDataService::$sensorUnit->ponds->firstOrFail();
        $switchUnit = $pond->switchUnits->firstOrFail();

        $addr = dechex((int)$switchUnit->serial_number);
        self::$publishMessageArr['addr'] = Str::startsWith($addr, '0x') ? $addr : '0x' . $addr;
        MqttPublishService::setPublishMessage(Str::startsWith($addr, '0x') ? $addr : '0x' . $addr, 'addr');

        $switchState = array_fill(0, 12, 0);
        self::$publishMessageArr['relay'] = implode('', $switchState);
        MqttPublishService::setPublishMessage(implode('', $switchState), 'relay');

        self::$switchUnitStatus = $switchUnit->status;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
