<?php

use App\Console\Commands\MqttListener;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Api\SwitchUnitController;
use App\Http\Controllers\MqttCommandController;
use App\Jobs\CustomerCreateJob;
use App\Models\MqttDataSwitchUnitHistoryDetail;
use App\Models\Sensor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/test', function () {
    return view('test.home');
})->name('test.home');

Route::get('/test/mqtt', function () {
    $topic = request()->get('topic');
    $responseMessage =
        json_decode(json_encode(request()->except('topic')));

    $autoFill =
        json_decode('{
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
        }');
    // json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","data":{"food":42,"tds":123.45,"rain":17,"temp":28.7,"o2":2.8,"ph":6}}');
    // json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","data":{"ph":6}}');
    // json_decode('{"update":1}');
    $autoFill->topic = 'SUB/1E4F/PUB';

    $publishable = false;
    $isUpdate = request()->get('update') ?? false;

    try {
        if (request()->get('gw_id') || $isUpdate) {
            $mqttListener = new MqttListener();

            $mqttListener->setMessage(json_encode($responseMessage));
            $mqttListener->setTopic($topic);
            $mqttListener->setIsTest(true);

            $publishable = $mqttListener->processResponse();
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
            'isUpdate'
        )
    );
})->name('test.mqtt');

Route::get('/test/sensors', function () {
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
})->name('test.sensors');

Route::get('/test/remove-seed', function () {
    $backupController = new BackupController();

    return response()->json($backupController->removeSeed());
})->name('test.remove-seed');

Route::get('/test/mail', function () {
    $user = User::query()->where('email', 'afzalbd1@gmail.com')->first();
    $password = Str::random(8);

    CustomerCreateJob::dispatch($password, $user->email);

    return 'Notification sent';
})->name('test.mail');

// test route to convert mqtt_data_switch_unit_histories switches to a separate table mqtt_data_switch_unit_history_details
Route::get('/test/convert-switches', function () {
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

    $switch_unit_histories = DB::table('mqtt_data_switch_unit_histories')->get();

    DB::table('mqtt_data_switch_unit_history_details')->truncate();
    foreach ($switch_unit_histories as $switch_unit_history) {
        $switches = json_decode($switch_unit_history->switches, true);

        foreach ($switches as $switchDetail) {
            $detail = [
                'history_id' => $switch_unit_history->id,
                'number' => $switchDetail['number'],
                'switch_type_id' => $switchDetail['switchType'] == 1 ? 1 : 2,
                'status' => $switchDetail['status'],
                'comment' => $switchDetail['comment'],
                'created_at' => $switch_unit_history->created_at,
            ];
            MqttDataSwitchUnitHistoryDetail::query()->create($detail);
        }
    }

    return 'Switches converted';
})->name('test.convert-switches');
