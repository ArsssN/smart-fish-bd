<?php

use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::get('backup/table/{table?}', 'BackupController@backupTable')->name('backup.table');
    Route::get('remove-seed', 'BackupController@removeSeed')->name('remove.seed');

    // get current user access token
    Route::get('access-token', function () {
        // clear old tokens
        //backpack_auth()->user()->tokens()->delete();
        $newTokenData = AuthHelper::getAccessToken(backpack_auth()->user());
        return response()->json($newTokenData);
    })->name('access-token.create');

    require __DIR__ . '/shell.php';
    Route::crud('route-list', 'RouteListCrudController');
    Route::crud('contact-us', 'ContactUsCrudController');
    Route::crud('social', 'SocialCrudController');
    Route::crud('footer-link-group', 'FooterLinkGroupCrudController');
    Route::crud('footer-link', 'FooterLinkCrudController');
    Route::crud('customer', 'UserCrudController');
    Route::crud('project', 'ProjectCrudController');
    Route::crud('controller', 'ControllerCrudController');
    Route::crud('sensor-type', 'SensorTypeCrudController');
    Route::crud('sensor', 'SensorCrudController');
    Route::crud('fish', 'FishCrudController');
    Route::crud('fish-weight', 'FishWeightCrudController');
    Route::crud('feeder', 'FeederCrudController');
    Route::crud('aerator', 'AeratorCrudController');
    Route::crud('feeder-history', 'FeederHistoryCrudController');
    Route::crud('pond', 'PondCrudController');
    Route::crud('sensor-unit', 'SensorUnitCrudController');
    Route::crud('switch-unit', 'SwitchUnitCrudController');
    Route::crud('switch-type', 'SwitchTypeCrudController');
    Route::crud('switch', 'SwitchCrudController');
    Route::crud('mqtt-data', 'MqttDataCrudController');


    Route::prefix('mqtt-data-history')->group(function () {
        Route::get('ajax-project-options', 'MqttDataHistoryCrudController@projectOptions');
        Route::get('ajax-pond-options', 'MqttDataHistoryCrudController@pondOptions');
        Route::get('ajax-sensor-type-options', 'MqttDataHistoryCrudController@sensorTypeOptions');
        Route::get('ajax-sensor-unit-options', 'MqttDataHistoryCrudController@sensorUnitOptions');
        Route::get('ajax-switch-type-options', 'MqttDataHistoryCrudController@switchTypeOptions');
        Route::get('ajax-switch-unit-options', 'MqttDataHistoryCrudController@switchUnitOptions');
    });
    Route::crud('mqtt-data-history', 'MqttDataHistoryCrudController');
    Route::crud('mqtt-data-switch-unit-history', 'MqttDataSwitchUnitHistoryCrudController');

    Route::group([
        'prefix' => 'report',
    ], function () {
        Route::get('machine', [
            \App\Http\Controllers\ReportController::class,
            'machine',
        ])->name('report.machine');
    });
    Route::get('charts/machine-report', 'Charts\MachineReportChartController@response')->name('charts.machine-report.index');
}); // this should be the absolute last line of this file