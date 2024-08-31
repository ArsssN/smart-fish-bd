<?php

namespace App\Console\Commands;

use App\Http\Controllers\MqttCommandController;
use App\Models\MqttData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpMqtt\Client\Facades\MQTT;

class MqttListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe To MQTT topic';

    /**
     * The message to be displayed when the command is executed.
     *
     * @var string
     */
    protected string $message;

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
     * The current date time.
     *
     * @var string $currentDateTime - current date time
     */
    protected string $currentDateTime;

    /**
     * Execute the console command.
     *
     * @return int - the status code
     */
    public function handle(): int
    {
        $mqtt = MQTT::connection();
        $mqtt->subscribe('SFBD/+/PUB', function (string $topic, string $message) {
            $this->currentDateTime = now()->format('Y-m-d H:i:s');
            Log::info("Received message on topic [$topic]: $message");
            echo sprintf('[%s] Received message on topic [%s]: %s', $this->currentDateTime, $topic, $message);
            $this->topic = Str::replaceLast('/PUB', '/SUB', $topic);
            $this->message = $message;

            try {
                if ($this->processResponse()) {
                    MQTT::publish($this->topic, json_encode(MqttCommandController::$feedBackArray));
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                echo sprintf('[%s] %s', $this->currentDateTime, $e->getMessage());
            }
        });

        $mqtt->loop(true);
        return Command::SUCCESS;
    }

    /**
     * Process the response from the MQTT server.
     *
     * @return bool
     */
    public function processResponse(): bool
    {
        $this->currentDateTime = $this->currentDateTime ?? now()->format('Y-m-d H:i:s');
        $this->isUpdate = false;
        $responseMessage = json_decode($this->message);

        if (isset($responseMessage->data->o2) && $responseMessage->data->o2 < 1.5) {
            $o2 = convertDOValue($responseMessage->data->o2);
            $echo = "Converted DO value: from " . $responseMessage->data->o2 . " to " . $o2;
            echo $echo;
            Log::info($echo);
            $responseMessage->data->o2 = $o2;
        }

        if ($this->isTest) {
            MqttCommandController::$isSaveMqttData = false;
        }

        if (isset($responseMessage->update)) {
            sleep(2);
            $this->isUpdate = true;
            $gateway_serial_number_last_4digit = Str::before(Str::after($this->topic, '/'), '/');
            $project = \App\Models\Project::query()
                ->where('gateway_serial_number', 'LIKE', "%{$gateway_serial_number_last_4digit}")
                ->firstOrFail();
            $mqtt_data = $project->mqttData()
                //->whereNotNull('publish_message')
                ->orderBy('id', 'desc')
                ->firstOrFail();
            $responseMessage = json_decode($mqtt_data->data);
            $publishMessage = json_decode($mqtt_data->publish_message);
            MqttCommandController::$feedBackArray['relay'] = $publishMessage->relay
                ?? implode('', array_fill(0, 12, 0));
        }

        if (!$this->isUpdate) {
            switch ($responseMessage->type) {
                case 'sen':
                    MqttCommandController::saveMqttData('sensor', $responseMessage, $this->topic);
                    break;
                case 'swi':
                    MqttCommandController::saveMqttData('switch', $responseMessage, $this->topic);
                    break;
                default:
                    break;
            }
        }

        $feedBackArr = MqttCommandController::$feedBackArray;
        Log::info("Send message on topic [$this->topic]: " . $feedBackArr['relay']);
        if (!$this->isTest) {
            echo sprintf(
                '[%s] Send message on topic [%s]: <strong>%s</strong>',
                $this->currentDateTime,
                $this->topic,
                $feedBackArr['relay']
            );
            echo '<br/>';
        }

        $publishable = false;

        if ($feedBackArr['relay'] !== implode(', ', array_fill(0, 12, 0))) {
            if (!$this->isUpdate) {
                $feedBackArr['relay'] = implode('', explode(', ', $feedBackArr['relay']));

                if (MqttCommandController::$isSaveMqttData) {
                    MqttCommandController::$mqttData->publish_message = json_encode($feedBackArr);
                    MqttCommandController::$mqttData->save();
                }
            }
            if (
                $this->isUpdate
                || (
                    $responseMessage->type == 'sen'
                    && !empty($responseMessage->data)
                    && empty($responseMessage->relay)
                )
            ) {
                $publishable = true;
            }

        }

        MqttCommandController::$isAlreadyPublished = false;
        if ($publishable && !$this->isUpdate) {
            $previousMqttData = MqttData::query()
                ->where('project_id', MqttCommandController::$mqttData->project_id)
                ->where('id', '!=', MqttCommandController::$mqttData->id)
                ->latest()
                ->first();

            $publishable = (MqttCommandController::$feedBackArray['relay'] ?? '')
                !== (json_decode($previousMqttData->publish_message, true)['relay'] ?? '');

            if (!$publishable) {
                MqttCommandController::$isAlreadyPublished = true;

                Log::info("Already published message on topic [$this->topic]: " . $feedBackArr['relay']);
                if (!$this->isTest) {
                    echo sprintf(
                        '[%s] Already published message on topic [%s], mqtt data id: <strong>%d</strong>',
                        $this->currentDateTime,
                        $this->topic,
                        $previousMqttData->id
                    );
                }
            }
        }

        if (MqttCommandController::$switchUnitStatus !== 'active') {
            $publishable = false;
        }

        return $publishable;
    }

    public function setIsUpdate(bool $isUpdate): void
    {
        $this->isUpdate = $isUpdate;
    }

    public function setTopic(string $topic): void
    {
        $this->topic = $topic;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setIsTest(bool $isTest): void
    {
        $this->isTest = $isTest;
    }
}
