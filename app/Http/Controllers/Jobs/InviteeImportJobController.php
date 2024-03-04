<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use App\Imports\InviteeImport;
use App\Jobs\InviteeImportJob;
use App\Models\Event;
use Illuminate\Http\Request;

class InviteeImportJobController extends Controller
{
    public function readExcel(Request $request)
    {
        $path = public_path('uploads/invitee_list.xlsx');
        $data = \Excel::toCollection(new InviteeImport, $path);

        $event = Event::query()->findOrFail(1);

        $inviteeImportJob = new InviteeImportJob($data[0]->toArray(), $event);
        // $inviteeImportJob->onQueue('invitee-import');
        $this->dispatch($inviteeImportJob);
    }
}
