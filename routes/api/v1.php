<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ChangeController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RecoveryController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\PondController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SensorController;
use App\Http\Controllers\Api\SensorTypeController;
use App\Http\Controllers\ContactUsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/profile', [AuthController::class, 'userProfile']);
        Route::patch('/change/user-details', [ChangeController::class, 'changeUserDetails']);
        Route::post('/change/photo', [ChangeController::class, 'changeProfilePicture']);
        Route::patch('/change/password', [ChangeController::class, 'changePassword']);
    });

    Route::prefix('/sensor-type')->group(function () {
        Route::get('/list', [SensorTypeController::class, 'list']);
        Route::get('/feedback/{sensor}/{value}', [SensorTypeController::class, 'sensorFeedback']);
    });

    Route::prefix('/project')->group(function () {
        Route::get('/list', [ProjectController::class, 'list'])->name("api.v1.project.list");
        Route::get('/{project}', [ProjectController::class, 'show'])->name("api.v1.project.show");

        Route::prefix('/{project}/pond')->group(function () {
            Route::get('/list', [PondController::class, 'list'])->name("api.v1.pond.list");
            Route::get('/{pond}', [PondController::class, 'show'])->name("api.v1.pond.show");
        });
    });
});

// Auth
Route::prefix('/')->group(function () {
    Route::post('login', LoginController::class)->name('api.v1.login');
    // Route::post('register', RegisterController::class)->name('api.v1.register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', LogoutController::class)->name('api.v1.logout');
    });
});

/**
 * Forms
 */
Route::post('/contact-us', [ContactUsController::class, 'saveContactUs']);
// recovery
Route::post('recover/{type}', RecoveryController::class);
