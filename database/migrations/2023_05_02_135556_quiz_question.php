<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_question', function (Blueprint $table) {
            $table->id('quiz_question_id');
            $table->string('quiz_question')->unique();
            $table->integer('quiz_question_answer')->unique();
            $table->foreignId('quiz_id')->references('quiz_id')->on('quiz')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_question');
    }
};
