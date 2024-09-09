<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SwitchUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require_once(__DIR__ . '/seeder-data/switch_units.php');

        foreach (($switch_units ?? []) as $switch_unit) {
            $switches = $switch_unit['switches'];
            unset($switch_unit['switches']);
            $lastInsertedId = DB::table('switch_units')->insertGetId($switch_unit);
            $switches = json_decode($switches, true);

            foreach ($switches as $key => $switchDetail) {
                $switches[$key] = [
                    ...$switchDetail,
                    'switch_unit_id' => $lastInsertedId,
                ];
            }

            DB::table('switch_unit_switches')->insert($switches);
        }
    }
}
