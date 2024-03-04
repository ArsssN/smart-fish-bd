<?php

namespace Database\Seeders;

use App\Models\Invitee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InviteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run2()
    {
        Invitee::query()->create([
            'name'    => 'Test User',
            'slug'    => 'test-user',
            'email'   => 'email1@example.com',
            'phone'   => '4234567890',
            'address' => 'Test Address',
        ]);

        Invitee::query()->create([
            'name'    => 'Test User 2',
            'slug'    => 'test-user-2',
            'email'   => 'email2@example.com',
            'phone'   => '1234567890',
            'address' => 'Test Address 2',
        ]);

        Invitee::query()->create([
            'name'    => 'Test User 3',
            'slug'    => 'test-user-3',
            'email'   => 'email3@example.com',
            'phone'   => '2234567890',
            'address' => 'Test Address 3',
        ]);
    }

    public function run()
    {
        require_once(__DIR__ . '/seeder-data/invitees.php');

        DB::table('invitees')->insert($invitees ?? []);
    }
}
