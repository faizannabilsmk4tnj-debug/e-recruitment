<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('educations', function (Blueprint $table) {
            if (! Schema::hasColumn('educations', 'certificate_number')) {
                $table->string('certificate_number', 100)->nullable()->after('major');
            }

            if (! Schema::hasColumn('educations', 'diploma_file')) {
                $table->string('diploma_file', 500)->nullable()->after('end_year');
            }

            if (! Schema::hasColumn('educations', 'skhu_file')) {
                $table->string('skhu_file', 500)->nullable()->after('diploma_file');
            }

            if (! Schema::hasColumn('educations', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('educations', function (Blueprint $table) {
            foreach (['certificate_number', 'diploma_file', 'skhu_file', 'updated_at'] as $column) {
                if (Schema::hasColumn('educations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
