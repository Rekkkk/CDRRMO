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
            'user_role' => 'CDRRMO',
            'position' => 'Secretary',
            'restricted' => 0
        ]);

        User::insert([
            'email' => ('CSWD123@gmail.com'),
            'password' => Hash::make('CSWD123'),
            'user_role' => 'CSWD',
            'position' => 'Secretary',
            'restricted' => 0
        ]);

        User::insert([
            'email' => ('CSWD132@gmail.com'),
            'password' => Hash::make('CSWD1212'),
            'user_role' => 'CSWD',
            'position' => 'President',
            'restricted' => 0
        ]);

        $this->call(DisasterSeeder::class);
        $this->call(GuidelineSeeder::class);
        $this->call(GuideSeeder::class);
        $this->call(EvacuationCenterSeeder::class);
        $this->call(TyphoonSeeder::class);
        $this->call(FlashFloodSeeder::class);
    }
}
