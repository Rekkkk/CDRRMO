<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evacuee', function (Blueprint $table) {
            $table->id();
            $table->integer('house_hold_number');
            $table->string('full_name');
            $table->string('sex');
            $table->integer('age');
            $table->boolean('4Ps');
            $table->boolean('PWD');
            $table->boolean('pregnant');
            $table->boolean('lactating');
            $table->boolean('student');
            $table->boolean('working');
            $table->string('barangay');
            $table->string('date_entry');
            $table->string('date_out')->nullable();
            $table->string('disaster_type');
            $table->integer('disaster_id');
            $table->string('disaster_info');
            $table->string('evacuation_assigned');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evacuee');
    }
};
