<?php

use App\Http\Controllers\Api\Auth\ChangeController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RecoveryController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\LayoutController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\InvitationController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
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
