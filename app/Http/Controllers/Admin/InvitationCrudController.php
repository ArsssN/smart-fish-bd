<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvitationRequest;
use App\Models\Event;
use App\Models\Invitee;
use App\Traits\BulkInvitationCreateOperation;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

/**
 * Class InvitationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvitationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use CreatedAt, CreatedBy;
    use BulkInvitationCreateOperation;
    use FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Invitation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invitation');
        CRUD::setEntityNameStrings('invitation', 'invitations');
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
            'select_attribute' => 'title', // by default it's name
        ], backpack_url('invitation/fetch/event'), function ($value) {
            $this->crud->addClause('whereHas', 'event', function ($query) use ($value) {
                $query->where('id', $value);
            });
        });
        // invitee filter
        $this->crud->addFilter([
            'type'             => 'select2_ajax',
            'name'             => 'invitee_id',
            'attribute'        => 'name',
            'method'           => 'POST',
            'select_attribute' => 'name',
        ], backpack_url('invitation/fetch/invitee'), function ($value) {
            $this->crud->addClause('whereHas', 'invitee', function ($query) use ($value) {
                $query->where('id', $value);
            });
        });

        CRUD::column('id');
        CRUD::column('invitee_id');
        CRUD::column('code');
        CRUD::column('event_id');

        $this->createdByList();
        $this->createdAtList();
        $this->createdAtList('updated_at');

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
        CRUD::setValidation(InvitationRequest::class);

        CRUD::field('invitee_id')->type('relationship')->ajax(true);
        CRUD::field('code')->attributes(['readonly' => 'readonly'])->default(createUniqueInvitationCode());
        CRUD::field('event_id')
            ->entity('event')
            ->attribute('title')
            ->type('relationship')
            ->ajax(true)
            ->model(Event::class);

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

    public function fetchInvitee()
    {
        return $this->fetch(Invitee::class);
    }

    /**
     * @return void
     */
    protected function setupBulkInvitationCreateOperation()
    {
        CRUD::setEntityNameStrings('bulk invitation', 'bulk invitations');

        CRUD::addField([
            'name'  => 'file',
            'label' => 'File',
            'type'  => 'browse',
        ]);
        CRUD::addField([
            'name'        => 'event_id',
            'entity'      => 'event',
            'attribute'   => 'title_location_date',
            'type'        => 'relationship',
            'data_source' => url('admin/invitation/fetch/event'),
            'ajax'        => true,
        ]);
    }
}
