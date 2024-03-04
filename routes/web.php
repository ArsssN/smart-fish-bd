<?php

use App\Http\Controllers\Jobs\InviteeImportJobController;
use App\Http\Controllers\SMSController;
use App\Http\Resources\Api\InvitationResource;
use App\Http\Resources\Api\InvitationUserProfileResource;
use App\Imports\InviteeImport;
use App\Jobs\InviteeImportJob;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Invitee;
use App\Notifications\InviteeOTPNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// php info
Route::get('/phpinfo', function () {
    return phpinfo();
});

// image
Route::get('/image/{event}/{invitee}', function (Event $event, Invitee $invitee) {
    $image = (new App\Helpers\InvitationCardHelper)->generate($event, $invitee);

    return \Illuminate\Support\Facades\Blade::render("<img src='" . $image['front']
                                                     . "' width='350px' /><br/><img src='" . $image['back']
                                                     . "' width='350px' />");
});

// image
Route::get('/otp/{event}/{invitee}', function (Event $event, Invitee $invitee) {
    $invitation = $invitee->invitation()->where('event_id', $event->id)->first();
    //dd($invitation);
    $invitee->notify(new InviteeOTPNotification($invitation, '/'));
});

// read excel
Route::get('/read-excel', [InviteeImportJobController::class, 'readExcel']);

// sms
Route::group(['prefix' => 'sms'], function () {
    Route::get('/balance', [SMSController::class, 'balance']);
    Route::get('/send', [SMSController::class, 'sendSMS']);
});

// checkInvitation
Route::get('/checkInvitation', [\App\Http\Controllers\InvitationController::class, 'checkInvitation']);

// sslcommerz
Route::group(['prefix' => 'sslcommerz'], function () {
    Route::get('/', function () {

        return \Illuminate\Support\Facades\Blade::render('<script src="/assets/js/sandbox.js"></script><button class="your-button-class" id="sslczPayBtn"
                token="if you have any token validation"
                postdata="your javascript arrays or objects which requires in backend"
                order=\'{"amount":100,"currency":"BDT","description":"Computer.","name":"Customer Name","email":"","phone":"","address":"","city":"","postcode":"","country":""}\'
                endpoint="/sslcommerz/pay-via-ajax"> Pay Now
        </button>');
        //dd('sslcommerz');
    });

    Route::get('/example1', [\App\Http\Controllers\SslCommerzPaymentController::class, 'exampleEasyCheckout']);
    Route::get('/example2', [\App\Http\Controllers\SslCommerzPaymentController::class, 'exampleHostedCheckout']);

    Route::get('/pay', [\App\Http\Controllers\SslCommerzPaymentController::class, 'index']);
    Route::post('/pay-via-ajax', [\App\Http\Controllers\SslCommerzPaymentController::class, 'payViaAjax']);
    Route::post('/success', [\App\Http\Controllers\SslCommerzPaymentController::class, 'success']);
    Route::post('/fail', [\App\Http\Controllers\SslCommerzPaymentController::class, 'fail']);
    Route::post('/cancel', [\App\Http\Controllers\SslCommerzPaymentController::class, 'cancel']);
    Route::post('/ipn', [\App\Http\Controllers\SslCommerzPaymentController::class, 'ipn']);
});
