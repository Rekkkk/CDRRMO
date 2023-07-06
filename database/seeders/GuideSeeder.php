<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        Guide::insert([
            'label' => ('testing phase'),
            'content' => ('Testing phase guidelines section in cabuyao city disaster risk reduction management office using e-ligtas system'),
            'guideline_id' => 1
        ]);
    }
}
