<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'test',
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
], function () {
    Route::get('', [TestController::class, 'home'])->name('test.home');

    Route::get('mqtt', [TestController::class, 'mqtt'])->name('test.mqtt');

    Route::get('sensors', [TestController::class, 'sensors'])->name('test.sensors');

    Route::get('remove-seed', [TestController::class, 'removeSeed'])->name('test.remove-seed');

    Route::get('mail', [TestController::class, 'mail'])->name('test.mail');

    Route::get('convert-switches', [TestController::class, 'convertSwitches'])->name('test.convert-switches');
});