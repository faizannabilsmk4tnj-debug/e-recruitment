<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel untuk menyimpan preferensi notifikasi per user HR.
     */
    public function up(): void
    {
        Schema::create('user_notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('notif_new_applicant')->default(true);
            $table->boolean('notif_interview_schedule')->default(true);
            $table->boolean('notif_vacancy_capacity')->default(true);
            $table->boolean('notif_vacancy_deadline')->default(true);
            $table->timestamps();

            $table->unique('user_id'); // satu user satu baris preferensi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notification_preferences');
    }
};
