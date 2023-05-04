<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evacuee', function (Blueprint $table) {
            $table->id('evacuee_id');
            $table->string('evacuee_first_name');
            $table->string('evacuee_middle_name');
            $table->string('evacuee_last_name');
            $table->string('evacuee_suffix')->nullable();
            $table->string('evacuee_contact_number');
            $table->integer('evacuee_age');
            $table->string('evacuee_gender');
            $table->string('evacuee_address');
            $table->foreignId('barangay_id')->references('barangay_id')->on('barangay')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('disaster_id')->references('disaster_id')->on('disaster')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('evacuation_assigned')->references('evacuation_center_id')->on('evacuation_center')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evacuee');
    }


};
