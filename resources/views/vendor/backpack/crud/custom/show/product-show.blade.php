@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid d-print-none">
        <a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}
                .</small>
            @if ($crud->hasAccess('list'))
                <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i
                            class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="{{ $crud->getShowContentClass() }}">

            {{-- Default box --}}
            <div class="">
                @if ($crud->model->translationEnabled())
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            {{-- Change translation button group --}}
                            <div class="btn-group float-right">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{trans('backpack::crud.language')}}
                                    : {{ $crud->model->getAvailableLocales()[request()->input('_locale')?request()->input('_locale'):App::getLocale()] }}
                                    &nbsp; <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach ($crud->model->getAvailableLocales() as $key => $locale)
                                        <a class="dropdown-item"
                                           href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?_locale={{ $key }}">{{ $locale }}</a>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card no-padding no-border">
                    <div class="px-3 py-3">
                        <div class="header container-fluid mb-3">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="row">
                                        <div class="col-sm-4">Name</div>
                                        <div class="col-sm-2 col-lg-2 col-xl-1">:</div>
                                        <div class="col-sm-6 col-lg-6 col-xl-7">
                                            {{
                                                $entry->name
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="row">
                                        <div class="col-sm-4">Customer</div>
                                        <div class="col-sm-2 col-lg-2 col-xl-1">:</div>
                                        <div class="col-sm-6 col-lg-6 col-xl-7">
                                            {{--                                            <a href="{{ route('user.showDetailsRow', $entry->customer->id) }}" target="_blank">--}}
                                            {{
                                                $entry->customer->name
                                            }}
                                            {{--                                            </a>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="row">
                                        <div class="col-sm-4">Gateway</div>
                                        <div class="col-sm-2 col-lg-2 col-xl-1">:</div>
                                        <div class="col-sm-6 col-lg-6 col-xl-7">
                                            {{
                                                $entry->gateway_name
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="row">
                                        <div class="col-sm-4">Gateway SN</div>
                                        <div class="col-sm-2 col-lg-2 col-xl-1">:</div>
                                        <div class="col-sm-6 col-lg-6 col-xl-7">
                                            {{
                                                $entry->gateway_serial_number
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="row">
                                        <div class="col-sm-4">Status</div>
                                        <div class="col-sm-2 col-lg-2 col-xl-1">:</div>
                                        <div class="col-sm-6 col-lg-6 col-xl-7">
                                            {{
                                                $entry->status
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="row" title="{{$entry->created_at}}">
                                        <div class="col-sm-4">Created</div>
                                        <div class="col-sm-2 col-lg-2 col-xl-1">:</div>
                                        <div class="col-sm-6 col-lg-6 col-xl-7">
                                            {{
                                                $entry->created_at->diffForHumans()
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                    <div class="row" title="{{$entry->updated_at}}">
                                        <div class="col-sm-4">Updated</div>
                                        <div class="col-sm-2 col-lg-2 col-xl-1">:</div>
                                        <div class="col-sm-6 col-lg-6 col-xl-7">
                                            {{
                                                $entry->updated_at->diffForHumans()
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-12">Description :</div>
                                        <div class="col-sm-12">
                                            {!!
                                                $entry->description
                                            !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr/>

                        @forelse($entry->ponds as $pond)
                            <div class="body container-fluid mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            {{
                                                $pond->name
                                            }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="body container-fluid mb-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="accordion" id="accordionExample1">
                                            <div class="card mb-0">
                                                <div class="card-header bg-light" id="headingOne1">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link w-100 text-left text-dark"
                                                                type="button"
                                                                data-toggle="collapse"
                                                                data-target="#collapseOne1"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOne1">
                                                            Sensor Units
                                                        </button>
                                                    </h2>
                                                </div>

                                                <div id="collapseOne1"
                                                     class="collapse show"
                                                     aria-labelledby="headingOne1"
                                                     data-parent="#accordionExample1">
                                                    <div class="card-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>SN</th>
                                                                <th>Sensor</th>
                                                                <th>Sensor type</th>
                                                                <th>Serial number</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($entry->sensors as $sensor)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>
                                                                        <a href="{{ route('sensor.show', $sensor->id) }}"
                                                                           target="_blank">
                                                                            {{ $sensor->name }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $sensor->sensorType->name }}</td>
                                                                    <td>{{ $sensor->serial_number }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion" id="accordionExample2">
                                            <div class="card mb-0">
                                                <div class="card-header bg-light" id="headingOne2">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link w-100 text-left text-dark"
                                                                type="button"
                                                                data-toggle="collapse"
                                                                data-target="#collapseOne2"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOne2">
                                                            Switch Units
                                                        </button>
                                                    </h2>
                                                </div>

                                                <div id="collapseOne2"
                                                     class="collapse show"
                                                     aria-labelledby="headingOne2"
                                                     data-parent="#accordionExample2">
                                                    <div class="card-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>SN</th>
                                                                <th>Feeder</th>
                                                                <th>Serial number</th>
                                                                <th>Run status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($entry->feeders as $feeder)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>
                                                                        <a href="{{ route('feeder.show', $feeder->id) }}"
                                                                           target="_blank">
                                                                            {{ $feeder->name }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $feeder->serial_number }}</td>
                                                                    <td>{{ $feeder->run_status }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">No data found</div>
                        @endforelse

                        <div class="d-flex mt-4">
                            <div class="header container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                                        @include('crud::inc.button_stack', ['stack' => 'line'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>{{-- /.box-body --}}
        </div>{{-- /.box --}}

    </div>
    </div>
@endsection
