<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvacuationCenterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('evacuation_center')->insert([
            'evacuation_name' => ('Evacuation 1'),
            'evacuation_contact' => ('12345678910'),
            'evacuation_location' => ('Mamatid'),
        ]);

        DB::table('evacuation_center')->insert([
            'evacuation_name' => ('Evacuation 2'),
            'evacuation_contact' => ('12345678910'),
            'evacuation_location' => ('Banay Banay'),
        ]);

        DB::table('evacuation_center')->insert([
            'evacuation_name' => ('Evacuation 3'),
            'evacuation_contact' => ('12345678910'),
            'evacuation_location' => ('Cabuyao Bayan'),
        ]);
    }
}
