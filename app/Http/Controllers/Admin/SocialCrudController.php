<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SocialRequest;
use App\Models\Social;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SocialCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SocialCrudController extends CrudController
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
        CRUD::setModel(Social::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/social');
        CRUD::setEntityNameStrings('social', 'socials');

        if (!isSuperAdmin()) {
            CRUD::denyAccess(['create', 'delete']);
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
        CRUD::column('id');
        CRUD::column('title');
        CRUD::column('url');
        CRUD::addColumn([
            'name'     => 'icon',
            'label'    => 'Icon',
            'type'     => 'closure',
            'escaped'  => false,
            'function' => function ($entry) {
                return '<i class="' . $entry->icon . '"></i>';
            },
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
        CRUD::setValidation(SocialRequest::class);

        CRUD::field('title');
        CRUD::field('url')->type('url');
        CRUD::addField([
            // icon_picker
            'label'   => "Icon",
            'name'    => 'icon',
            'type'    => 'icon_picker',
            'iconset' => 'fontawesome-6-pro' // options: fontawesome, lineawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign
        ]);

        /*// og_title
        CRUD::addField([
            'name'  => 'og_title',
            'label' => 'OG Title',
            'hint'  => '<small>The title for <string>Open Graph</strong></small>',
            'type'  => 'text',
        ]);

        // og_image
        CRUD::addField([
            'name'  => 'og_image',
            'label' => 'OG Image',
            'hint'  => '<small>The image for <string>Open Graph</strong></small>',
            'type'  => 'browse',
        ]);

        // og_description
        CRUD::addField([
            'name'  => 'og_description',
            'label' => 'OG Description',
            'hint'  => '<small>The description for <string>Open Graph</strong></small>',
            'type'  => 'textarea',
        ]);*/

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
