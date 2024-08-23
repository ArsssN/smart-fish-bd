<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PondRequest;
use App\Models\Project;
use App\Models\SensorUnit;
use App\Models\SwitchType;
use App\Models\SwitchUnit;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Carbon\Carbon;
use Carbon\CarbonInterval;

/**
 * Class PondCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PondCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use FetchOperation;
    use CreatedAt, CreatedBy;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Pond::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pond');
        CRUD::setEntityNameStrings('pond', 'ponds');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('project_id')->label('Project')->type('relationship');
        CRUD::column('sensorUnits')->label('Sensor units');
        CRUD::column('switchUnits')->label('Switch units');
        CRUD::column('status');

        // only project owner can see the project
        if (isCustomer()) {
            $this->crud->addClause('where', 'created_by', backpack_user()->id);
        }

        $this->createdByList();
        $this->createdAtList();

        // sensorUnits filter
        $this->crud->addFilter([
            'name' => 'sensorUnits',
            'type' => 'select2',
            'label' => 'Sensor Units'
        ], function () {
            return SensorUnit::query()->get()
                ->map(function ($sensorUnit) {
                    return [
                        'id' => $sensorUnit->id,
                        'name' => $sensorUnit->serial_number . ' - ' . $sensorUnit->name,
                    ];
                })
                ->pluck('name', 'id')
                ->toArray();
        }, function ($value) {
            $this->crud->addClause('whereHas', 'sensorUnits', function ($query) use ($value) {
                $query->where('sensor_unit_id', $value);
            });
        });

        // project filter
        $this->crud->addFilter([
            'name' => 'project_id',
            'type' => 'select2',
            'label' => 'Project'
        ], function () {
            return Project::query()->get()
                ->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                    ];
                })
                ->pluck('name', 'id')
                ->toArray();
        }, function ($value) {
            $this->crud->addClause('where', 'project_id', $value);
        });

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PondRequest::class);

        CRUD::field('name')->wrapperAttributes([
            'class' => 'form-group col-md-6'
        ]);
        CRUD::addField([
            'name' => 'project_id',
            'type' => 'relationship',
            'entity' => 'project',
            'ajax' => true,
            'inline_create' => [
                'entity' => 'project',
                'field' => 'name',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::addField([
            'name' => 'sensorUnits',
            'label' => 'Sensor units',
            'type' => 'relationship',
            'entity' => 'sensorUnits',
            'ajax' => true,
            /*'inline_create' => [
                'entity' => 'sensorUnit',
                'field' => 'name',
            ],*/
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::addField([
            'name' => 'switchUnits',
            'label' => 'Switch units',
            'type' => 'relationship',
            'entity' => 'switchUnits',
            'ajax' => true,
            'data_source' => route('pond.fetchUnusedSwitchUnits'),
            /*'inline_create' => [
                'entity' => 'switchUnit',
                'field' => 'name',
            ],*/
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        CRUD::addField([
            'name' => 'status',
            'type' => 'enum',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ]
        ]);
        CRUD::field('address')->type('textarea');
        CRUD::field('description')->type('tinymce');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    // setupShowOperation
    public function setupShowOperation()
    {
        $this->crud->setShowContentClass('col-md-12');

        CRUD::column('name');
        CRUD::column('project_id');

        CRUD::addColumn([
            'name' => 'sensorUnits',
            'label' => 'Sensor units',
            'type' => 'closure',
            'escaped' => false,
            'function' => function ($entry) {
                $html = "<table class='table table-bordered table-striped'>";
                $html .= "<thead>";
                $html .= "<tr>";
                $html .= "<th>Sensor Unit</th>";
                $html .= "<th>Sensor Types</th>";
                $html .= "<th>Serial Number</th>";
                $html .= "</tr>";
                $html .= "</thead>";
                $html .= "<tbody>";

                $historiesQuery = $entry->histories();


                /*$nowDate = Carbon::make('2024-05-10')->endOfDay();
                $lastDate = Carbon::make('2024-05-10')->startOfDay();*/

                $nowDate = Carbon::now();
                $lastDate = Carbon::now()->subDay();

                $sensorUnitHistories =
                    (clone $historiesQuery)->where('sensor_unit_id', '!=', null)->latest()
                        ->whereBetween('created_at', [$lastDate, $nowDate])
                        ->get(['id', 'sensor_type_id', 'sensor_unit_id', 'created_at', 'value'])
                        ->reduce(
                            function ($carry, $item) {
                                if (!$item->value) return $carry;

                                $thisSensorType = $carry[$item->sensor_type_id] ??
                                    [
                                        "avg" => 0,
                                        "total" => 0,
                                        "count" => 0,
                                    ];

                                $thisSensorType['total'] += isset($thisSensorType[$item->sensor_type_id])
                                    ? $thisSensorType[$item->sensor_type_id] + $item->value
                                    : $item->value;
                                $thisSensorType['count']++;
                                $thisSensorType['avg'] = $thisSensorType['total'] / $thisSensorType['count'];

                                $carry[$item->sensor_type_id] = $thisSensorType;

                                return $carry;
                            }, []
                        );

                $entry->sensorUnits->each(function ($sensorUnit) use (&$html, $sensorUnitHistories, $nowDate, $lastDate) {
                    $html .= "<tr>";
                    $html .= "<td><a target='_blank' href='" . route('sensor-unit.show', $sensorUnit->id)
                        . "'>{$sensorUnit->name}</a></td>";
                    $html .= "<td>";

                    $html .= "<table class='table table-bordered table-striped table-sm'>";
                    $html .= "<thead>";
                    $html .= "<tr class='font-weight-bold'><th>Name</th><th>Remote name</th><th title='{$nowDate->format('d-M-Y h:i:sA')} -> {$lastDate->format('d-M-Y h:i:sA')}'>Avg.</th></tr>";
                    $html .= "</thead>";
                    $html .= "<tbody>";
                    $sensorUnit->sensorTypes->each(function ($sensorType) use (&$html, $sensorUnitHistories) {
                        $avg = number_format($sensorUnitHistories[$sensorType->id]['avg'] ?? 0, 2);
                        $html .= "<tr><td>{$sensorType->name}</td><td>{$sensorType->remote_name}</td><td>{$avg}</td></tr>";
                    });
                    $html .= "</tbody>";
                    $html .= "</table>";

                    $html .= "</td>";
                    $html .= "<td>{$sensorUnit->serial_number}</td>";
                    $html .= "</tr>";
                });

                $html .= "</tbody>";
                $html .= "</table>";

                return $html;
            }
        ]);
        CRUD::addColumn([
            'name' => 'switchUnits',
            'label' => 'Switch units',
            'type' => 'closure',
            'escaped' => false,
            'function' => function ($entry) {
                $html = "<table class='table table-bordered table-striped'>";
                $html .= "<thead>";
                $html .= "<tr>";
                $html .= "<th>Switch Unit</th>";
                $html .= "<th>Switches</th>";
                $html .= "<th>Serial Number</th>";
                $html .= "</tr>";
                $html .= "</thead>";
                $html .= "<tbody>";

                $entry->switchUnits->each(function ($switchUnit) use (&$html) {
                    $html .= "<tr>";
                    $html .= "<td><a target='_blank' href='" . route('switch-unit.show', $switchUnit->id)
                        . "'>{$switchUnit->name}</a></td>";
                    $html .= "<td>";
                    $html .= "<table class='table table-bordered table-striped table-sm'>";
                    $html .= "<thead>";
                    $html .= "<tr>";
                    $html .= "<th>SN</th>";
                    $html .= "<th>Switch type</th>";
                    $html .= "<th>Status</th>";
                    $html .= "<th>Run time</th>";
                    $html .= "<th>Comment</th>";
                    $html .= "</tr>";
                    $html .= "</thead>";
                    $html .= "<tbody>";

                    $switchUnitHistories = $switchUnit->histories()->latest()->with('switchUnitHistoryDetails.switchType')->first();

                    // $switches = collect($switchUnit->switches);
                    $switches = $switchUnitHistories->switchUnitHistoryDetails;
                    $aerator_remote_name = 'aerator';

                    /*$switchTypeIDs = collect($switches)->pluck('switchType')->toArray();
                    $relatedSwitches = SwitchType::query()->whereIn('id', $switchTypeIDs)->get()->keyBy('id');

                    $aerator_slug = 'aerator';
                    $aeratorSwitchTypeID = $relatedSwitches->where('slug', $aerator_slug)->first()->id;*/

                    $switches->each(function ($switch) use (&$html, $aerator_remote_name /*$relatedSwitches, $aeratorSwitchTypeID*/) {
                        $switch = (object)$switch;

                        $runTime = $switch->switchType->remote_name == $aerator_remote_name
                            ? CarbonInterval::second($switch->run_time)->cascade()->forHumans(['short' => true])
                            : '-';
                        $html .= "<tr>";
                        $html .= "<td>{$switch->number}</td>";
                        $html .= "<td>{$switch->switchType->name}</td>";
                        $html .= "<td>{$switch->status}</td>";
                        $html .= "<td title='".$switch->machine_on_at. ' -> ' . ($switch->machine_off_at ?: 'Now')."'>{$runTime}</td>";
                        $html .= "<td>{$switch->comment}</td>";
                        $html .= "</tr>";
                    });
                    $html .= "</tbody>";
                    $html .= "</table>";
                    $html .= "</td>";
                    $html .= "<td>{$switchUnit->serial_number}</td>";
                    $html .= "</tr>";
                });

                $html .= "</tbody>";
                $html .= "</table>";

                return $html;
            }
        ]);

        CRUD::column('address');
        CRUD::column('status');

        CRUD::addColumn([
            'name' => 'histories',
            'label' => 'Histories',
            'type' => 'closure',
            'escaped' => false,
            'function' => function ($entry) {
                $limit = 10;
                $historiesQuery = $entry->histories()
                    ->with('pond', 'sensorUnit', 'sensorType', 'switchUnit', 'switchType');

                $sensorUnitHistories =
                    (clone $historiesQuery)->where('sensor_unit_id', '!=', null)->latest()->limit($limit)->get();
                $switchUnitHistories =
                    (clone $historiesQuery)->where('switch_unit_id', '!=', null)->latest()->limit($limit)->get();

                $html =
                    "<h4>Sensor Histories <small>(Latest {$limit} data) <a target='_blank' href='" . route(
                        'mqtt-data-history.index',
                        [
                            'pond_id' => $entry->id,
                            'pond_id_text' => $entry->name,
                            'type' => 'sensor'
                        ]
                    ) . "'>View all</a></small></h4>";
                $html .= $this->getXUnitHistory('sensor', $sensorUnitHistories);

                $html .= "<h4>Switch Histories <small>(Latest {$limit} data) <a target='_blank' href='" . route(
                        'mqtt-data-history.index',
                        [
                            'pond_id' => $entry->id,
                            'pond_id_text' => $entry->name,
                            'type' => 'switch'
                        ]
                    ) . "'>View all</a></small></h4>";
                $html .= $this->getXUnitHistory('switch', $switchUnitHistories);

                return $html;
            },
        ]);

        CRUD::addColumn([
            'name' => 'switchUnitHistories',
            'label' => 'Switch unit histories',
            'type' => 'closure',
            'escaped' => false,
            'function' => function ($entry) {
                $count = $entry->switchUnitHistories->count() ?? 0;

                return "<a target='_blank' href='" . route(
                        'mqtt-data-switch-unit-history.index',
                        [
                            'pond_id' => $entry->id,
                            'pond_id_text' => $entry->name
                        ]
                    ) . "'>View all switch unit histories</a> ($count)";
            }
        ]);

        $this->createdByList();
        $this->createdAtList();
    }

    public function fetchProject()
    {
        return $this->fetch(Project::class);
    }

    public function fetchSensorUnits()
    {
        return $this->fetch(SensorUnit::class);
    }

    public function fetchSwitchUnits()
    {
        return $this->fetch(SwitchUnit::class);
    }

    public function fetchUnusedSwitchUnits()
    {
        return SwitchUnit::query()
            ->where('name', 'like', '%' . request()->get('q') . '%')
            ->whereDoesntHave('ponds')
            ->get();
    }

    private function getXUnitHistory($type, $xUnitHistories)
    {
        $html = '<table class="table table-bordered table-striped">';
        $html .= '<thead>';
        $html .= '<tr>';

        $html .= '<th>' . ucfirst($type) . ' Unit</th>';
        $html .= '<th>' . ucfirst($type) . ' Type</th>';

        $html .= '<th>Value</th>';
        $html .= '<th>Message</th>';
        $html .= '<th>Created At</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        if ($xUnitHistories->isEmpty()) {
            $html .= '<tr>';
            $html .= '<td colspan="5">No data found</td>';
            $html .= '</tr>';
        } else {
            foreach ($xUnitHistories as $history) {
                $html .= '<tr>';

                $html .= '<td>' . optional($history->{$type . "Unit"})->name . '</td>';
                $html .= '<td>' . optional($history->{$type . "Type"})->name . '</td>';

                $html .= '<td>' . $history->value . '</td>';
                $html .= '<td>' . $history->message . '</td>';
                $html .= '<td title="' . $history->created_at->diffForHumans() . '">' . $history->created_at . '</td>';
                $html .= '</tr>';
            }
        }

        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }
}
