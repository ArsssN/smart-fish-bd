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
        $start_date = request()->get('start_date') ?? Carbon::now()->subHours(3)->format('Y-m-d H:i');
        $end_date = request()->get('end_date') ?? Carbon::now()->format('Y-m-d H:i');

        $mqttDataSwitchUnitHistoryDetail = MqttDataSwitchUnitHistoryDetail::query()
            ->whereHas(
                'mqttDataSwitchUnitHistory',
                function ($query) use ($pond_id) {
                    $query->where('pond_id', $pond_id);
                }
            )
            ->whereBetween('created_at', [$start_date, $end_date])
            ->where('switch_type_id', 1)
            ->get([
                'id',
                'status',
                'created_at',
                'switch_type_id',
                'number'
            ])
            ->groupBy('number')
            /*->map(function ($item) {
                $total_run_time = $item->sum('run_time');
                return [
                    'items' => $item->toArray(),
                    'total_run_time' => $total_run_time,
                    'total_formated_run_time' => CarbonInterval::second($total_run_time)->cascade()->forHumans(['short' => true])
                ];
            })*/;
        // dd(now(),[$start_date, $end_date], $mqttDataSwitchUnitHistoryDetail->toArray(), MqttDataSwitchUnitHistoryDetail::orderByDesc('id')->first()->toArray());
        dd($mqttDataSwitchUnitHistoryDetail->toArray());
        //dump($mqttDataSwitchUnitHistoryDetail->toArray(), $start_date, $end_date);
        $labels = $mqttDataSwitchUnitHistoryDetail->keys()
            ->map(function ($key) {
                return "Aerator Switch: $key";
            })->toArray();

        $emptyGraphData = collect(array_fill(1, 12, null));
        $empty_formated_run_time = collect(array_fill(1, 12, ""));
        $empty_status = collect(array_fill(1, 12, "off"));
        $empty_on_off = collect(array_fill(1, 12, [
            'on' => null,
            'off' => null
        ]));

        $formated_run_time = $mqttDataSwitchUnitHistoryDetail->map(
            fn($item) => $item["total_formated_run_time"] ?? ""
        );
        $status = $mqttDataSwitchUnitHistoryDetail->map(
            fn($item) => array_reverse($item["items"] ?? [])[0]["status"] ?? "off"
        );
        $on_off = $mqttDataSwitchUnitHistoryDetail->map(
            fn($item) => [
                'on' => ($top1 = array_reverse($item["items"] ?? [])[0])["machine_on_at"] ?? null,
                'off' => $top1["machine_off_at"] ?? null
            ]
        );
        $graphData = $mqttDataSwitchUnitHistoryDetail->map(
            fn($item) => $item["total_run_time"] ?? 0
        );

        $graphData = $emptyGraphData->mapWithKeys(
            fn($item, $key) => [$key => $graphData->get($key, null)]
        );
        $formated_run_time = $empty_formated_run_time->mapWithKeys(
            fn($item, $key) => [$key => $formated_run_time->get($key, "")]
        );
        $status = $empty_status->mapWithKeys(
            fn($item, $key) => [$key => $status->get($key, "-")]
        );
        $on_off = $empty_on_off->mapWithKeys(
            fn($item, $key) => [$key => $on_off->get($key, ["on" => null, "off" => null])]
        );

        $graphData = $graphData->reduce(function ($carry, $item, $key) {
            $carry["Aerator: $key"] = $item;
            return $carry;
        }, []);

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
                'data' => $graphData,
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
                'status' => $status,
                'formated_run_time' => $formated_run_time,
                'on_off' => $on_off
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
            )
        );
    }
}
