<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_announcement', function (Blueprint $table) {
            $table->id('announcement_id');
            $table->string('announcement_description')->nullable();
            $table->string('announcement_content')->nullable();
            $table->binary('announcement_video')->nullable();
            $table->binary('announcement_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_announcement');
    }
};
