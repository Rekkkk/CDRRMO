<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class FloodingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('flooding')->insert([
            'flooded_location' => ('Banay-Banay Elementary School'),
            'disaster_id' => 4,
            'created_at' => Date::now(),
        ]);
    }
}
