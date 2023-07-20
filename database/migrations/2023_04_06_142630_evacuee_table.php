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
            $table->string('sex');
            $table->string('age');
            $table->boolean('PWD');
            $table->boolean('pregnant');
            $table->boolean('lactating');
            $table->string('barangay');
            $table->string('date_entry');
            $table->string('disaster_name');
            $table->integer('disaster_id');
            $table->string('evacuation_assigned');
            $table->string('remarks')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evacuee');
    }
};
