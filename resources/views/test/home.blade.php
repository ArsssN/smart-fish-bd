@extends('layouts.test')

@section('title', 'Home | Welcome')

@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mt-3">Welcome to the MQTT</h1>
                <h3 class="text-center mb-3">Dev<strong>Test</strong> Dashboard</h3>
                <p class="text-center">This is your central hub for managing and monitoring MQTT topics and messages.</p>
                <div class="text-center mt-4">
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-secondary">Visit Landing Page</a>
                </div>
            </div>
        </div>
    </div>
@endsection
