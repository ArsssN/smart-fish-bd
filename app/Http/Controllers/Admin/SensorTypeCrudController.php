<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SensorRequest;
use App\Models\SensorType;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SensorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SensorTypeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\SensorType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/sensor-type');
        CRUD::setEntityNameStrings('sensor type', 'sensor types');

        if (!isShellAdmin()) {
            CRUD::denyAccess(['update', 'delete', 'create']);
        }

        if (isCustomer()) {
            CRUD::denyAccess(['list', 'update', 'delete', 'create', 'show']);
        }
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
        CRUD::setValidation(SensorRequest::class);

        CRUD::field('name');
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
        CRUD::column('name');
        CRUD::column('status');

        CRUD::addColumn([
            'name' => 'sensors',
        ]);
        CRUD::addColumn([
            'name'     => 'projects',
            'type'     => 'closure',
            'escaped'  => false, // allow HTML in this column
            'function' => function ($entry) {
                return $entry->with('sensors.projects')->first()->sensors->flatMap->projects->pluck('name')->unique()->implode(', ') ?? '-';
            },
        ]);
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
