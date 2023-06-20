<?php

namespace Database\Seeders;

use App\Models\EvacuationCenter;
use Illuminate\Database\Seeder;

class EvacuationCenterSeeder extends Seeder
{
    public function run(): void
    {

        EvacuationCenter::insert([
            'name' => 'Butong Elementary School',
            'barangay_name' => 'Butong',
            'latitude' => '123.1233',
            'longitude' => '123.1233',
            'status' => 'Active'
        ]);

        EvacuationCenter::insert([
            'name' => 'Banay-Banay Elementary School',
            'barangay_name' => 'Banay-Banay',
            'latitude' => '123.1233',
            'longitude' => '123.1233',
            'status' => 'Active'
        ]);

        EvacuationCenter::insert([
            'name' => 'Marinig Elementary School',
            'barangay_name' => 'Marinig',
            'latitude' => '123.1233',
            'longitude' => '123.1233',
            'status' => 'Active'
        ]);
    }
}
