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

Route::get('/', function () {
    $jsoDec = json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","food":42,"tds":123.45,"rain":17,"temp":25.7,"o2":7.8,"ph":6}');
    if ($jsoDec->type == 'sen') {

    }
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
