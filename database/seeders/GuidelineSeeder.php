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
            'organization' => 'CSWD',
            'is_archive' => 0
        ]);

        Guideline::insert([
            'type' => ('ROAD ACCIDENT GUIDELINE'),
            'organization' => 'CDRRMO',
            'is_archive' => 0
        ]);

        Guideline::insert([
            'type' => ('EARTHQUAKE GUIDELINE'),
            'organization' => 'CSWD',
            'is_archive' => 0
        ]);

        Guideline::insert([
            'type' => ('FLASHFLOOD guideliGUIDELINEne'),
            'organization' => 'CDRRMO',
            'is_archive' => 0
        ]);
    }
}
