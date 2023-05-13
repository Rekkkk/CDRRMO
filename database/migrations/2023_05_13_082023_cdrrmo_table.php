<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('cdrrmo', function (Blueprint $table) {
            $table->string('address');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('youtube');
            $table->string('instagram');
            $table->string('contact');
            $table->string('messenger');
            $table->string('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cdrrmo');
    }
};
