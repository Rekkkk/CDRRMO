<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangaySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barangay')->insert([
            'barangay_name' => ('Banay Banay'),
            'barangay_location' => ('Cabuyao Laguna City 4025'),
            'barangay_contact_number' => ('12345678910'),
            'barangay_email_address' => ('banaybanay@gmail.com'),
        ]);

        DB::table('barangay')->insert([
            'barangay_name' => ('Niugan'),
            'barangay_location' => ('Cabuyao Laguna City 4025'),
            'barangay_contact_number' => ('12345678910'),
            'barangay_email_address' => ('niugan@gmail.com'),
        ]);

        DB::table('barangay')->insert([
            'barangay_name' => ('Butong'),
            'barangay_location' => ('Cabuyao Laguna City 4025'),
            'barangay_contact_number' => ('12345678910'),
            'barangay_email_address' => ('butong@gmail.com'),
        ]);

        DB::table('barangay')->insert([
            'barangay_name' => ('Gulod'),
            'barangay_location' => ('Cabuyao Laguna City 4025'),
            'barangay_contact_number' => ('12345678910'),
            'barangay_email_address' => ('gulod@gmail.com'),
        ]);

        DB::table('barangay')->insert([
            'barangay_name' => ('Celestine'),
            'barangay_location' => ('Cabuyao Laguna City 4025'),
            'barangay_contact_number' => ('12345678910'),
            'barangay_email_address' => ('celestine@gmail.com'),
        ]);
    }
}
