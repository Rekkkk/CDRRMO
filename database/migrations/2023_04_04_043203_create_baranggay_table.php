<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baranggay', function (Blueprint $table) {
            $table->id("baranggay_id")->unsigned();
            $table->string("baranggay_name")->nullable();
            $table->string("baranggay_location")->nullable();
            $table->string("baranggay_contact_number")->nullable();
            $table->string("baranggay_email_address")->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baranggay');
    }
};
