<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class HandleExpiredEventsWithCasCade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nockbay:expire-events-with-cascade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $events = Event::query();
        $events->where([
            ['end_date', '<', now()],
            ['status', 'active']
        ]);

        foreach ($events->get() as $event) {
            $event->invitations->each(function ($invitation) {
                $invitation->invitationOtp()->delete();
            });
            $event->invitations()->delete();
        }

        $events->update([
            'status' => 'expired'
        ]);

        return Command::SUCCESS;
    }
}
