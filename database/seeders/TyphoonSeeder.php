<?php

namespace Database\Seeders;

use App\Models\Typhoon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TyphoonSeeder extends Seeder
{
    public function run(): void
    {

        Typhoon::create([
            'name' => ('Typhoon Rolly'),
            'disaster_id' => ('1'),
        ]);

        Typhoon::create([
            'name' => ('Typhoon Ulysses'),
            'disaster_id' => ('1'),
        ]);

        Typhoon::create([
            'name' => ('Typhoon Quinta'),
            'disaster_id' => ('1'),
        ]);
    }
}
