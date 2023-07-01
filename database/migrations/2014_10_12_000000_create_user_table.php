<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('organization');
            $table->string('position');
            $table->string('status');
            $table->boolean('isRestrict');
            $table->boolean('isSuspend');
            $table->timestamp('suspendTime')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
