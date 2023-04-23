<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EarthquakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('earthquake')->insert([
            'magnitude' => ('3.0'),
            'disaster_id' => ('2'),
        ]);

        DB::table('earthquake')->insert([
            'magnitude' => ('4.5'),
            'disaster_id' => ('2'),
        ]);

        DB::table('earthquake')->insert([
            'magnitude' => ('6.8'),
            'disaster_id' => ('2'),
        ]);
    }
}
