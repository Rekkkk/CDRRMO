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
        $this->call(GuidelinesSeeder::class);
        $this->call(BaranggaySeeder::class);
        $this->call(EvacuationCenterSeeder::class);
        $this->call(GuideSeeder::class);

        DB::table('users')->insert([
            'admin_email' => ('CDRRMO123@gmail.com'),
            'password' => Hash::make('CDRRMO_Admin_Panel'),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }
}
