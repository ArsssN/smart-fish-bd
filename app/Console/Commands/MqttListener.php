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
                    $feedBackArr['relay'] = implode('', explode(', ', $feedBackArr['relay']));
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
        // $responseMessage =
        //  json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","data":{"food":42,"tds":123.45,"rain":17,"temp":29.7,"o2":2.8,"ph":6}}');
        $responseMessage = json_decode($this->message);
        $feedBackMessage = '';
        $feedBackArr = [
            'addr' => $responseMessage->addr,
            'type' => $responseMessage->type,
        ];

        switch ($responseMessage->type) {
            case 'sen':
                $feedBackMessage = MqttCommandController::saveMqttData('sensor', $responseMessage);
                break;
            case 'swi':
                $feedBackMessage = MqttCommandController::saveMqttData('switch', $responseMessage);
                break;
            default:
                break;
        }

        $feedBackArr['relay'] = $feedBackMessage;

        return $feedBackArr;
    }
}
