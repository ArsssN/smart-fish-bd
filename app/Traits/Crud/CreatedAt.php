<?php

namespace App\Traits\Crud;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait CreatedAt
{
    /**
     * @param string $name
     * @param string|null $label
     * @return void
     */
    protected function createdAtList(string $name = 'created_at', string|null $label = null): void
    {
        $options = [
            'name'     => $name,
            'type'     => 'closure',
            'escaped'  => false,
            'function' => function ($entry) use ($name) {
                return "<span title='{$entry->$name->format('Y/m/d h:i:s')}'>{$entry->$name->diffForHumans()}</span>";
            },
        ];

        if ($label) {
            $options['label'] = $label;
        }

        CRUD::addColumn($options);
    }
}
