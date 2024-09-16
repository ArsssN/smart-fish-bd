<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Controllers\UserCrudController::class, //this is package controller
            \App\Http\Controllers\Admin\UserCrudController::class //this should be your own controller
        );
        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Controllers\RoleCrudController::class, //this is package controller
            \App\Http\Controllers\Admin\RoleCrudController::class //this should be your own controller
        );
        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Controllers\PermissionCrudController::class, //this is package controller
            \App\Http\Controllers\Admin\PermissionCrudController::class //this should be your own controller
        );
        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest::class, //this is package controller
            \App\Http\Requests\UserRequest::class //this should be your own controller
        );
        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest::class, //this is package controller
            \App\Http\Requests\UserRequest::class //this should be your own controller
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        proMode();

        // Customize the logger to add file and line number to every log
        $monolog = Log::getLogger();
        $monolog->pushProcessor(new IntrospectionProcessor(Logger::DEBUG));
    }
}
