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
            $table->string('name');
            $table->string('sex');
            $table->integer('age');
            $table->boolean('4Ps');
            $table->boolean('PWD');
            $table->boolean('pregnant');
            $table->boolean('lactating');
            $table->boolean('student');
            $table->boolean('working');
            $table->string('barangay');
            $table->string('date_entry')->nullable();
            $table->string('date_out')->nullable();
            $table->foreignId('disaster_id')->references('id')->on('disaster')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('evacuation_assigned')->references('id')->on('evacuation_center')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evacuee');
    }
};
