<?php

namespace App\Console\Commands;

use App\Http\Controllers\MqttCommandController;
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
    protected $message;

    /**
     * The topic to be subscribed to.
     *
     * @var string
     */
    protected $topic;

    /**
     * The flag to check if the message is an update.
     *
     * @var bool
     */
    protected $isUpdate = false;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mqtt = MQTT::connection();
        $mqtt->subscribe('SFBD/+/PUB', function (string $topic, string $message) {
            $currentDateTime = now()->format('Y-m-d H:i:s');
            Log::info("Received message on topic [$topic]: $message");
            echo sprintf('[%s] Received message on topic [%s]: %s', $currentDateTime, $topic, $message);
            $this->topic = Str::replaceLast('/PUB', '/SUB', $topic);
            $this->message = $message;

            try {
                $feedBackArr = $this->processResponse();
                Log::info("Send message on topic [$this->topic]: " . $feedBackArr['relay']);
                echo sprintf(
                    '[%s] Send message on topic [%s]: %s',
                    $currentDateTime,
                    $this->topic,
                    $feedBackArr['relay']
                );

                if ($feedBackArr['relay'] !== implode(', ', array_fill(0, 12, 0))) {
                    if (!$this->isUpdate) {
                        $feedBackArr['relay'] = implode('', explode(', ', $feedBackArr['relay']));
                        MqttCommandController::$mqttData->publish_message = json_encode($feedBackArr);
                        MqttCommandController::$mqttData->save();
                    }

                    MQTT::publish($this->topic, json_encode($feedBackArr));
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                echo sprintf('[%s] %s', $currentDateTime, $e->getMessage());
            }
        });

        $mqtt->loop(true);
        return Command::SUCCESS;
    }

    /**
     * Process the response from the MQTT server.
     *
     * @return array
     */
    private function processResponse(): array
    {
        $this->isUpdate = false;
        $responseMessage = json_decode($this->message);
        $feedBackMessage = '';

        if (isset($responseMessage->update)) {
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
            $feedBackMessage = $publishMessage->relay ?? implode('', array_fill(0, 12, 0));
        }

        $feedBackArr = [
            'addr' => $responseMessage->addr,
            'type' => $responseMessage->type,
        ];

        if (!$this->isUpdate) {
            switch ($responseMessage->type) {
                case 'sen':
                    $feedBackMessage = MqttCommandController::saveMqttData('sensor', $responseMessage, $this->topic);
                    break;
                case 'swi':
                    $feedBackMessage = MqttCommandController::saveMqttData('switch', $responseMessage, $this->topic);
                    break;
                default:
                    break;
            }
        }

        $feedBackArr['relay'] = $feedBackMessage;

        return $feedBackArr;
    }
}
