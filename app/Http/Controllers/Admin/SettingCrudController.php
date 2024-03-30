<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Settings\app\Http\Controllers\SettingCrudController as BackpackSettingCrudController;

class SettingCrudController extends BackpackSettingCrudController
{
    /**
     * Define which settings are available on the Settings page.
     */
    public function setup()
    {
        parent::setup();

        if (isCustomer()) {
            $this->crud->denyAccess(['list']);
        }
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    public function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
        ]);

        $this->crud->addColumn([
            'name' => 'description',
            'label' => 'Description',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    public function setupUpdateOperation()
    {
        parent::setupUpdateOperation();
    }
}
