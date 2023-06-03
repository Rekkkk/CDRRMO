<?php

namespace Database\Seeders;

use App\Models\Disaster;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DisasterSeeder extends Seeder
{
    public function run(): void
    {

        Disaster::insert([
            'type' => ('Typhoon')
        ]);

        Disaster::insert([
            'type' => ('Flooding')
        ]);
    }
}
