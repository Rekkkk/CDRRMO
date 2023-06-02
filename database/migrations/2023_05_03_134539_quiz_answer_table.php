<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('answer', function (Blueprint $table) {
            $table->id();
            $table->string('wrong1')->unique();
            $table->string('wrong2')->unique();
            $table->string('wrong3')->unique();
            $table->string('correct')->unique();
            $table->foreignId('question_id')->references('id')->on('question')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answer');
    }
};
