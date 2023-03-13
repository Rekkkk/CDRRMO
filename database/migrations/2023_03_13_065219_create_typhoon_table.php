<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('typhoon', function (Blueprint $table) {
            $table->id('typhoon_id');
            $table->integer('age_range');
            $table->integer('male');
            $table->integer('female');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typhoon');
    }
};
