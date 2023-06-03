<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        Guide::insert([
            'label' => ('TESTING PHASE'),
            'content' => ('TESTING PHASE GUIDELINES SECTION IN CABUYAO CITY DISASTER RISK REDUCTION MANAGEMENT OFFICE USING E-LIGTAS SYSTEM'),
            'guideline_id' => 1,
        ]);
    }
}
