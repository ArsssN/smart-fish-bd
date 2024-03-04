<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Invitation;
use App\Models\InvitationOtp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run2()
    {
        Event::query()->create([
            'title'        => 'Event 1',
            'slug'         => 'event-1',
            'description'  => 'Event 1 description',
            'start_date'   => '2021-01-01',
            'end_date'     => '2021-01-01',
            'location'     => 'Event 1 location',
            'status'       => 'active',
            'card_details' => '',
        ]);

        Event::query()->create([
            'title'        => 'Event 2',
            'slug'         => 'event-2',
            'description'  => 'Event 2 description',
            'start_date'   => '2021-01-01',
            'end_date'     => '2021-01-01',
            'location'     => 'Event 2 location',
            'status'       => 'active',
            'card_details' => '',
        ]);
    }

    public function run()
    {
        require_once(__DIR__ . '/seeder-data/events.php');

        DB::table('events')->insert($events ?? []);
    }
}
