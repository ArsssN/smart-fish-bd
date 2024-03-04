<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require_once(__DIR__ . '/seeder-data/abouts.php');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('abouts')->insert($abouts ?? []);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
