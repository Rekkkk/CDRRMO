<?php

namespace Database\Seeders;

use App\Models\Disaster;
use Illuminate\Database\Seeder;

class DisasterSeeder extends Seeder
{
    public function run(): void
    {

        Disaster::insert([
            'name' => ('Typhoon Paeng'),
            'location' => null,
            'status' => "On Going",
            'is_archive' => 0
        ]);

        Disaster::insert([
            'name' => ('Typhoon Ondoy'),
            'location' => null,
            'status' => "On Going",
            'is_archive' => 0
        ]);
    }
}
