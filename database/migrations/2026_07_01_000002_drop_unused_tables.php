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
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('login_attempts');
        Schema::dropIfExists('job_search_logs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate certificates table
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title', 200);
            $table->string('file_path', 500);
            $table->string('file_name', 200);
            $table->string('file_ext', 10);
            $table->bigInteger('file_size')->unsigned();
            $table->timestamps();
        });

        // Recreate login_attempts table
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('email', 150);
            $table->string('ip_address', 45)->nullable();
            $table->boolean('is_success')->default(false);
            $table->timestamp('attempted_at')->useCurrent();
        });

        // Recreate job_search_logs table
        Schema::create('job_search_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('keyword', 255);
            $table->unsignedInteger('results_count')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }
};
