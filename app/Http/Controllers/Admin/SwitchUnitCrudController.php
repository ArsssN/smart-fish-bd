<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SwitchUnitRequest;
use App\Models\SwitchType;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\InlineCreateOperation;

/**
 * Class SwitchUnitCrudController
 *
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SwitchUnitCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use InlineCreateOperation;
    use CreatedAt, CreatedBy;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\SwitchUnit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/switch-unit');
        CRUD::setEntityNameStrings('switch unit', 'switch units');
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
        CRUD::setValidation(SwitchUnitRequest::class);

        CRUD::field('name')->wrapperAttributes([
            'class' => 'form-group col-md-6'
        ]);
        CRUD::addField([
            'name' => 'serial_number',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);
        $switchType = SwitchType::pluck('name', 'id')->toArray();
        CRUD::addField([
            'name' => 'switches',
            'label' => 'Switches',
            'type' => 'repeatable',
            'fields' => [
                [
                    'name' => 'number',
                    'label' => 'Switch number',
                    'type' => 'text',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-2'
                    ],
                ],
                [
                    'name' => 'switchType',
                    'label' => 'Switch type',
                    'type' => 'select_from_array',
                    'options' => $switchType,
                    'default' => array_keys($switchType)[0] ?? null,
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-2'
                    ],
                ],
                [
                    'name' => 'status',
                    'label' => 'Status',
                    'type' => 'select_from_array',
                    'options' => ['on' => 'On', 'off' => 'Off'],
                    'default' => 'on',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-2'
                    ],
                ],
                [
                    'name' => 'comment',
                    'label' => 'Comment',
                    'type' => 'text',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-6'
                    ],
                ],
            ],
            // options
            'new_item_label' => 'Add switch', // customize the text of the button
            'init_rows' => 12, // number of empty rows to be initialized, by default 1
            'min_rows' => 1, // minimum rows allowed, when reached the "delete" buttons will be hidden
            //'max_rows' => 12, // maximum rows allowed, when reached the "new item" button will be hidden
        ]);
        CRUD::addField([
            'name' => 'status',
            'type' => 'enum'
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
