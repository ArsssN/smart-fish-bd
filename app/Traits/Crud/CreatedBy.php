<?php

namespace App\Traits\Crud;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait CreatedBy
{
    /**
     * @return void
     */
    public function createdByList(): void
    {
        CRUD::addColumn([
            'name'   => 'created_by',
            'entity' => 'user'
        ]);
    }
}
