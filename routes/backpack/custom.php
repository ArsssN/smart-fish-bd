<?php

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

    require __DIR__ . '/shell.php';
    Route::crud('route-list', 'RouteListCrudController');
    Route::crud('contact-us', 'ContactUsCrudController');
    Route::crud('social', 'SocialCrudController');
    Route::crud('footer-link-group', 'FooterLinkGroupCrudController');
    Route::crud('footer-link', 'FooterLinkCrudController');
}); // this should be the absolute last line of this file
