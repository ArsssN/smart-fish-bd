<?php

namespace App\Http\Controllers;

use App\Models\MqttDataHistory;
use App\Models\MqttDataSwitchUnitHistoryDetail;
use App\Models\Pond;
use App\Models\SensorType;
use Backpack\CRUD\app\Library\Widget;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function machine()
    {
        $title = "Machine Report";

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
        $start_date = request()->get('start_date') ?? Carbon::now()->startOfDay()->format('Y-m-d H:i');
        $end_date = request()->get('end_date') ?? Carbon::now()->endOfDay()->format('Y-m-d H:i');

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
            'ph' => 'pH Level',
        ];

        $sensorTypes = SensorType::query()
            ->whereIn('remote_name', $remote_names)
            ->latest();

        $sensorTypeAverageData = getSensorTypesAverageBasedOnTime(
            MqttDataHistory::query()->where('pond_id', $pond_id),
            $start_date,
            $end_date
        );
        $sensorTypeAverages = (clone $sensorTypes->get())
            ->map(function ($sensorType) use ($sensorTypeAverageData) {
                $sensorAvg = new \stdClass();
                $sensorAvg->avg = $sensorTypeAverageData[$sensorType->id]['avg'] ?? '0.0';
                $sensorAvg->remote_name = $sensorType->remote_name;
                return $sensorAvg;
            })
            ->pluck('avg', 'remote_name');

        $graphData = $sensorTypes
            ->with('mqttDataHistories', function ($query) use ($pond_id, $start_date, $end_date) {
                $query->where('pond_id', $pond_id)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->orderBy('created_at', 'asc');
            })
            ->get()
            ->map(function ($sensorType) use ($colors, $labelList) {
                $data = $sensorType->mqttDataHistories->map(function ($mqttDataHistory) {
                    return [
                        'x' => $mqttDataHistory->created_at->format('Y-m-d H:i:s'),
                        'y' => $mqttDataHistory->new_value
                    ];
                });

                $config = [
                    'backgroundColor' => $colors[$sensorType->remote_name] ?? 'black',
                    'borderColor' => $colors[$sensorType->remote_name] ?? 'black',
                    'borderWidth' => 1,
                    'tension' => 0.3,
                ];

                return [
                    'label' => $labelList[$sensorType->remote_name] ?? $sensorType->name,
                    'data' => $data,
                    ...$config
                ];
            });

        $labels = $graphData->reduce(function ($carry, $item) {
            if (count($carry) <= $item['data']->count()) {
                return $item['data']->pluck('x')->toArray();
            } else {
                return $carry;
            }
        }, []);

        $graphData = $graphData->sortByDesc(function ($item) {
            return count($item['data']);
        })->values();

        // take all x values from all data
        $_labels = $graphData->pluck('data')->flatten(1)->pluck('x')->unique()->sort()->values();

        // fill all data with x values or null
        $graphData = $graphData->map(function ($item) use ($_labels) {
            $data = $_labels->map(function ($x) use ($item) {
                $reportData = $item['data']->firstWhere('x', $x);
                return [
                    'x' => $x,
                    'y' => $reportData ? $reportData['y'] : null
                ];
            });

            return [
                ...$item,
                'data' => $data
            ];
        });

        $machineStatus = 'On';

        return view(
            'admin.reports.machine',
            compact(
                'title',
                'breadcrumbs',
                'graphData',
                'labels',
                'ponds',
                'sensors',
                'labelList',
                'colors',
                'sensorTypeAverages',
                'start_date',
                'end_date',
                'machineStatus'
            )
        );
    }

    public function sensors()
    {
        $title = "Sensors Report";

        $breadcrumbs = [
            "Admin" => url('admin/dashboard'),
            "Reports" => false,
            "sensors" => false
        ];

        $ponds = Pond::query()->get(['name', 'id']);

        if (!request()->has('pond_id') && $ponds->count() > 0) {
            return redirect()->route('reports.sensors.index', ['pond_id' => $ponds->first()->id]);
        }

        $pond_id = request()->get('pond_id');
        $start_date = request()->get('start_date') ?? Carbon::now()->startOfDay()->format('Y-m-d H:i');
        $end_date = request()->get('end_date') ?? Carbon::now()->endOfDay()->format('Y-m-d H:i');

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
                'reports.sensors.index',
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
            'ph' => 'pH Level',
        ];

        $sensorTypes = SensorType::query()
            ->whereIn('remote_name', $remote_names)
            ->latest()
            ->get()
            ->keyBy('id');

        $sensorTypeAverageDataDaily = getSensorTypesDailyAverageBasedOnTime(
            MqttDataHistory::query()->where('pond_id', $pond_id),
            $start_date,
            $end_date
        );

        $graphData = $sensorTypes->map(function ($sensorType, $sensorTypeID) use ($colors, $labelList) {
            $data = collect();

            $config = [
                'backgroundColor' => $colors[$sensorType->remote_name] ?? 'black',
                'borderColor' => $colors[$sensorType->remote_name] ?? 'black',
                'borderWidth' => 1,
                'tension' => 0.3,
            ];

            return [
                'label' => $labelList[$sensorType->remote_name] ?? $sensorType->name,
                'data' => $data,
                ...$config
            ];
        });

        $sensorTypeAverageDataDaily->each(function ($sensorTypeAvgList, $date) use ($colors, $labelList, &$graphData) {
            foreach ($sensorTypeAvgList as $sensorTypeID => $sensorTypeAvg) {
                if (isset($graphData[$sensorTypeID])) {
                    $graphData[$sensorTypeID]['data']->push([
                        'x' => $date,
                        'y' => $sensorTypeAvg['avg']
                    ]);
                }
            }
        });

        $graphData = $graphData->values();

        return view(
            'admin.reports.sensors',
            compact(
                'title',
                'breadcrumbs',
                'graphData',
                'ponds',
                'sensors',
                'labelList',
                'colors',
                'start_date',
                'end_date',
            )
        );
    }

    public function aerators()
    {
        $title = "Aerators Report";

        $breadcrumbs = [
            "Admin" => url('admin/dashboard'),
            "Reports" => false,
            "aerators" => false
        ];

        $ponds = Pond::query()->get(['name', 'id']);

        if (!request()->has('pond_id') && $ponds->count() > 0) {
            return redirect()->route('reports.aerators.index', ['pond_id' => $ponds->first()->id]);
        }

        $pond_id = request()->get('pond_id');
        $start_date = request()->get('start_date') ?? Carbon::now()->startOfDay()->format('Y-m-d H:i');
        $end_date = request()->get('end_date') ?? Carbon::now()->endOfDay()->format('Y-m-d H:i');

        $mqttDataSwitchUnitHistoryDetail = DB::table('mqtt_data_switch_unit_history_details AS mdshd')
            ->leftJoin(
                'mqtt_data_switch_unit_histories AS mdsh',
                'mdsh.id',
                '=',
                'mdshd.history_id'
            )
            ->where('mdsh.pond_id', $pond_id)
            ->whereBetween('mdshd.created_at', [$start_date, $end_date])
            ->where('mdshd.switch_type_id', 1)
            ->orderBy('mdshd.created_at')
            ->get([
                'mdshd.id',
                'mdshd.status',
                'mdshd.created_at',
                'mdshd.switch_type_id',
                'mdshd.number'
            ])
            ->groupBy('number');

        $onOff = [];
        $lastOnOff = [];
        $fullRunTime = [];
        $lastRunTime = [];
        $allStatus = [];

        $mqttDataSwitchUnitHistoryDetail->each(function ($aHistoryDetail, $switchNumber) use ($end_date, &$onOff, &$lastOnOff, &$fullRunTime, &$lastRunTime, &$allStatus) {
            $onOff[$switchNumber] = [
                'start' => null,
                'end' => null
            ];
            $lastOnOff[$switchNumber] = [
                'start' => null,
                'end' => null
            ];
            $fullRunTime[$switchNumber] = 0;

            $allStatus[$switchNumber] = $aHistoryDetail?->reverse()?->first()?->status ?? 'off';

            $count = $aHistoryDetail->count();
            $aHistoryDetail->each(function ($item, $index) use ($count, $end_date, $switchNumber, &$onOff, &$fullRunTime, &$lastOnOff) {
                $isLast = $index === $count - 1;

                if ($item->status === 'on') {
                    $start = $onOff[$switchNumber]['start'] ?: $item->created_at;
                    $end = !$isLast
                        ? $onOff[$switchNumber]['start'] ? $item->created_at : null
                        : $end_date;

                    $onOff[$switchNumber] = [
                        'start' => $start,
                        'end' => $end,
                    ];

                    $lastOnOff[$switchNumber] = [
                        'start' => $start,
                        'end' => $end_date
                    ];
                } else {
                    $start = $onOff[$switchNumber]['start'] ?: null;
                    $end = $onOff[$switchNumber]['start'] ? $item->created_at : null;

                    $onOff[$switchNumber] = [
                        'start' => $start,
                        'end' => $end,
                    ];

                    $fullRunTime[$switchNumber] += Carbon::parse($start)->diffInSeconds($end);

                    $lastOnOff[$switchNumber] = [
                        'start' => $start,
                        'end' => $end
                    ];

                    $onOff[$switchNumber] = [
                        'start' => null,
                        'end' => null
                    ];
                }
            });

            $fullRunTime[$switchNumber] += Carbon::parse($onOff[$switchNumber]['start'])->diffInSeconds($onOff[$switchNumber]['end']);
            $lastRunTime[$switchNumber] = Carbon::parse($lastOnOff[$switchNumber]['start'])->diffInSeconds($lastOnOff[$switchNumber]['end']);
        });

        // dd($mqttDataSwitchUnitHistoryDetail->toArray(), $start_date, $end_date);
        $labels = $mqttDataSwitchUnitHistoryDetail->keys()
            ->map(function ($key) {
                return "Aerator Switch: $key";
            })->toArray();

        $borderColors = [
            1 => 'blue',
            2 => 'green',
            3 => 'purple',
            4 => 'yellow',
            5 => 'orange',
            6 => 'cyan',
            7 => 'amber',
            8 => 'brown',
            9 => 'pink',
            10 => 'lime',
            11 => 'indigo',
            12 => 'teal',
        ];

        $colorsWith50pOpacity = [
            1 => 'rgba(0, 0, 255, 0.6)',
            2 => 'rgba(0, 128, 0, 0.6)',
            3 => 'rgba(128, 0, 128, 0.6)',
            4 => 'rgba(255, 255, 0, 0.6)',
            5 => 'rgba(255, 165, 0, 0.6)',
            6 => 'rgba(0, 255, 255, 0.6)',
            7 => 'rgba(255, 191, 0, 0.6)',
            8 => 'rgba(165, 42, 42, 0.6)',
            9 => 'rgba(255, 192, 203, 0.6)',
            10 => 'rgba(50, 205, 50, 0.6)',
            11 => 'rgba(75, 0, 130, 0.6)',
            12 => 'rgba(0, 128, 128, 0.6)',
        ];

        $graphData = [
            [
                'label' => 'Aerator Run Time (Seconds)',
                'data' => $fullRunTime,
                'backgroundColor' => [
                    ...$colorsWith50pOpacity
                ],
                'borderColor' => [
                    ...$borderColors
                ],
                'borderWidth' => 1,
                'tension' => 0.3,
                // border top radius
                'borderRadius' => 4,
            ]
        ];

        return view(
            'admin.reports.aerators',
            compact(
                'title',
                'breadcrumbs',
                'graphData',
                'labels',
                'ponds',
                'start_date',
                'end_date',
                'borderColors',
                'lastRunTime',
                'allStatus'
            )
        );
    }
}
