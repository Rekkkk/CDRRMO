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
            'email' => ('CDRRMO123@gmail.com'),
            'password' => Hash::make('CDRRMO_Admin_Panel'),
            'organization' => 'CDRRMO',
            'position' => 'President',
            'status' => 'Active'
        ]);

        User::insert([
            'email' => ('CSWD123@gmail.com'),
            'password' => Hash::make('CSWD123'),
            'organization' => 'CSWD',
            'position' => 'Secretary',
            'status' => 'Active'
        ]);

        User::insert([
            'email' => ('CSWD132@gmail.com'),
            'password' => Hash::make('CSWD1212'),
            'organization' => 'CSWD',
            'position' => 'President',
            'status' => 'Active'
        ]);

        $this->call(DisasterSeeder::class);
        $this->call(GuidelineSeeder::class);
        $this->call(GuideSeeder::class);
        $this->call(EvacuationCenterSeeder::class);
        $this->call(TyphoonSeeder::class);
        $this->call(FlashFloodSeeder::class);
    }
}
