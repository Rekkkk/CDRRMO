<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('disaster')->insert([
            'disaster_type' => ('Typhoon'),
        ]);

        DB::table('disaster')->insert([
            'disaster_type' => ('Earthquake'),
        ]);

        DB::table('disaster')->insert([
            'disaster_type' => ('Road Accident'),
        ]);
    }
}
