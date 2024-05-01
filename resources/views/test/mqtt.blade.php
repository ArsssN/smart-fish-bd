@extends('layouts.test')

@section('title', 'MQTT | ')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">MQTT</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 order-0 order-md-1 col-md-5 col-lg-4">
                <h2>Response</h2>
                <hr/>
                @if($publishMessage['addr'] ?? '')
                    @if(($publishMessage['relay'] ?? '') === '000000000000')
                        <div class="alert alert-danger">
                            There is no publishable data
                        </div>
                    @else
                        <div class="alert alert-light">
                            Test data has not been published or saved
                        </div>
                        @dump($publishMessage ?? '')
                    @endif
                @else
                    <div class="alert alert-info">
                        No data found
                    </div>
                @endif
            </div>
            <div class="col-12 order-1 order-md-0 col-md-7 col-lg-8">
                <h2>Request</h2>
                <hr/>
                <form action="" class="mb-3" method="GET">
                    <div class="mb-3">
                        <fieldset>
                            <legend>Topic</legend>
                            <div class="form-group mb-2">
                                <label for="topic">Topic</label>
                                <input class="form-control ds-input" type="text" name="topic" id="topic"
                                       value="{{ request('topic') }}"
                                       placeholder="Enter Topic">
                            </div>
                            <div class="input-group mb-3 d-none">
                                <span class="input-group-text">SUB/</span>
                                <input class="form-control ds-input" type="text"
                                       value="{{ request('topic') }}"
                                       placeholder="Topic">
                                <span class="input-group-text">/PUB</span>
                            </div>
                        </fieldset>
                    </div>
                    <div class="mb-3">
                        <fieldset>
                            <legend>Message</legend>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="gw_id">Gateway ID</label>
                                        <input class="form-control ds-input" type="text" name="gw_id" id="gw_id"
                                               value="{{ request('gw_id') }}"
                                               placeholder="Enter Gateway ID (gw_id)">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="type">Type</label>
                                        <select class="form-control ds-input" name="type" id="type">
                                            <option value="">Select Type</option>
                                            <option
                                                value="sen" {{ (request('type') ?? 'sen') == 'sen' ? 'selected' : '' }}>
                                                Sensor
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="addr">Serial Number</label>
                                        <input class="form-control ds-input" type="text" name="addr" id="addr"
                                               value="{{ request('addr') }}"
                                               placeholder="Enter Serial Number (addr)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <h5>
                                        Data
                                    </h5>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="data-food">Food</label>
                                        <input class="form-control ds-input" type="text" name="data[food]"
                                               id="data-food"
                                               value="{{ request('data')['food'] ?? '' }}"
                                               placeholder="Enter Food data">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="data-tds">TDS</label>
                                        <input class="form-control ds-input" type="text" name="data[tds]" id="data-tds"
                                               value="{{ request('data')['tds'] ?? '' }}"
                                               placeholder="Enter TDS data">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="data-rain">Rain</label>
                                        <input class="form-control ds-input" type="text" name="data[rain]"
                                               id="data-rain"
                                               value="{{ request('data')['rain'] ?? '' }}"
                                               placeholder="Enter Rain data">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="data-temp">Temperature</label>
                                        <input class="form-control ds-input" type="text" name="data[temp]"
                                               id="data-temp"
                                               value="{{ request('data')['temp'] ?? '' }}"
                                               placeholder="Enter Temperature data">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="data-o2">Oxygen</label>
                                        <input class="form-control ds-input" type="text" name="data[o2]" id="data-o2"
                                               value="{{ request('data')['o2'] ?? '' }}"
                                               placeholder="Enter Oxygen data">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-2">
                                        <label for="data-ph">PH</label>
                                        <input class="form-control ds-input" type="text" name="data[ph]" id="data-ph"
                                               value="{{ request('data')['ph'] ?? '' }}"
                                               placeholder="Enter PH data">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <input type="submit" value="Submit" class="btn btn-primary"/>
                            <a href="{{ route('test.mqtt', \Illuminate\Support\Arr::query($autoFill ?? [])) }}"
                               class="btn btn-light">Auto Fill</a>
                        </div>
                        <a href="{{ route('test.mqtt') }}" class="btn btn-danger">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
