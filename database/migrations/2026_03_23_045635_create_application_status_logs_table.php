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
        Schema::create('application_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('changed_by')->constrained('users');
            $table->enum('old_status', ['applied', 'reviewed', 'shortlisted', 'interview', 'offered', 'rejected', 'withdrawn']);
            $table->enum('new_status', ['applied', 'reviewed', 'shortlisted', 'interview', 'offered', 'rejected', 'withdrawn']);
            $table->text('reason')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_status_logs');
    }
};
