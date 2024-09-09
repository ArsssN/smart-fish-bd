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
    Route::get('', [TestController::class, 'home'])->name('test.home.index');

    Route::get('mqtt', [TestController::class, 'mqtt'])->name('test.mqtt.index');

    Route::get('aerator-manage', [TestController::class, 'aeratorManage'])->name('test.aerator-manage.index');

    Route::get('sensors', [TestController::class, 'sensors'])->name('test.sensors.index');

    Route::get('remove-seed', [TestController::class, 'removeSeed'])->name('test.remove-seed.index');

    Route::get('mail', [TestController::class, 'mail'])->name('test.mail.index');

    Route::get('convert-switches', [TestController::class, 'convertSwitches'])->name('test.convert-switches.index');
});
