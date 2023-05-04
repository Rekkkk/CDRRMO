<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class TyphoonSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('typhoon')->insert([
            'typhoon_name' => ('Typhoon Rolly'),
            'disaster_id' => ('1'),
            'created_at' => Date::now(),
        ]);

        DB::table('typhoon')->insert([
            'typhoon_name' => ('Typhoon Ulysses'),
            'disaster_id' => ('1'),
            'created_at' => Date::now(),
        ]);

        DB::table('typhoon')->insert([
            'typhoon_name' => ('Typhoon Quinta'),
            'disaster_id' => ('1'),
            'created_at' => Date::now(),
        ]);
    }
}
