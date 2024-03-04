<?php

namespace App\Traits;

use App\Helpers\InviteeImportJobHelper;
use App\Http\Requests\BulkInvitationRequest;
use App\Http\Requests\InvitationRequest;
use App\Models\Event;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait BulkInvitationCreateOperation
{
    protected function setupDownloadRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/create/bulk', [
            'as'        => $routeName . '.bulkInvitationCreate',
            'uses'      => $controller . '@bulkInvitationCreate',
            'operation' => 'bulkInvitationCreate',
        ]);
        Route::post($segment . '/create/bulk', [
            'as'        => $routeName . '.bulkInvitationStore',
            'uses'      => $controller . '@bulkInvitationStore',
            'operation' => 'bulkInvitationCreate',
        ]);
    }

    protected function setupBulkInvitationDefaults()
    {
        $this->crud->allowAccess(['bulkInvitationCreate']);

        $this->crud->operation('bulkInvitationCreate', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
            $this->crud->setupDefaultSaveActions();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButton('top', 'new_link', 'view', 'crud::buttons.custom.bulk_invitation', 'end');
        });
    }

    protected function bulkInvitationCreate()
    {
        $this->crud->hasAccessOrFail('create');
        $this->crud->setOperation('bulkInvitationCreate');

        // get the info for that entry
        $this->data['crud']       = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title']      = 'Moderate ' . $this->crud->entity_name;

        $this->crud->route = route('invitation.bulkInvitationCreate');

        return view('vendor.backpack.crud.custom.bulk-create', $this->data);
    }

    protected function bulkInvitationStore()
    {
        CRUD::setValidation(BulkInvitationRequest::class);

        $this->crud->hasAccessOrFail('update');

        (new InviteeImportJobHelper)->readExcel()->job();

        // show a success message
        \Alert::success('Moderation saved for this entry.')->flash();

        return redirect()->to($this->crud->route);
    }
}
