<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class RoadAccidentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('road_accident')->insert([
            'casualties' => ('1'),
            'injuries' => ('1'),
            'disaster_id' => ('3'),
            'created_at' => Date::now(),
        ]);

        DB::table('road_accident')->insert([
            'casualties' => ('2'),
            'injuries' => ('2'),
            'disaster_id' => ('3'),
            'created_at' => Date::now(),
        ]);

        DB::table('road_accident')->insert([
            'casualties' => ('3'),
            'injuries' => ('3'),
            'disaster_id' => ('3'),
            'created_at' => Date::now(),
        ]);
    }
}
