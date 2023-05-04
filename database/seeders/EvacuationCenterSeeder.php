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
            'evacuation_center_name' => ('Banay-Banay Elementary School'),
            'evacuation_center_contact' => ('09124321233'),
            'evacuation_center_address' => ('Banay-Banay'),
            'barangay_id' => ('1'),
            'latitude' => ('14.123456'),
            'longitude' => ('121.123456'),
        ]);

        DB::table('evacuation_center')->insert([
            'evacuation_center_name' => ('Butong Elementary School'),
            'evacuation_center_contact' => ('09124321233'),
            'evacuation_center_address' => ('Butong'),
            'barangay_id' => ('3'),
            'latitude' => ('43.324322'),
            'longitude' => ('-1.123456'),
        ]);

        DB::table('evacuation_center')->insert([
            'evacuation_center_name' => ('Gulod Elementary School'),
            'evacuation_center_contact' => ('09124321233'),
            'evacuation_center_address' => ('Gulod'),
            'barangay_id' => ('4'),
            'latitude' => ('12.123456'),
            'longitude' => ('8.123456'),
        ]);
    }
}
