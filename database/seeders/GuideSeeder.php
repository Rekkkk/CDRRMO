<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('guide')->insert([
            'guide_description' => ('TESTING PHASE'),
            'guide_content' => ('TESTING PHASE GUIDELINES SECTION IN CABUYAO CITY DISASTER RISK REDUCTION MANAGEMENT OFFICE USING E-LIGTAS SYSTEM'),
            'guideline_id' => 1,
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }
}
