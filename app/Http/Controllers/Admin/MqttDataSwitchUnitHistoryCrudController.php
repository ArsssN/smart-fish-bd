<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MqttDataSwitchUnitHistoryRequest;
use App\Models\SwitchType;
use App\Traits\Crud\CreatedAt;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MqttDataSwitchUnitHistoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MqttDataSwitchUnitHistoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use CreatedAt;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\MqttDataSwitchUnitHistory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mqtt-data-switch-unit-history');
        CRUD::setEntityNameStrings('mqtt data switch unit history', 'mqtt data switch unit histories');

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
        CRUD::column('switchUnit')->label('Switch unit');

        $this->createdAtList();

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
        CRUD::setValidation(MqttDataSwitchUnitHistoryRequest::class);

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

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'name'  => 'mqttData.project',
            'label' => 'Project',
        ]);
        CRUD::column('pond_id');
        CRUD::column('switchUnit')->label('Switch unit');
        CRUD::addColumn([
            'name'     => 'switches',
            'label'    => 'Switches',
            'type'     => 'closure',
            'escaped'   => false,
            'function' => function ($entry) {
                $html     = "<table class='table table-bordered table-striped table-sm'>";
                $html     .= "<thead>";
                $html     .= "<tr>";
                $html     .= "<th>SN</th>";
                $html     .= "<th>Switch type</th>";
                $html     .= "<th>Status</th>";
                $html     .= "<th>Comment</th>";
                $html     .= "</tr>";
                $html     .= "</thead>";
                $html     .= "<tbody>";
                $switches = collect(json_decode($entry->switches));

                $switchTypeIDs   = collect($switches)->pluck('switchType')->toArray();
                $relatedSwitches = SwitchType::query()->whereIn('id', $switchTypeIDs)->get()->keyBy('id');

                $switches->each(function ($switch) use (&$html, $relatedSwitches) {
                    $html .= "<tr>";
                    $html .= "<td>{$switch->number}</td>";
                    $html .= "<td>{$relatedSwitches[$switch->switchType]->name}</td>";
                    $html .= "<td>{$switch->status}</td>";
                    $html .= "<td>{$switch->comment}</td>";
                    $html .= "</tr>";
                });
                $html .= "</tbody>";
                $html .= "</table>";

                return $html;
            },
        ]);

        $this->createdAtList();

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }
}
