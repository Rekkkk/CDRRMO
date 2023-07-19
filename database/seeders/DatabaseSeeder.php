<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            'email' => ('d@gmail.com'),
            'password' => Hash::make('d'),
            'organization' => 'CDRRMO',
            'position' => 'President',
            'status' => 'Active',
            'isDisable' => 0,
            'isSuspend' => 0
        ]);

        User::insert([
            'email' => ('c@gmail.com'),
            'password' => Hash::make('c'),
            'organization' => 'CSWD',
            'position' => 'Focal',
            'status' => 'Active',
            'isDisable' => 0,
            'isSuspend' => 0
        ]);

        $this->call(DisasterSeeder::class);
        $this->call(GuidelineSeeder::class);
        $this->call(GuideSeeder::class);
        $this->call(EvacuationCenterSeeder::class);
        $this->call(TyphoonSeeder::class);
        $this->call(FlashFloodSeeder::class);
    }
}
