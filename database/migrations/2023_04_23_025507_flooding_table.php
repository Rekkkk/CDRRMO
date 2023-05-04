<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flooding', function (Blueprint $table) {
            $table->id('flooding_id');
            $table->string('flooded_location');
            $table->foreignId('disaster_id')->references('disaster_id')->on('disaster')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flooding');
    }
};
