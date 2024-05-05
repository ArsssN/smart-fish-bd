<?php

namespace App\Http\Controllers;

use App\Models\MqttData;
use App\Models\Pond;
use App\Models\SensorType;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function abc()
    {
        $mqttData = MqttData::query()->get();
        $sensorTypes = SensorType::query()->get();

        $mqttData->each(function ($mqttDatum) use ($sensorTypes) {
            // sensorType that are not in the mqttDataHistories
            $nonExistentSensorTypes = $sensorTypes->diff($mqttDatum->histories->map(function ($history) {
                return $history->sensorType;
            }));

            if ($mqttDatum->histories->count() === 0) {
                return;
            }

            $history = $mqttDatum->histories->first();

            $newHistories = $nonExistentSensorTypes->map(function ($sensorType) use ($mqttDatum, $history) {
                $pondSensorUnits = $sensorType->sensorUnits()
                    ->with('ponds')
                    ->whereHas(
                        'ponds',
                        function ($query) use ($history) {
                            $query->where('pond_id', $history->pond_id);
                        }
                    )
                    ->get();

                $_newHistories = [
                    'mqtt_data_id' => $mqttDatum->id,
                    'pond_id' => $history->pond_id,
                    'sensor_unit_id' => null,
                    'sensor_type_id' => $sensorType->id,
                    'value' => null,
                    'message' => null,
                    'created_at' => $mqttDatum->created_at,
                    'updated_at' => $mqttDatum->updated_at,
                    'deleted_at' => null,
                ];

                $newHistories = [];

                $pondSensorUnits->each(function ($pondSensorUnit) use (&$newHistories, $_newHistories) {
                    $newHistories[] = [
                        'sensor_unit_id' => $pondSensorUnit->id,
                        ...$_newHistories
                    ];
                });

                if(count($newHistories) === 0) {
                    $newHistories[] = $_newHistories;
                }

                dd(
                    $history->pond_id,
                    $sensorType->id,
                    $pondSensorUnits,
                    $_newHistories,
                    $newHistories,
                );

                return $newHistories;
            });

            dd($mqttDatum->histories->toArray(), $nonExistentSensorTypes->pluck('id')->toArray(), $newHistories);
        });

        dd('abc', $mqttData->toArray());
    }

    public function machine()
    {
        $breadcrumbs = [
            "Admin" => url('admin/dashboard'),
            "Reports" => false,
            "Machine" => false
        ];

        $ponds = Pond::query()->get(['name', 'id']);

        if (!request()->has('pond_id') && $ponds->count() > 0) {
            return redirect()->route('reports.machine.index', ['pond_id' => $ponds->first()->id]);
        }

        $pond_id = request()->get('pond_id');
        $start_date = request()->get('start_date') ?? Carbon::now()->startOfWeek()->format('Y-m-d');
        $end_date = request()->get('end_date') ?? Carbon::now()->format('Y-m-d');

        $defaultSensors = SensorType::$defaultSensors;
        $sensors = SensorType::query()
            ->whereIn('remote_name', $defaultSensors)
            ->get([
                'id',
                'name',
                'remote_name'
            ]);
        if (!request()->has('sensors')) {
            return redirect()->route(
                'reports.machine.index',
                [...request()->all(), Arr::query(['sensors' => $defaultSensors])]
            );
        }
        $remote_names = request()->get('sensors');

        $colors = [
            'tds' => 'blue',
            'temp' => 'red',
            'ph' => 'purple',
            'do' => 'yellow',
            'o2' => 'green',
            'food' => 'orange',
            'rain' => 'cyan',
        ];

        $labelList = [
            'o2' => 'DO Level',
            'tds' => 'TDS',
            'temp' => 'Water Temperature',
        ];
        $defaultConfig = [
            'backgroundColor' => 'black',
            'borderColor' => 'black',
            'borderWidth' => 1,
            'tension' => 0.3,
        ];

        //$this->abc();

        $graphData = SensorType::query()
            ->whereIn('remote_name', $remote_names)
            ->with('mqttDataHistories', function ($query) use ($pond_id, $start_date, $end_date) {
                $query->where('pond_id', $pond_id)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->orderBy('created_at', 'asc');
            })
            ->latest()
            ->get()
            ->map(function ($sensorType) use ($colors, $labelList, $defaultConfig) {
                $data = $sensorType->mqttDataHistories->map(function ($mqttDataHistory) {
                    return [
                        'x' => $mqttDataHistory->created_at->format('Y-m-d H:i:s'),
                        'y' => $mqttDataHistory->value
                    ];
                });

                $config = [
                    ...$defaultConfig,
                    'backgroundColor' => $colors[$sensorType->remote_name] ?? 'black',
                    'borderColor' => $colors[$sensorType->remote_name] ?? 'black',
                ];

                return [
                    'label' => $labelList[$sensorType->remote_name] ?? $sensorType->name,
                    'data' => $data,
                    ...$config
                ];
            });

        //dd($graphData->toArray());

        $labels = $graphData->reduce(function ($carry, $item) {
            if (count($carry) <= $item['data']->count()) {
                return $item['data']->pluck('x')->toArray();
            } else {
                return $carry;
            }
        }, []);

        return view(
            'admin.reports.machine',
            compact(
                'breadcrumbs',
                'graphData',
                'labels',
                'ponds',
                'sensors'
            )
        );
    }
}
