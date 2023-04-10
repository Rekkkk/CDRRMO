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
            $table->unsignedBigInteger("guidelines_id")->nullable();
            $table->foreign('guidelines_id')->references('guidelines_id')->on('guidelines')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guide');
    }
};
