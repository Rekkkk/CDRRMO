<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('earthquake', function (Blueprint $table) {
            $table->id("earthquake_id");
            $table->string("magnitude");
            $table->foreignId('disaster_id')->references('disaster_id')->on('disaster')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('earthquake');
    }
};
