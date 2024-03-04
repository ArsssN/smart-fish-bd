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
/*Route::get('/phpinfo', function () {
    return phpinfo();
});*/
