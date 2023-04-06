<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evacuee', function (Blueprint $table) {
            $table->id('evacuee_id')->unsigned();
            $table->string('evacuee_first_name')->nullable();
            $table->string('evacuee_middle_name')->nullable();
            $table->string('evacuee_last_name')->nullable();
            $table->string('evacuee_contact_number')->nullable();
            $table->integer('evacuee_age')->nullable();
            $table->string('evacuee_gender')->nullable();
            $table->string('evacuee_address')->nullable();
            $table->unsignedBigInteger('baranggay_id')->nullable();
            $table->foreign('baranggay_id')->references('baranggay_id')->on('baranggay')->nullable();
            $table->unsignedBigInteger('disaster_id')->nullable();
            $table->foreign('disaster_id')->references('disaster_id')->on('disaster')->nullable();
            $table->unsignedBigInteger('evacuation_assigned')->nullable();
            $table->foreign('evacuation_assigned')->references('evacuation_id')->on('evacuation_center')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evacuee');
    }
};
