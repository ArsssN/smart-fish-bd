<?php

use Illuminate\Support\Facades\Route;

Route::controller('ShellCommandController')->prefix('shell')->group(function () {
    Route::prefix('command')->group(function () {
        Route::prefix('git')->group(function () {
            Route::get('config', 'config')->name('shell.command.git.config');
            Route::get('status', 'status')->name('shell.command.git.status');
            Route::get('stash', 'stash')->name('shell.command.git.stash');
            Route::get('pull', 'pull')->name('shell.command.git.pull');
            Route::get('commit', 'commit')->name('shell.command.git.commit');
            Route::get('push', 'push')->name('shell.command.git.push');
            Route::get('commit-push', 'commitPush')->name('shell.command.git.commit.push');
        });
        Route::prefix('artisan')->group(function () {
            Route::get('migrate-fresh-seed', 'migrateFreshSeed')->name('shell.command.artisan.migrate.fresh.seed');
        });
        Route::get('/any/{command?}', 'call')->name('shell.command.any.command'); // base64 $command
    });
});
