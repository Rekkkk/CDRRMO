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
            'guidelines_description' => ('TESTING PHASE'),
            'guidelines_content' => ('TESTING PHASE GUIDELINES SECTION IN CABUYAO CITY DISASTER RISK REDUCTION MANAGEMENT OFFICE USING E-LIGTAS SYSTEM'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }
}
