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

        // 1. Trigger for applications before insert (Concurrent Application Limit & Age Limit constraints)
        DB::unprepared("
            DROP TRIGGER IF EXISTS before_application_insert;
        ");
        
        DB::unprepared("
            CREATE TRIGGER before_application_insert
            BEFORE INSERT ON applications
            FOR EACH ROW
            BEGIN
                DECLARE v_active_count INT;
                DECLARE v_age_min INT;
                DECLARE v_age_max INT;
                DECLARE v_birth_date DATE;
                DECLARE v_age INT;

                -- Constraint 1: Check maximum 3 active applications
                SELECT COUNT(*) INTO v_active_count
                FROM applications
                WHERE user_id = NEW.user_id AND status IN ('applied', 'shortlisted', 'interview');

                IF v_active_count >= 3 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Batas maksimal lamaran aktif tercapai (Maksimal 3 lamaran aktif secara bersamaan).';
                END IF;

                -- Constraint 2: Check Age Limit
                SELECT age_min, age_max INTO v_age_min, v_age_max
                FROM job_postings
                WHERE id = NEW.job_id;

                IF v_age_min IS NOT NULL OR v_age_max IS NOT NULL THEN
                    SELECT birth_date INTO v_birth_date
                    FROM user_profiles
                    WHERE user_id = NEW.user_id;

                    IF v_birth_date IS NULL THEN
                        SIGNAL SQLSTATE '45000'
                        SET MESSAGE_TEXT = 'Lowongan ini memiliki syarat batas usia. Mohon lengkapi Tanggal Lahir di profil Anda.';
                    ELSE
                        SET v_age = TIMESTAMPDIFF(YEAR, v_birth_date, CURDATE());
                        IF v_age_min IS NOT NULL AND v_age < v_age_min THEN
                            SIGNAL SQLSTATE '45000'
                            SET MESSAGE_TEXT = 'Usia Anda kurang dari syarat minimum lowongan ini.';
                        END IF;
                        IF v_age_max IS NOT NULL AND v_age > v_age_max THEN
                            SIGNAL SQLSTATE '45000'
                            SET MESSAGE_TEXT = 'Usia Anda melebihi batas maksimum syarat lowongan ini.';
                        END IF;
                    END IF;
                END IF;
            END;
        ");

        // 2. Trigger for interview results (Passing Grade check on Insert)
        DB::unprepared("
            DROP TRIGGER IF EXISTS before_interview_result_insert;
        ");
        DB::unprepared("
            CREATE TRIGGER before_interview_result_insert
            BEFORE INSERT ON interview_results
            FOR EACH ROW
            BEGIN
                DECLARE v_passing_grade INT;
                DECLARE v_job_id INT;

                -- Find the job_id from interview -> application
                SELECT a.job_id INTO v_job_id
                FROM interviews i
                JOIN applications a ON i.application_id = a.id
                WHERE i.id = NEW.interview_id;

                -- Find passing grade for the job
                SELECT passing_grade INTO v_passing_grade
                FROM job_postings
                WHERE id = v_job_id;

                IF NEW.recommendation = 'proceed' AND NEW.score < v_passing_grade THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Rekomendasi PROCEED tidak diperbolehkan karena skor kurang dari passing grade.';
                END IF;
            END;
        ");

        // 3. Trigger for interview results (Passing Grade check on Update)
        DB::unprepared("
            DROP TRIGGER IF EXISTS before_interview_result_update;
        ");
        DB::unprepared("
            CREATE TRIGGER before_interview_result_update
            BEFORE UPDATE ON interview_results
            FOR EACH ROW
            BEGIN
                DECLARE v_passing_grade INT;
                DECLARE v_job_id INT;

                -- Find the job_id from interview -> application
                SELECT a.job_id INTO v_job_id
                FROM interviews i
                JOIN applications a ON i.application_id = a.id
                WHERE i.id = NEW.interview_id;

                -- Find passing grade for the job
                SELECT passing_grade INTO v_passing_grade
                FROM job_postings
                WHERE id = v_job_id;

                IF NEW.recommendation = 'proceed' AND NEW.score < v_passing_grade THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Rekomendasi PROCEED tidak diperbolehkan karena skor kurang dari passing grade.';
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

        DB::unprepared("DROP TRIGGER IF EXISTS before_application_insert;");
        DB::unprepared("DROP TRIGGER IF EXISTS before_interview_result_insert;");
        DB::unprepared("DROP TRIGGER IF EXISTS before_interview_result_update;");
    }
};
