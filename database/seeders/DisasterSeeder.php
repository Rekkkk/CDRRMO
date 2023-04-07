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
            'disaster_name' => ('Typhoon'),
        ]);

        DB::table('disaster')->insert([
            'disaster_name' => ('Earthquake'),
        ]);

        DB::table('disaster')->insert([
            'disaster_name' => ('Road Accident'),
        ]);

        DB::table('disaster')->insert([
            'disaster_name' => ('Kill Accident'),
        ]);
    }
}
