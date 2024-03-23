<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ChangeController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RecoveryController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SensorController;
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

    Route::prefix('/sensor')->group(function () {
        Route::get('/list', [SensorController::class, 'list']);
        Route::get('/feedback/{sensor}/{value}', [SensorController::class, 'sensorFeedback']);
    });

    Route::prefix('/project')->group(function () {
        Route::get('/list', [ProjectController::class, 'list']);
    });
});

// Auth
Route::prefix('/')->group(function () {
    Route::post('login', LoginController::class);
    Route::post('register', RegisterController::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', LogoutController::class);
    });
});

/**
 * Forms
 */
Route::post('/contact-us', [ContactUsController::class, 'saveContactUs']);
// recovery
Route::post('recover/{type}', RecoveryController::class);
