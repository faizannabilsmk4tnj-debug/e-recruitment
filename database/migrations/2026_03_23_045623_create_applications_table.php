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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('job_id')->constrained('job_postings');
            $table->foreignId('cv_id')->constrained('applicant_cvs');
            $table->text('cover_letter')->nullable();
            $table->string('resume_url', 500)->nullable();
            $table->enum('status', ['applied', 'reviewed', 'shortlisted', 'interview', 'offered', 'rejected', 'withdrawn'])->default('applied');
            $table->text('hr_notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'job_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
