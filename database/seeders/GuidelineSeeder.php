<?php

namespace Database\Seeders;

use App\Models\Guideline;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuidelineSeeder extends Seeder
{
    public function run(): void
    {
        Guideline::insert([
            'type' => ('TYPHOON GUIDELINE'),
        ]);

        Guideline::insert([
            'type' => ('ROAD ACCIDENT GUIDELINE'),
        ]);

        Guideline::insert([
            'type' => ('EARTHQUAKE GUIDELINE'),
        ]);

        Guideline::insert([
            'type' => ('FLASHFLOOD GUIDELINE'),
        ]);
    }
}
