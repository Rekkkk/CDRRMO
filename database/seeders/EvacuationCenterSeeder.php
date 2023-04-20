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
            'evacuation_center_name' => ('Evacuation Center 1'),
            'evacuation_center_contact' => ('12345678910'),
            'evacuation_center_location' => ('Mamatid'),
        ]);

        DB::table('evacuation_center')->insert([
            'evacuation_center_name' => ('Evacuation Center 2'),
            'evacuation_center_contact' => ('12345678910'),
            'evacuation_center_location' => ('Banay Banay'),
        ]);

        DB::table('evacuation_center')->insert([
            'evacuation_center_name' => ('Evacuation Center 3'),
            'evacuation_center_contact' => ('12345678910'),
            'evacuation_center_location' => ('Cabuyao Bayan'),
        ]);
    }
}
