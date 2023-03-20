<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('road_accident', function (Blueprint $table) {
            $table->id('accident_id');
            $table->string('location')->nullable();
            $table->integer('casualties')->nullable();
            $table->integer('injured')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('road_accident');
    }
};
