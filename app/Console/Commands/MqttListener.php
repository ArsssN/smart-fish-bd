<?php

namespace App\Console\Commands;

use App\Http\Controllers\MqttCommandController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
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
        $mqtt->subscribe('#', function (string $topic, string $message) {
//            Log::info("'Received message on topic [%s]: %s',$topic, $message");
//            echo sprintf('Received message on topic [%s]: %s', $topic, $message);
            $this->topic = $topic;
            $this->message = $message;

//            $feedBackMessage = $this->processResponse();
            $feedBackMessage = '$this->processResponse()';
//            Log::info("'Send message on topic [%s]: %s',$this->topic, $feedBackMessage");
//            echo sprintf("Send message on topic [%s]: %s", $this->topic, $feedBackMessage);
            MQTT::publish($this->topic, $feedBackMessage);
        });

        $mqtt->loop(true);
        return Command::SUCCESS;
    }

    /**
     * Process the response from the MQTT server.
     *
     * @return string
     */
    private function processResponse(): string
    {
        // $responseMessage =
        //  json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","data":{"food":42,"tds":123.45,"rain":17,"temp":29.7,"o2":2.8,"ph":6}}');
        $responseMessage = json_decode($this->message);
        $feedBackMessage = '';

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

        return $feedBackMessage;
    }
}
