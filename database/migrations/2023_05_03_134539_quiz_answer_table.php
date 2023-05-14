<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_answer', function (Blueprint $table) {
            $table->id('quiz_answer_id');
            $table->foreignId('quiz_answer')->unique();
            $table->foreignId('quiz_question_id')->references('quiz_question_id')->on('quiz_question')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_answer');
    }
};
