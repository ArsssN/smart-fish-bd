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
Route::get('/test', function () {
    $topic = 'SUB/1E4F/PUB';
    $isUpdate = false;
    $responseMessage =
//        json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","data":{"food":42,"tds":123.45,"rain":17,"temp":28.7,"o2":2.8,"ph":6}}');
//        json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","data":{"ph":6}}');
        json_decode('{"update":1}');

    $feedBackMessage = '';

    if (isset($responseMessage->update)) {
        $isUpdate = true;
        $gateway_serial_number_last_4digit = Str::before(Str::after($topic, '/'), '/');
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

    try {
        if (!$isUpdate) {
            switch ($responseMessage->type) {
                case 'sen':
                    $feedBackMessage = MqttCommandController::saveMqttData('sensor', $responseMessage, '');
                    break;
                case 'swi':
                    $feedBackMessage = MqttCommandController::saveMqttData('switch', $responseMessage, '');
                    break;
                default:
                    break;
            }
        }

        $feedBackArr['relay'] = $feedBackMessage;

        if ($feedBackArr['relay'] !== implode(', ', array_fill(0, 12, 0))) {
            dump('publish');
            if (!$isUpdate) {
                $feedBackArr['relay'] = implode('', explode(', ', $feedBackArr['relay']));
                MqttCommandController::$mqttData->publish_message = json_encode($feedBackArr);
                MqttCommandController::$mqttData->save();
                dump(MqttCommandController::$mqttData);
            }
            // MQTT::publish($this->topic, json_encode($feedBackArr));
            dump($feedBackMessage, $feedBackArr, $responseMessage);
        } else {
            dump('No relay message', $feedBackArr);
        }
        return phpinfo();
    } catch (Exception $e) {
        Log::error($e->getMessage());
        return sprintf('[%s] %s', now(), $e->getMessage());
    }
});

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
