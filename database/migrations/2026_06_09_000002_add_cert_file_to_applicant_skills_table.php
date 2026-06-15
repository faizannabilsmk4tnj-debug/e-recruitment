<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applicant_skills', function (Blueprint $table) {
            // Rename cert_url → cert_file_path (tetap kolom string, kini simpan path file bukan URL)
            $table->renameColumn('cert_url', 'cert_file_path');
            $table->unsignedBigInteger('cert_file_size')->nullable()->after('cert_file_path');
        });
    }

    public function down(): void
    {
        Schema::table('applicant_skills', function (Blueprint $table) {
            $table->dropColumn('cert_file_size');
            $table->renameColumn('cert_file_path', 'cert_url');
        });
    }
};
