<?php

namespace Database\Seeders;

use App\Models\Invitation;
use App\Models\InvitationOtp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvitationOtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invitations = Invitation::query()->get();

        foreach ($invitations as $invitation) {
            InvitationOtp::query()->create([
                'invitation_id' => $invitation->id,
                'otp'           => rand(100000, 999999),
                'expires_at'    => now()->addMinutes(510),
            ]);
        }
    }
}
