<?php

namespace App\Http\Controllers;

use App\Console\Commands\AeratorManageCommand;
use App\Console\Commands\__MqttListener;
use App\Http\Controllers\Admin\BackupController;
use App\Jobs\CustomerCreateJob;
use App\Models\MqttDataSwitchUnitHistoryDetail;
use App\Models\Sensor;
use App\Models\SwitchUnitSwitch;
use App\Models\User;
use App\Services\MqttListenerService;
use App\Services\MqttStoreService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TestController extends Controller
{
    //home
    public function home()
    {
        return view('test.home');
    }

    //mqtt
    public function mqtt()
    {
        $topic = request()->get('topic');
        $responseMessage = json_decode(json_encode(request()->except('topic')));
        $currentTime = request()->get('currentTime') ?? now()->format('H:i');

        $autoFill = json_decode('{
                "gw_id": "3083987D2528",
                "type": "sen",
                "addr": "0x1A",
                "data": {
                    "food": 3,
                    "tds": 120.88,
                    "rain": 1,
                    "temp": 32.56,
                    "o2": 1.5,
                    "ph": 4
                }
            }'
        );
        // json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","data":{"food":42,"tds":123.45,"rain":17,"temp":28.7,"o2":2.8,"ph":6}}');
        // json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","data":{"ph":6}}');
        // json_decode('{"update":1}');
        $autoFill->topic = 'SUB/1E4F/PUB';

        $publishable = false;
        $isUpdate = request()->get('update') ?? false;

        try {
            if (request()->get('gw_id') || $isUpdate) {
                $mqttListenerService = new MqttListenerService($topic, json_encode($responseMessage));
                $preparedData = $mqttListenerService
                    ->setUpdate($isUpdate)
                    ->setTestMode()
                    ->republishLastResponse()
                    ?->convertDOValue()
                    ?->prepareData();

                dump($preparedData);

                MqttStoreService::init($topic, $mqttListenerService::$mqttData, $mqttListenerService::$switchUnit, $mqttListenerService::$historyDetails, 'mqtt')
                    ->mqttDataSave()
                    ->mqttDataHistoriesSave()
                    ->mqttDataSwitchUnitHistorySave()
                    ->mqttDataSwitchUnitHistoryDetailsSave()
                    ->switchUnitSwitchesStatusUpdate();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        $publishMessage = MqttCommandController::$feedBackArray;
        $isAlreadyPublished = MqttCommandController::$isAlreadyPublished;

        return view(
            'test.mqtt',
            compact(
                'publishMessage',
                'autoFill',
                'publishable',
                'isAlreadyPublished',
                'isUpdate',
                'currentTime'
            )
        );
    }

    // aerator-manage
    public function aeratorManage()
    {
        $aeratorManageCommand = new AeratorManageCommand();
        $aeratorManageCommand->handle();

        $message = 'Aerator managed';
        Session::flash('message', $message);
        return redirect()->back();
    }

    //sensors
    public function sensors()
    {
        $sensors = Sensor::all();
        $sensor_message = null;

        if (request()->has('sensor_id')) {
            $sensor_id = request()->get('sensor_id');
            $sensorType = Sensor::query()->findOrFail($sensor_id)->sensorType;

            $sensorName = Str::replace(' ', '', $sensorType->name);
            $helperMethodName = "get{$sensorName}Update";

            if (function_exists($helperMethodName)) {
                $sensor_message = ($helperMethodName(
                    request()->get('value', 0),
                ));
            } else {
                $sensor_message = "No helper method found for sensor: {$sensorType->name}";
            }
        }

        if (is_array($sensor_message)) {
            $sensor_message = implode(', ', $sensor_message);
        }

        return view('test.sensors', compact('sensors', 'sensor_message'));
    }

    //removeSeed
    public function removeSeed()
    {
        $backupController = new BackupController();
        $message = $backupController->removeSeed();

        $html = "<h2>{$message->original['message']}</h2>";

        $html .= "<ul>";
        foreach (($message->original['data'] ?? []) as $tableName) {
            $html .= "<li>" . $tableName . "</li>";
        }
        $html .= "</ul>";
        Session::flash('message', $html);

        return redirect()->back();
    }

    //mail
    public function mail()
    {
        $user = User::query()->where('email', 'afzalbd1@gmail.com')->first();
        $password = Str::random(8);

        CustomerCreateJob::dispatch($password, $user->email);

        $message = 'Notification sent';
        Session::flash('message', $message);

        return redirect()->back();
    }

    //convert-switches
    public function convertSwitches()
    {
        /*
         * Checking of run time in seconds
         * $aHistoryDetail = \App\Models\MqttDataSwitchUnitHistoryDetail::query()
            ->where([
                'history_id' => 356,
                'switch_type_id' => 1,
            ])
            ->orderByDesc('created_at')
            ->first();
        dd($aHistoryDetail->toArray());
        */

        $switch_units = DB::table('switch_units')->get();

        DB::table('switch_unit_switches')->truncate();
        foreach ($switch_units as $switch_unit) {
            $switches = json_decode($switch_unit->switches, true);

            foreach ($switches as $switchDetail) {
                $detail = [
                    'switch_unit_id' => $switch_unit->id,
                    'number' => $switchDetail['number'],
                    'switchType' => $switchDetail['switchType'] == 1 ? 1 : 2,
                    'status' => $switchDetail['status'],
                    'comment' => $switchDetail['comment'],
                    'created_at' => $switch_unit->created_at,
                ];
                SwitchUnitSwitch::query()->create($detail);
            }
        }

        $message = 'Switches converted';
        Session::flash('message', $message);

        return redirect()->back();
    }
}
