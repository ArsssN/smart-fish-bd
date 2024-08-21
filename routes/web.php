<?php

use App\Http\Controllers\MqttCommandController;
use App\Jobs\CustomerCreateJob;
use App\Models\Sensor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Controllers\HomeController::class);
Route::post(
    '/contact/submit',
    [\App\Http\Controllers\ContactUsController::class, 'submitContactUs']
)->name('contact.submit');

// php info
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
            $mqttListener = new \App\Console\Commands\MqttListener();

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

    if(is_array($sensor_message)) {
        $sensor_message = implode(', ', $sensor_message);
    }

    return view('test.sensors', compact('sensors', 'sensor_message'));
});

// home redirect to /
Route::get('/home', function () {
    return redirect('/');
});

Route::get('/test/remove-seed', function () {
    $backupController = new \App\Http\Controllers\Admin\BackupController();

    return response()->json($backupController->removeSeed());
});

Route::get('/test/mail', function () {
    $user = \App\Models\User::query()->where('email', 'afzalbd1@gmail.com')->first();
    $password = Str::random(8);

    CustomerCreateJob::dispatch($password, $user->email);

    return 'Notification sent';
});
