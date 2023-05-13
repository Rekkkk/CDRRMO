<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(DisasterSeeder::class);
        $this->call(GuidelineSeeder::class);
        $this->call(BarangaySeeder::class);
        $this->call(EvacuationCenterSeeder::class);
        $this->call(GuideSeeder::class);
        $this->call(EarthquakeSeeder::class);
        $this->call(TyphoonSeeder::class);
        $this->call(RoadAccidentSeeder::class);
        $this->call(FloodingSeeder::class);

        DB::table('users')->insert([
            'email' => ('CDRRMO123@gmail.com'),
            'password' => Hash::make('CDRRMO_Admin_Panel'),
            'user_role' => '1',
            'created_at' => Date::now(),
        ]);

        DB::table('users')->insert([
            'email' => ('francistengteng10@gmail.com'),
            'password' => Hash::make('tengteng10'),
            'user_role' => '0',
            'created_at' => Date::now(),
        ]);

        DB::table('users')->insert([
            'email' => ('CSWD123@gmail.com'),
            'password' => Hash::make('CSWD123'),
            'user_role' => '2',
            'created_at' => Date::now(),
        ]);
    }
}
