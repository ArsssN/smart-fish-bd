<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\User;
use App\Traits\Crud\CreatedAt;
use App\Traits\Crud\CreatedBy;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

/**
 * Class EventCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EventCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;
    use CreatedAt, CreatedBy;
    use FetchOperation;

    protected $reminderOptions;
    protected $statusOptions;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Event::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/event');
        CRUD::setEntityNameStrings('event', 'events');

        $this->reminderOptions = array_combine(
            array_values($reminder = Event::REMINDER),
            array_map('ucwords', array_keys($reminder))
        );

        $this->statusOptions = array_combine(
            $val = array_values($status = Event::STATUS),
            array_map('ucwords', $val)
        );
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addFilter([
            'type'  => 'select2',
            'name'  => 'reminder',
            'label' => 'Reminder'
        ], $this->reminderOptions, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'reminder', $value);
        });
        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'from_to',
            'label' => 'Date range'
        ], false, function ($value) { // if the filter is active
            $dates = json_decode($value);
            $this->crud->addClause('where', 'start_date', '>=', $dates->from);
            $this->crud->addClause('where', 'start_date', '<=', $dates->to . ' 23:59:59');
        });
        $this->crud->addFilter([
            'type'  => 'select2',
            'name'  => 'status',
            'label' => 'Status'
        ], $this->statusOptions, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'status', $value);
        });

        CRUD::column('id');
        CRUD::column('title');
        CRUD::column('start_date')->type('datetime')->format('MMM DD, YYYY - hh:mma');
        CRUD::column('end_date')->type('datetime')->format('MMM DD, YYYY - hh:mma');
        CRUD::column('reminder')
            ->type('closure')
            ->function(function ($entry) {
                /*return array_keys(array_filter(Event::REMINDER, function($item) use($entry) {
                    return $item == $entry->reminder;
                }))[0] ?? $entry->reminder;*/

                return ucfirst(array_search($entry->reminder, Event::REMINDER) ?? $entry->reminder);
            });
        CRUD::column('location');
        CRUD::column('status')->type('enum');

        $this->createdByList('owned_by', 'owner');
        $this->createdByList();
        $this->createdAtList();
        $this->createdAtList('updated_at');

        //$this->crud->addClause('where', 'status', request()->status ?? 'active');

        if (in_array(request()->status, ['expired', 'canceled'])) {
            $this->crud->removeButton('delete');
        }

        if (request()->status == 'expired') {
            $this->crud->removeButton('update');
        }

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
        CRUD::setValidation(EventRequest::class);

        CRUD::field('title')->tab(__('Basic'));
        CRUD::field('start_date')->tab(__('Basic'))->type('datetime_picker')->wrapperAttributes(['class' => 'form-group col-md-6']);
        CRUD::field('end_date')->tab(__('Basic'))->type('datetime_picker')->wrapperAttributes(['class' => 'form-group col-md-6']);
        CRUD::field('location')->tab(__('Basic'))->type('address');
        $options = collect(Event::STATUS)->filter(fn($status) => in_array($status, ['expired']) === false)->toArray();
        CRUD::field('status')->tab(__('Basic'))->type('select_from_array')->options(array_combine($options, array_map('ucfirst', $options)));

        CRUD::field('banner')->tab(__('Media & Other'))->type('browse');
        CRUD::field('card_details')->tab(__('Media & Other'));
        CRUD::field('owned_by')->tab(__('Media & Other'))
            ->entity('owner')
            ->attribute('name')
            ->type('relationship')
            /*->inline_create(true)*/
            ->ajax(true)
            ->nullable(true)
            ->model(User::class);

        CRUD::field('reminder')
            ->tab(__('Media & Other'))
            ->type('select2_from_array')
            ->multiple(true)
            ->options($this->reminderOptions);
        CRUD::field('description')->tab(__('Media & Other'))->type('ckeditor');

        $themeOptions = array_keys(config('event.themes'));
        $ThemeOptions = array_map('ucfirst', $themeOptions);
        $options      = array_combine($themeOptions, $ThemeOptions);
        CRUD::addField([
            'name'      => 'card_details',
            'tab'       => __('Theming'),
            'type'      => 'repeatable',
            'subfields' => [
                [
                    'name'    => 'theme',
                    'label'   => __('Theme'),
                    'type'    => 'select_from_array',
                    'options' => $options,
                    'default' => 'default',
                ],
            ],
            'init_rows' => 1,
            'min_rows'  => 1,
            'max_rows'  => 1,
        ]);

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
     * Define what happens when the Show operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-show
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    // fetch owner for select2_from_ajax
    public function fetchOwner()
    {
        return $this->fetch(User::class);
    }
}
