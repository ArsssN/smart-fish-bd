<?php

namespace App\Console\Commands;

use App\Services\MqttStoreService;
use App\Services\MqttListenerService;
use App\Services\MqttPublishService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpMqtt\Client\Exceptions\DataTransferException;
use PhpMqtt\Client\Exceptions\InvalidMessageException;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\Exceptions\ProtocolViolationException;
use PhpMqtt\Client\Exceptions\RepositoryException;
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
     * Execute the console command.
     *
     * @return int - the status code
     */
    public function handle(): int
    {
        $mqtt = MQTT::connection();
        try {
            $mqtt->subscribe('SFBD/+/PUB', function (string $topic, string $message) {
                $this->currentTime = now()->format('H:i');
                $this->currentDateTime = now()->format('Y-m-d H:i:s');
                $this->setTopic(Str::replaceLast('/PUB', '/SUB', $topic));
                $this->message = $message;

                Log::channel('mqtt_listener')->info("Received message on topic [$topic]: $message");
                echo sprintf('[%s] Received message on topic [%s]: %s', $this->currentDateTime, $topic, $message);

                try {
                    DB::beginTransaction();
                    $mqttListenerService = (new MqttListenerService($this->topic, $message));
                    $mqttListenerService
                        ->republishLastResponse()
                        ?->convertDOValue()
                        ?->prepareData();

                    if (isset($mqttListenerService::$switchUnit->run_status) && $mqttListenerService::$switchUnit->run_status == 'off') {
                        Log::channel('mqtt_listener')->info("Switch: {$mqttListenerService::$switchUnit->name} unit is off");
                        return;
                    }

                    /**
                     * mqtt publish
                     *
                     * Publish must be before store if present.
                     */
                    if ($mqttListenerService::checkIfPublishable()) {
                        MqttPublishService::relayPublish();
                    }

                    /**
                     * mqtt data and history data save.
                     *
                     * Store must be after mqtt publish if present.
                     */
                    if ($mqttListenerService::checkIfSavable()) {
                        MqttStoreService::init($this->topic, $mqttListenerService::$mqttDataInstance, $mqttListenerService::$switchUnit, $mqttListenerService::$historyDetails)
                            ->mqttDataSave()
                            ->mqttDataHistoriesSave()
                            ->mqttDataSwitchUnitHistorySave()
                            ->switchUnitSwitchesStatusUpdate();
                    }
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    Log::channel('mqtt_listener')->error($e->getMessage());
                    echo sprintf('[%s] %s', $this->currentDateTime, $e->getMessage());
                }
            });
        } catch (DataTransferException|RepositoryException $e) {
            Log::channel('mqtt_listener')->error($e->getMessage());
            echo sprintf('[%s] %s', $this->currentDateTime, $e->getMessage());
        }

        try {
            $mqtt->loop();
        } catch (DataTransferException|InvalidMessageException|ProtocolViolationException|MqttClientException $e) {
            Log::channel('mqtt_listener')->error($e->getMessage());
            echo sprintf('[%s] %s', $this->currentDateTime, $e->getMessage());
        }

        return Command::SUCCESS;
    }

    public function setTopic(string $topic): void
    {
        $this->topic = $topic;
    }
}
