<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flashflood', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('status')->default('Rising');
            $table->foreignId('disaster_id')->references('id')->on('disaster')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flashflood');
    }
};
