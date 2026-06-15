<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom yang dibutuhkan HrCvTemplateController ke tabel cv_templates.
     * Kolom ini tidak ada di migration awal (2026_03_23_031608) namun dibutuhkan
     * oleh CvTemplate model dan HrCvTemplateController untuk fitur HR CV Template Management.
     */
    public function up(): void
    {
        Schema::table('cv_templates', function (Blueprint $table) {
            // Deskripsi singkat template (nullable)
            $table->text('description')->nullable()->after('name');

            // Konten HTML editor template (nullable, bisa sangat panjang)
            $table->longText('content_html')->nullable()->after('preview_url');

            // Status template: draft / published
            $table->enum('status', ['draft', 'published'])->default('draft')->after('content_html');

            // Apakah ini template default yang dipilihkan untuk pelamar baru
            $table->boolean('is_default')->default(false)->after('is_active');

            // Tambahkan updated_at (sebelumnya tabel hanya punya created_at tanpa updated_at)
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cv_templates', function (Blueprint $table) {
            $table->dropColumn(['description', 'content_html', 'status', 'is_default', 'updated_at']);
        });
    }
};
