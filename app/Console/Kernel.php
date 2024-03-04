<?php

namespace App\Console;

use App\Jobs\DailyEventScheduleJob;
use App\Models\Event;
use App\Models\InvitationOtp;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // daily action
        /*$schedule->job(new DailyEventScheduleJob())
            ->everySixHours()
            ->emailOutputOnFailure('afzalbd1@gmail.com');

        // delete expired invitation otp
        $schedule->command('nockbay:delete-expired-invitation-otp')
            ->everyThirtyMinutes()
            ->emailOutputOnFailure('afzalbd1@gmail.com');

        // delete expired events
        $schedule->command('nockbay:expire-events-with-cascade')
            ->everySixHours()
            ->emailOutputOnFailure('afzalbd1@gmail.com');

        // failed jobs retry every 6 hours
        $schedule->command('queue:retry all')
            ->everySixHours()
            ->emailOutputOnFailure('afzalbd1@gmail.com');*/
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
