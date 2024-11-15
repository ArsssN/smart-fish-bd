<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AboutRequest;
use App\Models\About;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Backpack\Pro\Http\Controllers\Operations\Illuminate\Database\Eloquent\Collection;
use Backpack\Pro\Http\Controllers\Operations\Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

/**
 * Class AboutCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AboutCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use FetchOperation, ReorderOperation;
    use CreatedAt, CreatedBy;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(About::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/about');
        CRUD::setEntityNameStrings('about', 'abouts');
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
        CRUD::column('sub_title');
        CRUD::column('image')->type('image');
        CRUD::column('description');
        CRUD::column('parent_id');
        CRUD::column('is_in_home_button')->type('boolean');
        CRUD::column('is_in_home_card')->type('boolean');

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
        CRUD::setValidation(AboutRequest::class);

        CRUD::field('title');
        CRUD::field('sub_title');
        CRUD::field('image')->type('browse')->hint('Image size 1920x899');
        CRUD::field('description')->type('ckeditor');
        CRUD::addField([
            'name'      => 'parent_id',
            'type'      => 'relationship',
            'attribute' => 'title_with_children_count',
            'options'   => (function ($query) {
                return $query->whereNot('id', request()->id)->where('parent_id', null)->orderBy('title')->get();
            }),
        ]);
        CRUD::field('is_in_home_button');
        CRUD::field('is_in_home_card');
        CRUD::field('home_card_icon')->type('browse')->hint('Image size 128x128');
        CRUD::field('home_card_description')->type('textarea');

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

    /**
     * Define what happens when the Reorder operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-reorder
     * @return void
     */
    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'title');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 3);
    }

    /**
     * @return Collection|LengthAwarePaginator|JsonResponse
     */
    public function fetchParent()
    {
        return $this->fetch(About::class);
    }
}
