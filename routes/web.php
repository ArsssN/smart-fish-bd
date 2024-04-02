<?php

use App\Models\Project;
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
Route::post(
    '/contact/submit',
    [\App\Http\Controllers\ContactUsController::class, 'submitContactUs']
)->name('contact.submit');

// php info
Route::get('/test', function () {
    $jsonDec =
//        json_decode('{"gw_id":"4A5B3C2D1E4F","type":"sen","addr":"0x1A","data":{"food":42,"tds":123.45,"rain":17,"temp":25.7,"o2":2.8,"ph":6}}');
        json_decode('{"gw_id":"EFWE4ASDF2SS","type":"swi","addr":"0x1B","data":{"food":42,"tds":123.45,"rain":17,"temp":25.7,"o2":2.8,"ph":6}}');

    switch ($jsonDec->type) {
        case 'sen':
            saveMqttData('sensor', $jsonDec);
            break;
        case 'swi':
            saveMqttData('switch', $jsonDec);
            break;
        default:
            break;
    }

    return phpinfo();
});

function saveMqttData($type, $jsonDec): void
{
    $remoteNames = collect($jsonDec->data)->keys()->toArray();

    $serialNumber = hexdec($jsonDec->addr);
    $project      = Project::query()
        ->where('gateway_serial_number', $jsonDec->gw_id)
        ->with('ponds', function ($query) use ($type, $serialNumber, $remoteNames) {
            $query->whereHas("{$type}Units", function ($query) use ($type, $serialNumber, $remoteNames) {
                $query->where('serial_number', $serialNumber)
                    ->whereHas("{$type}Types", function ($query) use ($remoteNames) {
                        $query->whereIn('remote_name', $remoteNames);
                    });
            })->with("{$type}Units.{$type}Types");
        })
        ->firstOrFail();

    $projectID = $project->id;
    $mqttData  = \App\Models\MqttData::query()->create([
        'type'       => $type,
        'project_id' => $projectID,
        'data'       => json_encode($jsonDec),
    ]);
    $project->ponds->each(function ($pond) use ($type, $jsonDec, $mqttData) {
        $pondID    = $pond->id;
        $typeUnits = "{$type}Units";
        $pond->$typeUnits->each(function ($typeUnit) use ($type, $jsonDec, $mqttData, $pondID) {
            $typeUnitID = $typeUnit->id;
            $typeTypes  = "{$type}Types";
            $typeUnit->$typeTypes->each(function ($typeType) use ($type, $jsonDec, $mqttData, $pondID, $typeUnitID) {
                $typeTypeID = $typeType->id;
                $remoteName = $typeType->remote_name;
                $value      = $jsonDec->data->$remoteName;

                $typeName         = Str::replace(' ', '', $typeType->name);
                $helperMethodName = "get{$typeName}Update";

                if (function_exists($helperMethodName)) {
                    $type_message = ($helperMethodName(
                        $value,
                    ));

                    // if array
                    if (is_array($type_message)) {
                        $type_message = implode(', ', $type_message);
                    }
                } else {
                    $type_message = "No helper method found for $type: {$typeType->name}";
                }

                $mqttData->histories()->create([
                    'pond_id'         => $pondID,
                    "{$type}_unit_id" => $typeUnitID,
                    "{$type}_type_id" => $typeTypeID,
                    'value'           => $value,
                    'type'            => $type,
                    'message'         => $type_message,
                ]);
            });

            die();
        });
    });
}

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
