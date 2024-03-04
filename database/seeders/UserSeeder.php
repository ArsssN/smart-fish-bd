<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::query()->firstOrCreate([
            'name'  => 'Admin',
            'email' => 'smart-fish-bd@yopmail.com',
        ], [
            'password'          => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }
}
