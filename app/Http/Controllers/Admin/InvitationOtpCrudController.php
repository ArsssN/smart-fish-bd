<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvitationOtpRequest;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\InvitationOtp;
use App\Models\Invitee;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

/**
 * Class InvitationOtpCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvitationOtpCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\InvitationOtp::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invitation-otp');
        CRUD::setEntityNameStrings('invitation OTP', 'invitation OTPs');

        $denyAccess = [];
        if (!isSuperAdmin()) {
            $denyAccess = [...['update'], ...$denyAccess];
        }

        if (!isAdmin()) {
            $denyAccess = [...['create', 'delete'], ...$denyAccess];
        }

        $this->crud->denyAccess($denyAccess);
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
        ], backpack_url('invitation-otp/fetch/event'), function ($value) {
            $this->crud->addClause('whereHas', 'invitation.event', function ($query) use ($value) {
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
        ], backpack_url('invitation-otp/fetch/invitee'), function ($value) {
            $this->crud->addClause('whereHas', 'invitation.invitee', function ($query) use ($value) {
                $query->where('id', $value);
            });
        });

        CRUD::column('id');
        CRUD::column('event')->label('Event')->type('closure')->function(function ($entry) {
            return $entry->invitation->event->title;
        });
        CRUD::column('invitee')->label('Invitee')->type('closure')->function(function ($entry) {
            return $entry->invitation->invitee->name;
        });
        CRUD::column('invitation_id')->label('Invitation')->type('closure')->function(function ($entry) {
            return $entry->invitation->code;
        });
        CRUD::column('otp');
        CRUD::column('expires_at');
        CRUD::column('created_at');
        CRUD::column('updated_at');

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
        CRUD::setValidation(InvitationOtpRequest::class);

        $smsService = json_decode(getSettingValue('sms_service'))[0];

        CRUD::field('invitation_id')
            ->label('Invitation Code')
            ->type('select2_from_ajax')
            ->entity('invitation')
            ->model(Invitation::class)
            ->attribute('code_event_invitee')
            ->data_source('fetch/invitation')
            ->method('POST')
            ->with('event')
            ->placeholder('Select an invitation')
            ->dependencies(['event_id'])
            ->include_all_form_fields(true);
        CRUD::field('otp')
            ->label('OTP')
            ->default(getOtp($smsService->otp_length))
            ->attributes(['readonly' => 'readonly']);
        CRUD::field('expires_at')
            ->type('datetime_picker')
            ->datetime_localized(true)
            ->default(now()->addMinutes(InvitationOtp::EXPIRY_TIME + 1));

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

    public function fetchInvitee()
    {
        return $this->fetch(Invitee::class);
    }

    public function fetchInvitation()
    {
        return $this->fetch(Invitation::class);
    }

    public function fetchEvent()
    {
        return $this->fetch(Event::class);
    }
}
