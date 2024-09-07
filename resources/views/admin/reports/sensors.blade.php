{{--@extends('backpack::layouts.top_left')--}}
@extends('backpack::blank')

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Sensors</span>
            <small>Reports</small>
        </h2>
    </section>
    <div class="container-fluid animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-filters mb-0 pb-0 pt-0 my-2">
                    <a class="nav-item d-none d-lg-block"><span class="la la-filter"></span></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bp-filters-navbar"
                            aria-controls="bp-filters-navbar" aria-expanded="false" aria-label="Toggle filters">
                        <span class="la la-filter"></span> Filters
                    </button>

                    <form action="" method="GET" class="m-0">
                        <div class="collapse navbar-collapse" id="bp-filters-navbar">
                            <ul class="nav navbar-nav">
                                <li class="nav-item my-auto" title="Pond">
                                    <select name="pond_id" id="pond_id" class="form-control">
                                        <option value="">Select Pond</option>
                                        @foreach($ponds as $pond)
                                            <option
                                                value="{{$pond->id}}" {{request()->get('pond_id') == $pond->id ? 'selected' : ''}}>
                                                {{$pond->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </li>
                                <li class="nav-item my-auto" title="Start Date">
                                    <input type="datetime-local"
                                           value="{{ request()->get('start_date') ?? $start_date ?? \Illuminate\Support\Carbon::now()->startOfDay()->format('Y-m-d H:i:s') }}"
                                           name="start_date" id="start_date" class="form-control"
                                           placeholder="Start Date">
                                </li>
                                <li class="nav-item my-auto" title="End Date">
                                    <input type="datetime-local"
                                           value="{{ request()->get('end_date') ?? $end_date ?? \Illuminate\Support\Carbon::now()->endOfDay()->format('Y-m-d H:i:s') }}"
                                           name="end_date" id="end_date" class="form-control"
                                           placeholder="End Date">
                                </li>

                                <li class="nav-item pl-3 mr-3 border-right"></li>
                                {{--<li class="nav-item my-auto d-none" title="Sensors">
                                    <select name="sensors[]" id="sensors" class="form-control" multiple="multiple">
                                        @foreach($sensors as $sensor)
                                            <option
                                                value="{{$sensor->remote_name}}" {{in_array($sensor->remote_name, request()->get('sensors') ?? []) ? 'selected' : ''}}>
                                                {{$sensor->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </li>--}}
                                @foreach($sensors as $sensor)
                                    <li class="nav-item my-auto" title="Sensors">
                                        <label class="m-0" for="sensor_{{$sensor->remote_name}}"
                                               style="color:{{$colors[$sensor->remote_name]}}">
                                            <input type="checkbox" name="sensors[]"
                                                   id="sensor_{{$sensor->remote_name}}"
                                                   value="{{$sensor->remote_name}}" {{in_array($sensor->remote_name, request()->get('sensors') ?? []) ? 'checked' : ''}}>
                                            {{$labelList[$sensor->remote_name]}}
                                        </label>
                                    </li>
                                @endforeach

                                <li class="nav-item pl-3 mr-3 border-right"></li>
                                <li class="nav-item my-auto">
                                    <button type="submit" class="btn btn-light border">
                                        <i class="la la-search"></i> Search
                                    </button>
                                </li>

                                <li class="nav-item m-auto">
                                    <a href=" {{url()->current()}}" id="remove_filters_button"
                                       class="nav-link {{count(request()->query()) ? '' : 'invisible'}}">
                                        <i class="la la-eraser"></i> Reset filters
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </nav>
                <div class="">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card no-padding no-border">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_scripts')
    <script src="{{url('packages/chartjs/chart-4.4.2.min.js')}}"></script>
    <script src="{{url('packages/chartjs/chartjs-plugin-zoom.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>

    <script>
        const ctx = document.getElementById('myChart');
        const datasets = @json($graphData);

        console.log([datasets])

        new Chart(ctx, {
            type: 'line',
            data: {
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    // zoom: {
                    //     zoom: {
                    //         wheel: {
                    //             enabled: true,
                    //         },
                    //         pinch: {
                    //             enabled: true
                    //         },
                    //         mode: 'x',
                    //     }
                    // }
                }
            }
        });
    </script>
@endsection

