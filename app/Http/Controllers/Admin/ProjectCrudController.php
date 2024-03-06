<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectRequest;
use App\Models\User;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProjectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProjectCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Project::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/project');
        CRUD::setEntityNameStrings('project', 'projects');
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
        CRUD::addColumn([
            'name' => 'user_id',
            'label' => 'Customer',
            'entity' => 'customer',
            'model' => User::class,
        ]);
        CRUD::column('status');

        // only project owner can see the project
        if(isCustomer()) {
            $this->crud->addClause('where', 'user_id', backpack_user()->id);
        }

        $this->createdByList();
        $this->createdAtList();

        // filter
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'select2',
            'label' => 'Status'
        ], ['active' => 'Active', 'inactive' => 'Inactive']);
        $this->crud->addFilter([
            'name' => 'customer',
            'type' => 'select2',
            'label' => 'Status'
        ], ['active' => 'Active', 'inactive' => 'Inactive']);

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
        CRUD::setValidation(ProjectRequest::class);

        $isCustomer = isCustomer();

        CRUD::field('name');
        CRUD::addField([
            'name' => 'user_id',
            'type' => $isCustomer ? 'hidden' : 'select2',
            'label' => 'Customer',
            'entity' => 'customer',
            'options' => (function ($query) use($isCustomer) {
                if($isCustomer) {
                    $user = $query->where('id', backpack_user()->id)->get();
                } else {
                    $user = $query->whereHas('roles', function ($query) {
                        $query->where('name', 'Customer');
                    })->get();
                }

                return $user;
            }),
            'default' => $isCustomer ? backpack_user()->id : null,
        ]);
        /*CRUD::addField([
            'name' => 'controllers',
            'label' => 'Controllers',
            'type' => 'select2_multiple',
            'entity' => 'controllers',
            'pivot' => true,

            'options' => (function ($query) {
                return $query->where('created_by', backpack_user()->id)->get();
            }),
        ]);*/
        CRUD::addField([
            'name' => 'sensors',
            'label' => 'Sensors',
            'type' => 'select2_multiple',
            'entity' => 'sensors',
            'pivot' => true,

            /*'options' => (function ($query) {
                return $query->where('created_by', backpack_user()->id)->get();
            }),*/
        ]);
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
}
