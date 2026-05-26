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
        Schema::create('interview_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('interviews')->onDelete('cascade');
            $table->foreignId('reviewed_by')->constrained('users');
            $table->unsignedTinyInteger('score');
            $table->text('feedback')->nullable();
            $table->enum('recommendation', ['proceed', 'hold', 'reject']);
            $table->timestamp('created_at')->useCurrent();

            $table->unique('interview_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_results');
    }
};
