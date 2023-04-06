<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evacuation_center', function (Blueprint $table) {
            $table->id('evacuation_id')->unsigned();
            $table->string('evacuation_name')->nullable();
            $table->string('evacuation_contact')->nullable();
            $table->string('evacuation_location')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evacuation_center');
    }
};
