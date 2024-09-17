{{--@extends('backpack::layouts.top_left')--}}
@extends('backpack::blank')

@php
    $_start_date = request()->get('start_date') ?? $start_date ?? \Illuminate\Support\Carbon::now()->startOfDay()->format('Y-m-d H:i');;
    $_end_date = request()->get('end_date') ?? $end_date ?? \Illuminate\Support\Carbon::now()->endOfDay()->format('Y-m-d H:i');
@endphp

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
                                           value="{{ $_start_date }}"
                                           name="start_date" id="start_date" class="form-control"
                                           placeholder="Start Date">
                                </li>
                                <li class="nav-item my-auto" title="End Date">
                                    <input type="datetime-local"
                                           value="{{ $_end_date }}"
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
                                    <a class="nav-link" id="chart-tab" data-toggle="tab" href="#chart" role="tab"
                                       aria-controls="chart" aria-selected="true">Chart</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="table-tab" data-toggle="tab" href="#table" role="tab"
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
                                <div class="tab-pane fade" id="chart" role="tabpanel"
                                     aria-labelledby="chart-tab">
                                    <div class="card no-padding no-border">
                                        <div class="mx-3 my-2 flex">
                                            @foreach($borderColors as $key => $borderColor)
                                                <label for="borderColor_{{$key}}" class="mr-3"
                                                       title="Switch: {{$key}}"
                                                       style="color: {{$borderColor}}"
                                                >
                                                    <input type="checkbox"
                                                           onclick="toggleBars(event, {{+$key-1}})"
                                                           checked="checked"
                                                           id="borderColor_{{$key}}"
                                                           class="me-2">
                                                    <strong>
                                                        Switch: {{$key}}
                                                    </strong>
                                                </label>
                                            @endforeach
                                        </div>
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>

                                <!-- Table Tab Pane -->
                                <div class="tab-pane fade show active" id="table" role="tabpanel"
                                     aria-labelledby="table-tab">
                                    <div class="card no-padding no-border m-0">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover m-0">
                                                <thead>
                                                <tr>
                                                    <th style="width: 5rem;">#</th>
                                                    <th>Switch</th>
                                                    <th>Start At</th>
                                                    <th>End At</th>
                                                    <th>Cumulative Run time</th>
                                                    <th title="Total runtime of last on-off cycle">Last Runtime</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php($index = 0)
                                                @foreach($graphData[0]["data"] as $key => $runtime)
                                                    @php(++$index)
                                                    @php($status = $graphData[0]["status"][$index] ?? '')
                                                    @php($isOn = $status == 'on')
                                                    <tr
                                                        class="{{$isOn ? 'table-success' : 'table-danger'}}"
                                                    >
                                                        <td>
                                                            {{$index}}
                                                        </td>
                                                        <td>
                                                            {{$runtime ? "Aerator" : "-"}}
                                                        </td>
                                                        <td>
                                                            {{
                                                                $graphData[0]['on_off'][$index]['on']
                                                                ? \Illuminate\Support\Carbon::make($graphData[0]['on_off'][$index]['on'])->format('Y-m-d H:i:s')
                                                                : '-'
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                $graphData[0]['on_off'][$index]['off']
                                                                ? \Illuminate\Support\Carbon::make($graphData[0]['on_off'][$index]['off'])->format('Y-m-d H:i:s')
                                                                : '-'
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                getIntervalRuntime($runtime, $index, $graphData[0], [$_start_date, $_end_date])
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                $runtime
                                                                ? $graphData[0]["formated_run_time"][$index] ?? "-"
                                                                : "-"
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{$status}}
                                                        </td>
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
        const baseDatasets = @json($graphData);
        const labels = @json($labels);

        console.log([datasets, labels])

        let _chart = null;

        const initChart = (datasets) => {
            _chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    // labels: labels,
                    datasets: datasets,
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {}
                }
            });

            // Store the chart instance in window for access in toggleBars
            window.myChart = _chart;
        }

        initChart(datasets);

        // Function to toggle the visibility of a specific bar
        function toggleBars(event, barIndex, datasetIndex = 0) {
            const chart = window.myChart;

            if (!chart || !chart.data || !chart.data.datasets || !chart.data.datasets[datasetIndex]) {
                console.error('Chart or dataset not initialized.');
                return;
            }

            const dataset = chart.data.datasets[datasetIndex];

            // Determine the visibility based on the checkbox state
            const isChecked = event.target.checked;

            console.log('isChecked', isChecked)

            if (!isChecked) {
                delete dataset['data'][`Aerator: ${barIndex + 1}`];
                dataset['backgroundColor'].splice(barIndex, 1);
                dataset['borderColor'].splice(barIndex, 1);

                console.log('111', dataset['borderColor'])
            } else {
                let data_keys = Object.keys(dataset['data']);
                let data_values = Object.values(dataset['data']);
                data_keys = [
                    ...data_keys.slice(0, barIndex),
                    `Aerator: ${barIndex + 1}`,
                    ...data_keys.slice(barIndex)
                ]
                data_values = [
                    ...data_values.slice(0, barIndex),
                    baseDatasets[datasetIndex]['data'][`Aerator: ${barIndex + 1}`],
                    ...data_values.slice(barIndex)
                ]
                let data = data_keys.reduce((acc, key, index) => {
                    acc[key] = data_values[index];
                    return acc;
                }, {});
                dataset['data'] = {};
                Object.entries(data).forEach(([key, value]) => {
                    dataset['data'][key] = value;
                });
                chart.update();

                let backgroundColor_values = baseDatasets[datasetIndex]['backgroundColor'];
                backgroundColor_values = [
                    ...backgroundColor_values.slice(0, barIndex),
                    baseDatasets[datasetIndex]['backgroundColor'][`${barIndex}`],
                    ...backgroundColor_values.slice(barIndex + 1)
                ]
                dataset['backgroundColor'] = [];
                backgroundColor_values.forEach((value, index) => {
                    dataset['backgroundColor'][index] = value;
                });
                chart.update();

                let borderColor_values = baseDatasets[datasetIndex]['borderColor'];
                borderColor_values = [
                    ...borderColor_values.slice(0, barIndex),
                    baseDatasets[datasetIndex]['borderColor'][`${barIndex}`],
                    ...borderColor_values.slice(barIndex + 1)
                ]

                console.log(
                    "abc",
                    borderColor_values.slice(0, barIndex),
                    [baseDatasets[datasetIndex]['borderColor'][`${barIndex}`]],
                    borderColor_values.slice(barIndex + 1)
                )

                dataset['borderColor'] = [];
                borderColor_values.forEach((value, index) => {
                    dataset['borderColor'][index] = value;
                });
                chart.update();
            }

            // destroy the chart
            chart.destroy();

            // reinitialize the chart
            initChart(datasets);
        }
    </script>
@endsection

