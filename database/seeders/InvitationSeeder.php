<?php

namespace Database\Seeders;

use App\Helpers\InvitationCardHelper;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Invitee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvitationSeeder extends Seeder
{
    /**
     * @param int $id
     * @return Event
     */
    private function getEvent(int $id): Event
    {
        return Event::query()->find($id);
    }

    /**
     * @param int $id
     * @return Invitee
     */
    private function getInvitee(int $id): Invitee
    {
        return Invitee::query()->find($id);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run2()
    {
        $invitationCardHelper = new InvitationCardHelper();

        $image = $invitationCardHelper->generate(
            $this->getEvent(1),
            $this->getInvitee(1),
            $code = createUniqueInvitationCode(8, 1, 1)
        );
        Invitation::query()->create([
            'event_id'   => 1,
            'code'       => $code,
            'invitee_id' => 1,
            'card'       => $image
        ]);

        $image = $invitationCardHelper->generate(
            $this->getEvent(2),
            $this->getInvitee(2),
            $code = createUniqueInvitationCode(8, 2, 2)
        );
        Invitation::query()->create([
            'event_id'   => 2,
            'code'       => $code,
            'invitee_id' => 2,
            'card'       => $image
        ]);

        $image = $invitationCardHelper->generate(
            $this->getEvent(2),
            $this->getInvitee(1),
            $code = createUniqueInvitationCode(8, 2, 1)
        );
        Invitation::query()->create([
            'event_id'   => 2,
            'code'       => $code,
            'invitee_id' => 1,
            'card'       => $image
        ]);

        $image = $invitationCardHelper->generate(
            $this->getEvent(2),
            $this->getInvitee(3),
            $code = createUniqueInvitationCode(8, 2, 3)
        );
        Invitation::query()->create([
            'event_id'   => 2,
            'code'       => $code,
            'invitee_id' => 3,
            'card'       => $image
        ]);
    }

    public function run()
    {
        require_once(__DIR__ . '/seeder-data/invitations.php');

        DB::table('invitations')->insert($invitations ?? []);
    }
}
