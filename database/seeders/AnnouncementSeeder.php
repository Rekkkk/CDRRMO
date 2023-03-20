<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin_announcement')->insert([
            'announcement_description' => ("TESTING PHASE"),
            'announcement_content' => ("TESTING PHASE FOR POSTING SESSION IN CABUYAO CITY RISK REDUCTION MANAGEMENT OFFICE USING E-LIGTAS WEBSITE."),
            'announcement_video' => null,
            'announcement_image' => null,
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }
}
