<?php

use App\Models\Sensor;
use App\Models\SensorType;
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

use PhpMqtt\Client\Facades\MQTT;
Route::get('/', function () {

    MQTT::publish('some/topic1', 'Hello World!');
    return view('welcome');
});

Route::get('/some/topic1', function () {
    // Create an MQTT client instance
    $mqtt = MQTT::connection();

    // Subscribe to the topic
    $mqtt->subscribe('some/topic1', function (string $topic, string $message) {
        // Handle the received message
        Log::info(sprintf('Received message on topic [%s]: %s', $topic, $message));
    }, 1);

    // Start the MQTT event loop
    $mqtt->loop(true);

    // Log a message for testing purposes
    Log::info('MQTT event loop started');

    // Return a response (you may not need to return a view, depending on your application)
    return view('welcome');
});

// php info
/*Route::get('/phpinfo', function () {
    return phpinfo();
});*/

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
