
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_requests', function (Blueprint $table) {
            $table->id();

            // Unique request code
            $table->string('request_code')->unique();

            $table->string('user_name');
            $table->string('user_email');
            $table->string('requested_source');
            $table->date('preferred_date');
            $table->text('purpose');
            $table->string('estimated_volume')->nullable();

            $table->string('status')->default('Pending');
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_requests');
    }
};
