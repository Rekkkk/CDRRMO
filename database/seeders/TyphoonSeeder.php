<?php

namespace Database\Seeders;

use App\Models\Typhoon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TyphoonSeeder extends Seeder
{
    public function run(): void
    {

        Typhoon::insert([
            'name' => ('Typhoon Rolly'),
            'disaster_id' => 1,
        ]);

        Typhoon::insert([
            'name' => ('Typhoon Ulysses'),
            'disaster_id' => 1
        ]);

        Typhoon::insert([
            'name' => ('Typhoon Quinta'),
            'disaster_id' => 1,
        ]);
    }
}
