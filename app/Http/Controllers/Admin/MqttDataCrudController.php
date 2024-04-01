<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MqttDataRequest;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MqttDataCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MqttDataCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use CreatedAt, CreatedBy;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\MqttData::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mqtt-data');
        CRUD::setEntityNameStrings('mqtt data', 'mqtt data');

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
        CRUD::column('project_id');
        CRUD::column('type');

        $this->createdByList();
        $this->createdAtList();

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
        CRUD::setValidation(MqttDataRequest::class);

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

    public function setupShowOperation()
    {
        $this->crud->setShowContentClass('col-md-12');

        CRUD::column('project_id');
        CRUD::column('type');

        $this->createdByList();
        $this->createdAtList();

        CRUD::addColumn([
            'name'     => 'histories',
            'label'    => 'Histories',
            'type'     => 'closure',
            'escaped'  => false,
            'function' => function ($entry) {
                $histories = $entry->histories()
                    ->with('pond', 'sensorUnit', 'sensorType', 'switchUnit', 'switchType')
                    ->get();

//                dd($histories->groupBy('pond_id'));

                $html = '<table class="table table-bordered table-striped">';
                $html .= '<thead>';
                $html .= '<tr>';
                $html .= '<th>Pond</th>';

                if ($entry->type == 'sensor') {
                    $html .= '<th>Sensor Unit</th>';
                    $html .= '<th>Sensor Type</th>';
                } else if ($entry->type == 'switch') {
                    $html .= '<th>Switch Unit</th>';
                    $html .= '<th>Switch Type</th>';
                }

                $html .= '<th>Value</th>';
                $html .= '<th>Message</th>';
                $html .= '</tr>';
                $html .= '</thead>';
                $html .= '<tbody>';

                if ($histories->isEmpty()) {
                    $html .= '<tr>';
                    $html .= '<td colspan="5">No data found</td>';
                    $html .= '</tr>';
                } else {
                    foreach ($histories as $history) {
                        $html .= '<tr>';
                        $html .= '<td>' . $history->pond->name . '</td>';

                        if ($entry->type == 'sensor') {
                            $html .= '<td>' . optional($history->sensorUnit)->name . '</td>';
                            $html .= '<td>' . optional($history->sensorType)->name . '</td>';
                        } else if ($entry->type == 'switch') {
                            $html .= '<td>' . optional($history->switchUnit)->name . '</td>';
                            $html .= '<td>' . optional($history->switchType)->name . '</td>';
                        }

                        $html .= '<td>' . $history->value . '</td>';
                        $html .= '<td>' . $history->message . '</td>';
                        $html .= '</tr>';
                    }
                }

                $html .= '</tbody>';
                $html .= '</table>';

                return $html;
            },
        ]);
    }
}
