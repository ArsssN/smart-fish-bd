<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// php info
/*Route::get('/phpinfo', function () {
    return phpinfo();
});*/

Route::get('/test/sensors', function () {
    $sensors = \App\Models\Sensor::all();

//    dd($sensors->toArray(), request()->all());
    $sensor_message = null;

    if (request()->has('sensor_id')) {
        $sensor_id = request()->get('sensor_id');
        $sensor = \App\Models\Sensor::query()->find($sensor_id);

        $sensorName = \Illuminate\Support\Str::replace(' ', '', $sensor->name);
        $helperMethodName = "get{$sensorName}Update";

        if (function_exists($helperMethodName)) {
            $sensor_message = ($helperMethodName(
                request()->get('value', 0),
            ));
        } else {
            $sensor_message = "No helper method found for sensor {$sensor->name}";
        }
    }

    return view('test.sensors', compact('sensors', 'sensor_message'));
});
