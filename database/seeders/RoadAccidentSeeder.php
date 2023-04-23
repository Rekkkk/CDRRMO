<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoadAccidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('road_accident')->insert([
            'casualties' => ('1'),
            'injuries' => ('1'),
            'disaster_id' => ('3'),
        ]);

        DB::table('road_accident')->insert([
            'casualties' => ('2'),
            'injuries' => ('2'),
            'disaster_id' => ('3'),
        ]);

        DB::table('road_accident')->insert([
            'casualties' => ('3'),
            'injuries' => ('3'),
            'disaster_id' => ('3'),
        ]);
    }
}
