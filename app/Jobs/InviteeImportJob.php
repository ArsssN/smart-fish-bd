<?php

namespace App\Jobs;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class InviteeImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array               $inviteeData;
    protected Event|Builder|Model $event;
    protected InviteeInsertJob    $inviteeInsertJob;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($inviteeData, Event|Builder|Model $event)
    {
        $this->inviteeData = $inviteeData;
        $this->event       = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->inviteeData as $invitee) {
            dispatch(new InviteeInsertJob($invitee, $this->event));
        }
    }
}
