<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangay', function (Blueprint $table) {
            $table->id("barangay_id");
            $table->string("barangay_name");
            $table->string("barangay_location");
            $table->string("barangay_contact_number");
            $table->string("barangay_email_address");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangay');
    }
};
