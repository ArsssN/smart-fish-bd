{{--@extends('backpack::layouts.top_left')--}}
@extends('backpack::blank')

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Aerators</span>
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
                        <div class="col-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="chart-tab" data-toggle="tab" href="#chart" role="tab"
                                       aria-controls="chart" aria-selected="true">Chart</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="table-tab" data-toggle="tab" href="#table" role="tab"
                                       aria-controls="table" aria-selected="false">Table</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Tab content -->
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="tab-content">
                                <!-- Chart Tab Pane -->
                                <div class="tab-pane fade show active" id="chart" role="tabpanel"
                                     aria-labelledby="chart-tab">
                                    <div class="card no-padding no-border">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>

                                <!-- Table Tab Pane -->
                                <div class="tab-pane fade" id="table" role="tabpanel" aria-labelledby="table-tab">
                                    <div class="card no-padding no-border m-0">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover m-0">
                                                <thead>
                                                <tr>
                                                    <th style="width: 5rem;">#</th>
                                                    <th>Switch</th>
                                                    <th>Runtime</th>
                                                    {{--<th>Status</th>--}}
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php($index = 0)
                                                @foreach($graphData[0]["data"] as $key => $runtime)
                                                    <tr>
                                                        <td>
                                                            {{++$index}}
                                                        </td>
                                                        <td>
                                                            {{$runtime ? "Aerator" : "Feeder"}}
                                                        </td>
                                                        <td>
                                                            {{
                                                                $runtime
                                                                ? $graphData[0]["formated_run_time"][$index] ?? "-"
                                                                : "-"
                                                            }}
                                                        </td>
                                                        {{--<td>
                                                            {{$graphData[0]["status"][$index] ?? "-"}}
                                                        </td>--}}
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
        const labels = @json($labels);

        console.log([datasets, labels])

        new Chart(ctx, {
            type: 'bar',
            data: {
                // labels: labels,
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

