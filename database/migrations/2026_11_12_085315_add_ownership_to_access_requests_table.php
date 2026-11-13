
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('access_requests', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('water_source_id')
                ->nullable()
                ->constrained('water_sources')
                ->restrictOnDelete();

            $table->unique('request_code');
        });
    }

    public function down(): void
    {
        Schema::table('access_requests', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropForeign(['water_source_id']);

            $table->dropUnique(['request_code']);

            $table->dropColumn([
                'user_id',
                'water_source_id',
            ]);
        });
    }
};
