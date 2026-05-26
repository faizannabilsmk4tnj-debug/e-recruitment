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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hr_user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('job_categories');
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->text('description');
            $table->text('requirements');
            $table->text('benefits')->nullable();
            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'internship']);
            $table->enum('location_type', ['onsite', 'remote', 'hybrid']);
            $table->string('location', 200)->nullable();
            $table->decimal('salary_min', 12, 2)->nullable();
            $table->decimal('salary_max', 12, 2)->nullable();
            $table->boolean('show_salary')->default(false);
            $table->unsignedInteger('quota')->default(1);
            $table->unsignedInteger('applicant_count')->default(0);
            $table->enum('status', ['draft', 'open', 'closed', 'expired'])->default('draft');
            $table->date('deadline')->nullable();
            $table->timestamps();
            $table->timestamp('closed_at')->nullable();
        });

        // Full-text index untuk pencarian
        DB::statement('ALTER TABLE job_postings ADD FULLTEXT KEY ft_job_search (title, description, requirements, benefits)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
