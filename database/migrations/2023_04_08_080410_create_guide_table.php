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
            $table->string("guide_description")->nullable();
            $table->longText("guide_content")->nullable();
            $table->unsignedBigInteger("guideline_id")->nullable();
            $table->foreign('guideline_id')->references('guideline_id')->on('guideline')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guide');
    }
};
