<?php

use App\Models\Sensor;
use App\Models\SensorType;
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
