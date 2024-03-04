@if ($crud->hasAccess('create'))
    <a href="{{ url($crud->route.'/create/bulk') }}"
       class="btn btn-info"
       data-style="zoom-in">
        <span class="ladda-label position-relative">
            <i class="la la-plus"></i>
            <i class="la la-plus position-absolute" style="left: -4px; top: -1px; z-index: 0; opacity: 0.2;"></i>
            <i class="la la-plus position-absolute d-none" style="left: 4px; top: 1px; z-index: 0; opacity: 0.5;"></i>
            {{ trans('backpack::crud.add') }} bulk {{ $crud->entity_name }}
        </span>
    </a>
@endif
