<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            if (!Schema::hasColumn('interviews', 'reschedule_reason')) {
                $table->string('reschedule_reason', 1000)->nullable()->after('notes');
            }
            if (!Schema::hasColumn('interviews', 'reschedule_proposed_at')) {
                $table->dateTime('reschedule_proposed_at')->nullable()->after('reschedule_reason');
            }
            if (!Schema::hasColumn('interviews', 'reschedule_request_status')) {
                $table->enum('reschedule_request_status', ['pending', 'approved', 'declined'])->nullable()->after('reschedule_proposed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn(['reschedule_reason', 'reschedule_proposed_at', 'reschedule_request_status']);
        });
    }
};
