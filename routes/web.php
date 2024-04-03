<?php

use App\Http\Controllers\MqttCommandController;
use App\Models\Sensor;
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
    $responseMessage =
        json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","data":{"food":42,"tds":123.45,"rain":17,"temp":28.7,"o2":2.8,"ph":6}}');
    // $responseMessage = json_decode($this->message);
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

    dump('$feedBackMessage', $feedBackMessage);

    return phpinfo();
});

Route::get('/test/sensors', function () {
    $sensors        = Sensor::all();
    $sensor_message = null;

    if (request()->has('sensor_id')) {
        $sensor_id  = request()->get('sensor_id');
        $sensorType = Sensor::query()->findOrFail($sensor_id)->sensorType;

        $sensorName       = Str::replace(' ', '', $sensorType->name);
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
