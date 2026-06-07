<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('user_profiles', 'nik')) {
                $table->string('nik', 16)->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('user_profiles', 'birth_place')) {
                $table->string('birth_place', 100)->nullable()->after('province');
            }

            if (! Schema::hasColumn('user_profiles', 'marital_status')) {
                $table->enum('marital_status', ['single', 'married', 'divorced'])->nullable()->after('gender');
            }

            if (! Schema::hasColumn('user_profiles', 'latest_education')) {
                $table->enum('latest_education', ['sma', 'd3', 's1', 's2', 's3'])->nullable()->after('marital_status');
            }

            if (! Schema::hasColumn('user_profiles', 'school_name')) {
                $table->string('school_name', 150)->nullable()->after('latest_education');
            }

            if (! Schema::hasColumn('user_profiles', 'education_completed_at')) {
                $table->string('education_completed_at', 7)->nullable()->after('school_name');
            }

            if (! Schema::hasColumn('user_profiles', 'gpa')) {
                $table->string('gpa', 20)->nullable()->after('education_completed_at');
            }

            if (! Schema::hasColumn('user_profiles', 'ktp_province')) {
                $table->string('ktp_province', 100)->nullable()->after('gpa');
                $table->string('ktp_city', 100)->nullable()->after('ktp_province');
                $table->string('ktp_district', 100)->nullable()->after('ktp_city');
                $table->string('ktp_subdistrict', 100)->nullable()->after('ktp_district');
                $table->string('ktp_address', 255)->nullable()->after('ktp_subdistrict');
            }

            if (! Schema::hasColumn('user_profiles', 'dom_province')) {
                $table->string('dom_province', 100)->nullable()->after('ktp_address');
                $table->string('dom_city', 100)->nullable()->after('dom_province');
                $table->string('dom_district', 100)->nullable()->after('dom_city');
                $table->string('dom_subdistrict', 100)->nullable()->after('dom_district');
                $table->string('dom_address', 255)->nullable()->after('dom_subdistrict');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            foreach ([
                'nik',
                'birth_place',
                'marital_status',
                'latest_education',
                'school_name',
                'education_completed_at',
                'gpa',
                'ktp_province',
                'ktp_city',
                'ktp_district',
                'ktp_subdistrict',
                'ktp_address',
                'dom_province',
                'dom_city',
                'dom_district',
                'dom_subdistrict',
                'dom_address',
            ] as $column) {
                if (Schema::hasColumn('user_profiles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
