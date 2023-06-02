<?php

namespace Database\Seeders;

use App\Models\EvacuationCenter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EvacuationCenterSeeder extends Seeder
{
    public function run(): void
    {

        EvacuationCenter::create([
            'name' => 'Butong Elementary School',
            'barangay_name' => 'Butong',
            'latitude' => '123.1233',
            'longitude' => '123.1233',
            'status' => 'Active'
        ]);

        EvacuationCenter::create([
            'name' => 'Banay-Banay Elementary School',
            'barangay_name' => 'Banay-Banay',
            'latitude' => '123.1233',
            'longitude' => '123.1233',
            'status' => 'Active'
        ]);

        EvacuationCenter::create([
            'name' => 'Marinig Elementary School',
            'barangay_name' => 'Marinig',
            'latitude' => '123.1233',
            'longitude' => '123.1233',
            'status' => 'Active'
        ]);
    }
}
