<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\Invitee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class InviteesReminderScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Event|Builder|Model
     */
    protected Event|Builder|Model $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Event|Model|Builder $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $inviteesQuery = Invitee::query()
            ->whereHas('invitation.event', function (Builder $query) {
                $query->where('id', '=', $this->event->id);
            });

        $smsTo = '';

        logger("Total invitees: " . $inviteesQuery->count());
        $inviteesQuery->chunk(500, function ($invitees) use (&$smsTo) {
            foreach ($invitees as $invitee) {
                logger("Invitee name: " . $invitee->name);

                $phone = $invitee->phone . ',';

                if (!Str::of($smsTo)->contains($phone)) {
                    $smsTo .= $invitee->phone . ',';
                }


                $inviteeReminderNotificationJob = new InviteeReminderNotificationJob($invitee);
                dispatch($inviteeReminderNotificationJob);
            }

            $smsTo = rtrim($smsTo, ',');

            if (!!$smsTo) {
                $message               =
                    "Dear sir, you have been invited to an event {$this->event->title} on {$this->event->start_date->format('d M Y')}.";
                $inviteeReminderSMSJob = new InviteeReminderSMSJob($smsTo, $message);
                dispatch($inviteeReminderSMSJob);
            }

            $smsTo = '';
        });
    }
}
