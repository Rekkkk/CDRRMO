<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('typhoon', function (Blueprint $table) {
            $table->id('typhoon_id');
            $table->string('age_range');
            $table->integer('male');
            $table->integer('female');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('typhoon');
    }
};
