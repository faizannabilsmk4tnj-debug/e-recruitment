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
        // sessions table is already created by a previous migration:
        // 2026_06_04_153243_create_sessions_table.php
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // sessions table is dropped by the previous migration:
        // 2026_06_04_153243_create_sessions_table.php
    }
};
