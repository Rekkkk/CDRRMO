<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baranggay', function (Blueprint $table) {
            $table->id("baranggay_id");
            $table->string("baranggay_label")->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baranggay');
    }
};
