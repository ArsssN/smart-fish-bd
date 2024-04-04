<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MqttDataSwitchUnitHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require_once(__DIR__ . '/seeder-data/mqtt_data_switch_unit_histories.php');

        DB::table('mqtt_data_switch_unit_histories')->insert($mqtt_data_switch_unit_histories ?? []);
    }
}