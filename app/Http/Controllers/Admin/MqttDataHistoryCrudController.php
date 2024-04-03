<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MqttDataHistoryRequest;
use App\Models\Project;
use App\Models\Pond;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class MqttDataHistoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MqttDataHistoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use CreatedAt;
    use FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\MqttDataHistory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mqtt-data-history');
        CRUD::setEntityNameStrings('mqtt data history', 'mqtt data histories');

        CRUD::denyAccess(['create', 'delete', 'update']);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name'  => 'mqttData.project',
            'label' => 'Project',
        ]);
        CRUD::column('pond_id');
        CRUD::AddColumn([
            'name'   => 'sensor_type_id',
            'entity' => 'sensorType'
        ]);
        CRUD::AddColumn([
            'name'   => 'sensor_unit_id',
            'entity' => 'sensorUnit'
        ]);
        CRUD::AddColumn([
            'name'   => 'switch_type_id',
            'entity' => 'switchType'
        ]);
        CRUD::AddColumn([
            'name'   => 'switch_unit_id',
            'entity' => 'switchUnit'
        ]);
        CRUD::column('value');
        CRUD::column('message');

        $this->createdAtList();

        // filter with type
        CRUD::addFilter(
            [
                'name'  => 'type',
                'type'  => 'dropdown',
                'label' => 'Type',
            ],
            [
                'sensor' => 'Sensor',
                'switch' => 'Switch',
            ],
            function ($value) {
                $this->crud->addClause('whereHas', 'mqttData', function ($query) use ($value) {
                    $query->where('type', $value);
                });
            }
        );

        // filter with project
        CRUD::addFilter(
            [
                'name'        => 'project_id',
                'label'       => 'Project',
                'type'        => 'select2_ajax',
                'placeholder' => 'Pick a project'
            ],
            // the ajax route
            url(config('backpack.base.route_prefix', 'admin') . '/mqtt-data-history/ajax-project-options'),
            function ($value) {
                // if the filter is active
                $this->crud->addClause('whereHas', 'mqttData', function ($query) use ($value) {
                    $query->where('project_id', $value);
                });
            }
        );
        // filter with pond_id
        CRUD::addFilter(
            [
                'name'        => 'pond_id',
                'type'        => 'select2_ajax',
                'placeholder' => 'Pick a pond'
            ],
            // the ajax route
            url(config('backpack.base.route_prefix', 'admin') . '/mqtt-data-history/ajax-pond-options'),
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'pond_id', $value);
            }
        );
        // filter with sensor_type_id
        CRUD::addFilter(
            [
                'name'        => 'sensor_type_id',
                'label'       => 'Sensor Type',
                'type'        => 'select2_ajax',
                'placeholder' => 'Pick a sensor type'
            ],
            url(config('backpack.base.route_prefix', 'admin') . '/mqtt-data-history/ajax-sensor-type-options'),
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'sensor_type_id', $value);
            }
        );
        // filter with sensor_unit_id
        CRUD::addFilter(
            [
                'name'        => 'sensor_unit_id',
                'label'       => 'Sensor Unit',
                'type'        => 'select2_ajax',
                'placeholder' => 'Pick a sensor unit'
            ],
            url(config('backpack.base.route_prefix', 'admin') . '/mqtt-data-history/ajax-sensor-unit-options'),
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'sensor_unit_id', $value);
            }
        );
        // filter with switch_type_id
        CRUD::addFilter(
            [
                'name'        => 'switch_type_id',
                'label'       => 'Switch Type',
                'type'        => 'select2_ajax',
                'placeholder' => 'Pick a switch type'
            ],
            url(config('backpack.base.route_prefix', 'admin') . '/mqtt-data-history/ajax-switch-type-options'),
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'switch_type_id', $value);
            }
        );
        // filter with switch_unit_id
        CRUD::addFilter(
            [
                'name'        => 'switch_unit_id',
                'label'       => 'Switch Unit',
                'type'        => 'select2_ajax',
                'placeholder' => 'Pick a switch unit'
            ],
            url(config('backpack.base.route_prefix', 'admin') . '/mqtt-data-history/ajax-switch-unit-options'),
            function ($value) {
                // if the filter is active
                $this->crud->addClause('where', 'switch_unit_id', $value);
            }
        );
        // filter with value
        CRUD::addFilter([
            'type'  => 'text',
            'name'  => 'value',
            'label' => 'Value',
        ]);

        // filter with date range picker
        CRUD::addFilter([
            'type'  => 'date_range',
            'name'  => 'created_at',
            'label' => 'Created At',
        ], false, function ($value) {
            $dates = json_decode($value);
            $this->crud->addClause('whereDate', 'created_at', '>=', $dates->from);
            $this->crud->addClause('whereDate', 'created_at', '<=', $dates->to);
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
        CRUD::setValidation(MqttDataHistoryRequest::class);

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

    public function fetchPonds()
    {
        return $this->fetch(Pond::class);
    }

    public function fetchSensorTypes()
    {
        return $this->fetch(\App\Models\SensorType::class);
    }

    public function fetchSensorUnits()
    {
        return $this->fetch(\App\Models\SensorUnit::class);
    }

    public function fetchSwitchTypes()
    {
        return $this->fetch(\App\Models\SwitchType::class);
    }

    public function fetchSwitchUnits()
    {
        return $this->fetch(\App\Models\SwitchUnit::class);
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function projectOptions(Request $request)
    {
        $term = $request->input('term');
        return Project::query()
            ->where('name', 'like', '%' . $term . '%')
            ->get()
            ->pluck('name', 'id');
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function pondOptions(Request $request)
    {
        $term = $request->input('term');
        return Pond::query()
            ->where('name', 'like', '%' . $term . '%')
            ->get()
            ->pluck('name', 'id');
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function sensorTypeOptions(Request $request)
    {
        $term = $request->input('term');
        return \App\Models\SensorType::query()
            ->where('name', 'like', '%' . $term . '%')
            ->get()
            ->pluck('name', 'id');
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function sensorUnitOptions(Request $request)
    {
        $term = $request->input('term');
        return \App\Models\SensorUnit::query()
            ->where('name', 'like', '%' . $term . '%')
            ->get()
            ->pluck('name', 'id');
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function switchTypeOptions(Request $request)
    {
        $term = $request->input('term');
        return \App\Models\SwitchType::query()
            ->where('name', 'like', '%' . $term . '%')
            ->get()
            ->pluck('name', 'id');
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function switchUnitOptions(Request $request)
    {
        $term = $request->input('term');
        return \App\Models\SwitchUnit::query()
            ->where('name', 'like', '%' . $term . '%')
            ->get()
            ->pluck('name', 'id');
    }
}
