<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FlashFloodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('flashflood')->insert([
            'location' => 'Rose St., Brgy. 1',
            'disaster_id' => 2,
            'status' => 'Rising',
            'longitude' => 123.123,
            'latitude' => 123.123,
        ]);
    }
}
