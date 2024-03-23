<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SwitchRequest;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SwitchCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SwitchCrudController extends CrudController
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
        CRUD::setModel(\App\Models\SwitchModel::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/switch');
        CRUD::setEntityNameStrings('switch', 'switches');
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
        CRUD::column('serial_number');
        CRUD::column('status');

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
        CRUD::setValidation(SwitchRequest::class);

        CRUD::field('name')->wrapperAttributes([
            'class' => 'form-group col-md-6'
        ]);
        CRUD::addField([
            'name' => 'status',
            'type' => 'enum',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::addField([
            'name' => 'switchType',
            'label' => 'Sensor Type',
            'type' => 'select2',
            'entity' => 'switchType',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],

            /*'options' => (function ($query) {
                return $query->where('created_by', backpack_user()->id)->get();
            }),*/
        ]);
        CRUD::addField([
            'name' => 'serial_number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);
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
}
