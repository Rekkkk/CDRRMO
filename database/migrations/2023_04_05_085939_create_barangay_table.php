<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangay', function (Blueprint $table) {
            $table->id("barangay_id")->unsigned();
            $table->string("barangay_name")->nullable();
            $table->string("barangay_location")->nullable();
            $table->string("barangay_contact_number")->nullable();
            $table->string("barangay_email_address")->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangay');
    }
};
