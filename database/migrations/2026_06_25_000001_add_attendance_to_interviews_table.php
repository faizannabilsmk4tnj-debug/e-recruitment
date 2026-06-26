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
        Schema::table('interviews', function (Blueprint $table) {
            $table->enum('attendance_status', ['pending', 'present', 'absent'])->default('pending')->after('notes');
            $table->dateTime('attendance_confirmed_at')->nullable()->after('attendance_status');
            $table->string('attendance_photo', 500)->nullable()->after('attendance_confirmed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn(['attendance_status', 'attendance_confirmed_at', 'attendance_photo']);
        });
    }
};
