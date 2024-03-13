<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FishWeightRequest;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FishWeightCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FishWeightCrudController extends CrudController
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
        CRUD::setModel(\App\Models\FishWeight::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/fish-weight');
        CRUD::setEntityNameStrings('fish weight', 'fish weights');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('date');
        CRUD::column('time');
        CRUD::column('fish_id');
        CRUD::column('weight');
        CRUD::column('weight_in_24_hours');

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
        CRUD::setValidation(FishWeightRequest::class);

        CRUD::addField([
            'name'          => 'fish_id',
            'type'          => 'relationship',
            'ajax'          => true,
            'inline_create' => true,
        ]);
        CRUD::field('date')->default(date('Y-m-d'));
        CRUD::field('time')->default(date('H:i'));
        CRUD::field('weight')->type('number');
        CRUD::field('weight_in_24_hours')->type('number');
        CRUD::addField([
            'name' => 'status',
            'type' => 'enum',
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


    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('date');
        CRUD::column('time');
        CRUD::column('fish_id');
        CRUD::column('weight');
        CRUD::column('weight_in_24_hours');
        CRUD::addColumn([
            'name'     => 'description',
            'label'    => 'Description',
            'type'     => 'closure',
            'escaped'  => false, // allow HTML in this column
            'function' => function ($entry) {
                return $entry->description;
            },
        ]);

        $this->createdByList();
        $this->createdAtList();
    }
}
