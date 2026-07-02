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
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::unprepared("
            DROP TRIGGER IF EXISTS before_user_profile_insert;
        ");
        DB::unprepared("
            CREATE TRIGGER before_user_profile_insert
            BEFORE INSERT ON user_profiles
            FOR EACH ROW
            BEGIN
                IF NEW.birth_date IS NOT NULL AND TIMESTAMPDIFF(YEAR, NEW.birth_date, CURDATE()) < 17 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Database Trigger Error: Batas usia minimal pendaftaran adalah 17 tahun.';
                END IF;
            END;
        ");

        DB::unprepared("
            DROP TRIGGER IF EXISTS before_user_profile_update;
        ");
        DB::unprepared("
            CREATE TRIGGER before_user_profile_update
            BEFORE UPDATE ON user_profiles
            FOR EACH ROW
            BEGIN
                IF NEW.birth_date IS NOT NULL AND TIMESTAMPDIFF(YEAR, NEW.birth_date, CURDATE()) < 17 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Database Trigger Error: Batas usia minimal pendaftaran adalah 17 tahun.';
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::unprepared("DROP TRIGGER IF EXISTS before_user_profile_insert;");
        DB::unprepared("DROP TRIGGER IF EXISTS before_user_profile_update;");
    }
};
