<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaranggaySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('baranggay')->insert([
            'baranggay_name' => ('Banay Banay'),
            'baranggay_location' => ('Cabuyao Laguna City 4025'),
            'baranggay_contact_number' => ('12345678910'),
            'baranggay_email_address' => ('banaybanay@gmail.com'),
        ]);

        DB::table('baranggay')->insert([
            'baranggay_name' => ('Niugan'),
            'baranggay_location' => ('Cabuyao Laguna City 4025'),
            'baranggay_contact_number' => ('12345678910'),
            'baranggay_email_address' => ('niugan@gmail.com'),
        ]);

        DB::table('baranggay')->insert([
            'baranggay_name' => ('Butong'),
            'baranggay_location' => ('Cabuyao Laguna City 4025'),
            'baranggay_contact_number' => ('12345678910'),
            'baranggay_email_address' => ('butong@gmail.com'),
        ]);

        DB::table('baranggay')->insert([
            'baranggay_name' => ('Gulod'),
            'baranggay_location' => ('Cabuyao Laguna City 4025'),
            'baranggay_contact_number' => ('12345678910'),
            'baranggay_email_address' => ('gulod@gmail.com'),
        ]);

        DB::table('baranggay')->insert([
            'baranggay_name' => ('Celestine'),
            'baranggay_location' => ('Cabuyao Laguna City 4025'),
            'baranggay_contact_number' => ('12345678910'),
            'baranggay_email_address' => ('celestine@gmail.com'),
        ]);
    }
}
