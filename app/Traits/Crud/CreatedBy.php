<?php

namespace App\Traits\Crud;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait CreatedBy
{
    /**
     * @param string $name
     * @param string $entity
     * @return void
     */
    public function createdByList(string $name = 'created_by', string $entity = 'user'): void
    {
        CRUD::addColumn([
            'name'   => $name,
            'entity' => $entity
        ]);
    }
}
