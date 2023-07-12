<?php

namespace Database\Seeders;

use App\Models\Guideline;
use Illuminate\Database\Seeder;

class GuidelineSeeder extends Seeder
{
    public function run(): void
    {
        Guideline::insert([
            'type' => ('typhoon guideline'),
            'organization' => 'CSWD'
        ]);

        Guideline::insert([
            'type' => ('road accident guideline'),
            'organization' => 'CDRRMO'
        ]);

        Guideline::insert([
            'type' => ('earthquake guideline'),
            'organization' => 'CSWD'
        ]);

        Guideline::insert([
            'type' => ('flashflood guideline'),
            'organization' => 'CDRRMO'
        ]);
    }
}
