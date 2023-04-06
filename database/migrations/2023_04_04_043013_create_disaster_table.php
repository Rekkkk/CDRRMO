<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('disaster', function (Blueprint $table) {
            $table->id("disaster_id")->unsigned();
            $table->string("disaster_name")->nullable();
        });
    }
   
    public function down(): void
    {
        Schema::dropIfExists('disaster');
    }
};
