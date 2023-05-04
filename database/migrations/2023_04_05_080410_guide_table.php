<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guide', function (Blueprint $table) {
            $table->id("guide_id");
            $table->string("guide_description");
            $table->longText("guide_content");
            $table->foreignId('guideline_id')->references('guideline_id')->on('guideline')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guide');
    }
};
