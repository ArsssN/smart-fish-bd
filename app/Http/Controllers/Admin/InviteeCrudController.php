<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InviteeRequest;
use App\Models\Event;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

/**
 * Class InviteeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InviteeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Invitee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invitee');
        CRUD::setEntityNameStrings('invitee', 'invitees');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // event filter
        $this->crud->addFilter([
            'type'             => 'select2_ajax',
            'name'             => 'event_id',
            'label'            => 'Event',
            'attribute'        => 'title',
            'method'           => 'POST',
            'select_attribute' => 'title' // by default it's name
        ], backpack_url('invitee/fetch/event'), function ($value) {
            $this->crud->addClause('whereHas', 'invitation.event', function ($query) use ($value) {
                $query->where('id', $value);
            });
        });

        CRUD::column('id');
        CRUD::column('name');
        CRUD::addColumn([
            'name'      => 'event',
            'label'     => 'Event',
            'type'      => 'relationship',
            'attribute' => 'title',
            'entity'    => 'invitation.event',
        ]);
        CRUD::column('email');
        CRUD::column('phone');
        CRUD::column('address');

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
        CRUD::setValidation(InviteeRequest::class);

        CRUD::field('name');
        CRUD::field('email')->type('email');
        CRUD::field('phone');
        CRUD::field('address')->type('address');

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

    public function fetchEvent()
    {
        return $this->fetch(Event::class);
    }
}
