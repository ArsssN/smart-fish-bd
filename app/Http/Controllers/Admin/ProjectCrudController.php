<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectRequest;
use App\Models\Aerator;
use App\Models\Feeder;
use App\Models\Sensor;
use App\Models\User;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

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
    use FetchOperation;
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
        if (isCustomer()) {
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
            'name' => 'user_id',
            'type' => $isCustomer
                ? 'hidden'
                : 'select2',
            'label' => 'Customer',
            'entity' => 'customer',
            'options' => (function ($query) use ($isCustomer) {
                if ($isCustomer) {
                    $user = $query->where('id', backpack_user()->id)->get();
                } else {
                    $user = $query->whereHas('roles', function ($query) {
                        $query->where('name', 'Customer');
                    })->get();
                }

                return $user;
            }),
            'default' => $isCustomer
                ? backpack_user()->id
                : null,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        CRUD::addField([
            'name' => 'sensors',
            'label' => 'Sensors',
            'type' => 'relationship',
            'entity' => 'sensors',
            'pivot' => true,
            'ajax' => true,
            'inline_create' => [
                'entity' => 'sensor',
                'field' => 'name',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]

            /*'options' => (function ($query) {
                return $query->where('created_by', backpack_user()->id)->get();
            }),*/
        ]);
        CRUD::addField([
            'name' => 'aerators',
            'label' => 'Aerators',
            'type' => 'relationship',
            'entity' => 'aerators',
            'pivot' => true,
            'ajax' => true,
            'inline_create' => [
                'entity' => 'aerator',
                'field' => 'name',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]

            /*'options' => (function ($query) {
                return $query->where('created_by', backpack_user()->id)->get();
            }),*/
        ]);
        CRUD::addField([
            'name' => 'feeders',
            'label' => 'Feeders',
            'type' => 'relationship',
            'entity' => 'feeders',
            'pivot' => true,
            'ajax' => true,
            'inline_create' => [
                'entity' => 'feeder',
                'field' => 'name',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ]

            /*'options' => (function ($query) {
                return $query->where('created_by', backpack_user()->id)->get();
            }),*/
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
        $this->crud->setShowView('backpack::crud.custom.show.product-show');
        $this->crud->setShowContentClass('col-md-12');

        CRUD::column('name');
        CRUD::addColumn([
            'name' => 'user_id',
            'label' => 'Customer',
            'entity' => 'customer',
            'model' => User::class,
        ]);
        CRUD::addColumn([
            'name' => 'description',
            'label' => 'Description',
            'type' => 'closure',
            'escaped' => false, // allow HTML in this column
            'function' => function ($entry) {
                return $entry->description;
            },
        ]);
        CRUD::addColumn([
            'name' => 'sensors',
        ]);
        CRUD::addColumn([
            'name' => 'aerators',
        ]);
        CRUD::addColumn([
            'name' => 'feeders',
        ]);

        CRUD::column('status');

        $this->createdByList();
        $this->createdAtList();
        $this->createdAtList('updated_at');
    }

    public function fetchSensors()
    {
        return $this->fetch(Sensor::class);
    }

    public function fetchAerators()
    {
        return $this->fetch(Aerator::class);
    }

    public function fetchFeeders()
    {
        return $this->fetch(Feeder::class);
    }

    public function fetchUsers()
    {
        return $this->fetch(User::class);
    }
}
