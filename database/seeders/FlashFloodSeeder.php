<?php

namespace Database\Seeders;

use App\Models\Flashflood;
use Illuminate\Database\Seeder;

class FlashFloodSeeder extends Seeder
{
    public function run(): void
    {
        Flashflood::insert([
            'location' => 'Rose St., Brgy. 1',
            'disaster_id' => 2,
            'status' => 'Rising',
            'longitude' => 123.123,
            'latitude' => 123.123
        ]);
    }
}
