<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class GuidelineSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('guideline')->insert([
            'guideline_description' => ('E-LIGTAS TYPHOON GUIDELINE'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);

        DB::table('guideline')->insert([
            'guideline_description' => ('E-LIGTAS ROAD ACCIDENT GUIDELINE'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);

        DB::table('guideline')->insert([
            'guideline_description' => ('E-LIGTAS EARTHQUAKE GUIDELINE'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);

        DB::table('guideline')->insert([
            'guideline_description' => ('E-LIGTAS FLOODING GUIDELINE'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);

        DB::table('guideline')->insert([
            'guideline_description' => ('E-LIGTAS KILL ACCIDENT GUIDELINE'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }
}
