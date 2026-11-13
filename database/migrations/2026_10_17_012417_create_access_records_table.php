<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('access_request_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('record_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_records');
    }
};