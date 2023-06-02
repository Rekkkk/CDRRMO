<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('report', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('location');
            $table->string('photo')->nullable();
            $table->string('status')->default('On Process');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report');
    }
};
