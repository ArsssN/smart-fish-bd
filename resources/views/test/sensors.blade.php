@extends('layouts.test')

@section('title', 'Sensors | ')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Sensors</h1>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Created At</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($sensors as $sensor)
                    <tr>
                        <td>{{ $sensor->id }}</td>
                        <td>{{ $sensor->name }}</td>
                        <td>{{ $sensor->value }}</td>
                        <td>{{ $sensor->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-12 col-lg-4 offset-lg-4">
            <h1 class="text-center">Test Sensors</h1>

            @if ($sensor_message)
                <div class="alert alert-success">
                    {{ $sensor_message }}
                </div>
            @endif

            <form action="">
                <div class="mb-3">
                    <label for="sensor_id">Sensor</label>
                    <select class="form-control ds-input" name="sensor_id" id="sensor_id">
                        <option value="">Select Sensor</option>
                        @foreach ($sensors as $sensor)
                            <option value="{{ $sensor->id }}"
                                {{ request('sensor_id') == $sensor->id ? 'selected' : ''  }}
                            >{{ $sensor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="value">Sensor</label>
                    <input class="form-control ds-input" type="text" name="value" id="value"
                           value="{{ request('value') }}"
                           placeholder="Enter Sensor Value">
                </div>
                <input type="submit" value="Submit" class="btn btn-primary">
            </form>
        </div>
    </div>
@endsection
