<?php

namespace Database\Seeders;

use App\Models\Guideline;
use Illuminate\Database\Seeder;

class GuidelineSeeder extends Seeder
{
    public function run(): void
    {
        Guideline::insert([
            'type' => ('TYPHOON GUIDELINE'),
            'author' => 1,
        ]);

        Guideline::insert([
            'type' => ('ROAD ACCIDENT GUIDELINE'),
            'author' => 2,
        ]);

        Guideline::insert([
            'type' => ('EARTHQUAKE GUIDELINE'),
            'author' => 1,
        ]);

        Guideline::insert([
            'type' => ('FLASHFLOOD GUIDELINE'),
            'author' => 2,
        ]);
    }
}
