<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::transaction(function () {
            DB::table('job_postings')
                ->where('status', 'expired')
                ->update(['status' => 'closed']);

            DB::statement("ALTER TABLE job_postings MODIFY COLUMN status ENUM('draft', 'open', 'closed', 'filled') NOT NULL DEFAULT 'draft'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE job_postings MODIFY COLUMN status ENUM('draft', 'open', 'closed', 'expired', 'filled') NOT NULL DEFAULT 'draft'");
    }
};
