<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>WinguHR</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    {{-- Bootstrap 5 latest CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div class="container">
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
</div>
{{-- Bootstrap 5 latest CDN --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
