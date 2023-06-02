<?php

namespace Database\Seeders;

use App\Models\Guideline;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuidelineSeeder extends Seeder
{
    public function run(): void
    {
        Guideline::create([
            'type' => ('TYPHOON GUIDELINE'),
        ]);

        Guideline::create([
            'type' => ('ROAD ACCIDENT GUIDELINE'),
        ]);

        Guideline::create([
            'type' => ('EARTHQUAKE GUIDELINE'),
        ]);

        Guideline::create([
            'type' => ('FLASHFLOOD GUIDELINE'),
        ]);
    }
}
