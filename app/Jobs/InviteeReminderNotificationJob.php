<?php

namespace App\Jobs;

use App\Models\Invitee;
use App\Notifications\InviteeReminderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InviteeReminderNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Invitee|Builder|Model
     */
    protected Invitee|Builder|Model $invitee;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Invitee|Model|Builder $invitee)
    {
        $this->invitee = $invitee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->invitee->notify(new InviteeReminderNotification());
    }
}
