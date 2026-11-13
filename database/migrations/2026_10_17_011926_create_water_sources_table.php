<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('water_sources', function (Blueprint $table) {
            $table->id();
            $table->string('source_id')->unique()->nullable();
            $table->string('source_name');
            $table->string('location');
            $table->string('capacity');
            $table->string('status')->default('Active'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('water_sources');
    }
};