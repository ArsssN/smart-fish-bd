<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorTypeSensorUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require_once(__DIR__ . '/seeder-data/sensor_type_sensor_unit.php');

        DB::table('sensor_type_sensor_unit')->insert($sensor_type_sensor_unit ?? []);
    }
}
