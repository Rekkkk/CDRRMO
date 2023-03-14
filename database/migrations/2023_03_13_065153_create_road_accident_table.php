<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roadaccindent', function (Blueprint $table) {
            $table->id('accident_id');
            $table->string('location');
            $table->integer('casualties');
            $table->integer('injured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roadaccindent');
    }
};
