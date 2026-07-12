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
        // 1. Drop job_posting_views table if it exists
        Schema::dropIfExists('job_posting_views');

        // 2. Drop portfolio_url column from user_profiles table if it exists
        if (Schema::hasColumn('user_profiles', 'portfolio_url')) {
            Schema::table('user_profiles', function (Blueprint $table) {
                $table->dropColumn('portfolio_url');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate job_posting_views table
        if (!Schema::hasTable('job_posting_views')) {
            Schema::create('job_posting_views', function (Blueprint $table) {
                $table->id();
                $table->foreignId('job_posting_id')->constrained('job_postings')->onDelete('cascade');
                $table->string('source', 50)->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->timestamps();
            });
        }

        // Recreate portfolio_url column on user_profiles
        if (!Schema::hasColumn('user_profiles', 'portfolio_url')) {
            Schema::table('user_profiles', function (Blueprint $table) {
                $table->string('portfolio_url', 500)->nullable();
            });
        }
    }
};
