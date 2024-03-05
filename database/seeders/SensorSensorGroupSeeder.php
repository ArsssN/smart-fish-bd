<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorSensorGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require_once(__DIR__ . '/seeder-data/sensor_sensor_group.php');

        DB::table('sensor_sensor_group')->insert($sensor_sensor_group ?? []);
    }
}
