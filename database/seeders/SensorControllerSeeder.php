<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorControllerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require_once(__DIR__ . '/seeder-data/sensor_controller.php');

        DB::table('sensor_controller')->insert($sensor_controller ?? []);
    }
}
