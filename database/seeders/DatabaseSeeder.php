<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(DisasterSeeder::class);
        $this->call(GuidelineSeeder::class);
        $this->call(EvacuationCenterSeeder::class);
        $this->call(GuideSeeder::class);
        $this->call(TyphoonSeeder::class);
        $this->call(FlashFloodSeeder::class);

        User::insert([
            'email' => ('francis123@gmail.com'),
            'password' => Hash::make('francis123'),
            'user_role' => 'Developer',
            'position' => 'Junior'
        ]);
        
        User::insert([
            'email' => ('margallo123@gmail.com'),
            'password' => Hash::make('margallo123'),
            'user_role' => 'Developer',
            'position' => 'Junior'
        ]);

        User::insert([
            'email' => ('perez123@gmail.com'),
            'password' => Hash::make('perez123'),
            'user_role' => 'Developer',
            'position' => 'Junior'
        ]);

        User::insert([
            'email' => ('CDRRMO123@gmail.com'),
            'password' => Hash::make('CDRRMO_Admin_Panel'),
            'user_role' => 'CDRRMO',
            'position' => 'Secretary'
        ]);

        User::insert([
            'email' => ('CSWD123@gmail.com'),
            'password' => Hash::make('CSWD123'),
            'user_role' => 'CSWD',
            'position' => 'Secretary'
        ]);
    }
}
