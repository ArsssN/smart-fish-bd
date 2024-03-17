<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FeederHistoryRequest;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FeederHistoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FeederHistoryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\FeederHistory::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/feeder-history');
        CRUD::setEntityNameStrings('feeder history', 'feeder histories');

        CRUD::denyAccess(['create', 'update', 'delete', 'show']);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('feeder_id');
        CRUD::column('date');
        CRUD::column('time');
        CRUD::column('run_time');
        CRUD::addColumn([
            'name' => 'amount',
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->amount . ' ' . $entry->unit;
            }
        ]);

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
        CRUD::setValidation(FeederHistoryRequest::class);

        CRUD::field('feeder_id')->wrapperAttributes(['class' => 'form-group col-md-6']);
        CRUD::field('run_time')->type('number')->wrapperAttributes(['class' => 'form-group col-md-6']);
        CRUD::field('date')->default(date('Y-m-d'))->wrapperAttributes(['class' => 'form-group col-md-6']);
        CRUD::field('time')->default(date('H:i'))->wrapperAttributes(['class' => 'form-group col-md-6']);
        CRUD::field('amount')->type('number')->wrapperAttributes(['class' => 'form-group col-md-6'])->hint('Amount of Feed');
        CRUD::field('unit')->type('enum')->default('kg')->wrapperAttributes(['class' => 'form-group col-md-6'])->hint('Unit of Amount of Feed');

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
