<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        
        DB::table('users')
            ->where('role', 'community')
            ->update(['role' => 'community_user']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('community_user')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('community')->change();
        });
    }
};