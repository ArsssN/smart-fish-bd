<?php

namespace App\Console\Commands;

use App\Models\InvitationOtp;
use Illuminate\Console\Command;

class HandleExpiredInvitaionOTP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nockbay:delete-expired-invitation-otp';

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
        $invitationOtp = InvitationOtp::query();
        $invitationOtp->where('expires_at', '<', now()->subMinutes(InvitationOtp::EXPIRY_TIME));
        $invitationOtp->delete();

        return Command::SUCCESS;
    }
}
