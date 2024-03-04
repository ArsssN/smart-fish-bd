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
