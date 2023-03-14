<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('earthquake', function (Blueprint $table) {
            $table->id('earthquake_id');
            $table->double('magnitude');
            $table->date('month');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('earthquake');
    }
};
