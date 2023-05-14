<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_activity_log', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('user_role')->nullable();
            $table->string('role_name')->nullable();
            $table->string('activity')->nullable();
            $table->string('date_time')->nullable();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('user_activity_log');
    }
};
