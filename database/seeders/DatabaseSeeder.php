<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            UserDetailsSeeder::class,
            SettingSeeder::class,
            PermissionSeeder::class,
            AboutSeeder::class,
            FooterLinkGroupSeeder::class,
            FooterLinkSeeder::class,
            SocialSeeder::class,
            SensorTypeSeeder::class,
            SensorSeeder::class,
            ControllerSeeder::class,
            ProjectSeeder::class,
            SensorControllerSeeder::class,
            ProjectControllerSeeder::class
        ]);
    }
}
