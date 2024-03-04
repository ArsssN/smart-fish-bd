<?php

namespace App\Jobs;

use App\Helpers\EventScheduleHelper;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DailyEventScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $events = Event::query()
            ->where([
                ['start_date', '>=', now()->endOfDay()],
                ['status', '=', 'active'],
            ])
            ->get();

        logger("Total events: " . count($events));
        foreach ($events as $event) {
            $eventScheduleHelper = EventScheduleHelper::init($event);

            if ($eventScheduleHelper->ifEventIsScheduledToday()) {
                logger("Event title: " . $event->title);
                $inviteeReminderScheduleJob = new InviteesReminderScheduleJob($event);
                dispatch($inviteeReminderScheduleJob);
            }
        }
    }
}
