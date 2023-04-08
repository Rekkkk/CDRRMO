<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class GuidelinesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('guidelines')->insert([
            'guidelines_description' => ('E-LIGTAS TYPHOON GUIDELINES'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);

        DB::table('guidelines')->insert([
            'guidelines_description' => ('E-LIGTAS ROAD ACCIDENT GUIDELINES'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);

        DB::table('guidelines')->insert([
            'guidelines_description' => ('E-LIGTAS EARTHQUAKE GUIDELINES'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);

        DB::table('guidelines')->insert([
            'guidelines_description' => ('E-LIGTAS FLOODING GUIDELINES'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);

        DB::table('guidelines')->insert([
            'guidelines_description' => ('E-LIGTAS KILL ACCIDENT GUIDELINES'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }
}
