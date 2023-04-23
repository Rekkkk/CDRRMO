<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('earthquake', function (Blueprint $table) {
            $table->id("earthquake_id");
            $table->string("magnitude");
            $table->unsignedBigInteger("disaster_id");
            $table->foreign('disaster_id')->references('disaster_id')->on('disaster')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('earthquake');
    }
};
