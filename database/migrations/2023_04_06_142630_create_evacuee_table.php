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
            $table->unsignedBigInteger('barangay_id');
            $table->foreign('barangay_id')->references('barangay_id')->on('barangay')->onDelete('cascade');
            $table->unsignedBigInteger('disaster_id');
            $table->foreign('disaster_id')->references('disaster_id')->on('disaster')->onDelete('cascade');
            $table->unsignedBigInteger('evacuation_assigned');
            $table->foreign('evacuation_assigned')->references('evacuation_center_id')->on('evacuation_center')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evacuee');
    }


};
