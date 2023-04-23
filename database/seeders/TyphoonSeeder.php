<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TyphoonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('typhoon')->insert([
            'typhoon_name' => ('Typhoon Rolly'),
            'disaster_id' => ('1'),
        ]);

        DB::table('typhoon')->insert([
            'typhoon_name' => ('Typhoon Ulysses'),
            'disaster_id' => ('1'),
        ]);

        DB::table('typhoon')->insert([
            'typhoon_name' => ('Typhoon Quinta'),
            'disaster_id' => ('1'),
        ]);
    }
}
