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
            'location' => 'Banay-Banay Elementary School',
            'disaster_id' => 4,
        ]);
    }
}
