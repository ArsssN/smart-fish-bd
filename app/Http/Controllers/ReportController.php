<?php

namespace App\Http\Controllers;

use App\Models\Pond;
use App\Models\SensorType;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
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

        $defaultSensors = ['o2', 'temp', 'tds'];
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

        $graphData = SensorType::query()
            ->whereIn('remote_name', $remote_names)
            ->with('mqttDataHistories', function ($query) use ($pond_id, $start_date, $end_date) {
                $query->where('pond_id', $pond_id)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->latest();
            })
            ->latest()
            ->get()
            ->map(function ($sensorType) use ($colors, $labelList) {
                $data = $sensorType->mqttDataHistories->map(function ($mqttDataHistory) {
                    return [
                        'x' => $mqttDataHistory->created_at->format('Y-m-d H:i:s'),
                        'y' => $mqttDataHistory->value
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
