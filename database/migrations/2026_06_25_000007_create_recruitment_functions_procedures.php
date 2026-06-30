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

        // =============================================
        // 1. FUNCTION: fn_hitung_umur_pelamar
        //    Menghitung umur pelamar berdasarkan user_id
        // =============================================
        DB::unprepared("DROP FUNCTION IF EXISTS fn_hitung_umur_pelamar;");
        DB::unprepared("
            CREATE FUNCTION fn_hitung_umur_pelamar(p_user_id BIGINT)
            RETURNS INT
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_birth_date DATE;
                DECLARE v_age INT DEFAULT NULL;

                SELECT birth_date INTO v_birth_date
                FROM user_profiles
                WHERE user_id = p_user_id
                LIMIT 1;

                IF v_birth_date IS NOT NULL THEN
                    SET v_age = TIMESTAMPDIFF(YEAR, v_birth_date, CURDATE());
                END IF;

                RETURN v_age;
            END;
        ");

        // =============================================
        // 2. FUNCTION: fn_cek_kelayakan_melamar
        //    Mengecek apakah pelamar layak melamar:
        //    - Belum melamar lowongan yang sama
        //    - Lamaran aktif < 3
        //    - Usia dalam batas (jika ada)
        //    Return: 'ELIGIBLE', atau pesan error
        // =============================================
        DB::unprepared("DROP FUNCTION IF EXISTS fn_cek_kelayakan_melamar;");
        DB::unprepared("
            CREATE FUNCTION fn_cek_kelayakan_melamar(p_user_id BIGINT, p_job_id BIGINT)
            RETURNS VARCHAR(255)
            DETERMINISTIC
            READS SQL DATA
            BEGIN
                DECLARE v_already INT DEFAULT 0;
                DECLARE v_active_count INT DEFAULT 0;
                DECLARE v_age INT;
                DECLARE v_age_min INT;
                DECLARE v_age_max INT;

                -- Cek apakah sudah melamar lowongan yang sama
                SELECT COUNT(*) INTO v_already
                FROM applications
                WHERE user_id = p_user_id AND job_id = p_job_id;

                IF v_already > 0 THEN
                    RETURN 'SUDAH_MELAMAR';
                END IF;

                -- Cek jumlah lamaran aktif
                SELECT COUNT(*) INTO v_active_count
                FROM applications
                WHERE user_id = p_user_id AND status IN ('applied', 'shortlisted', 'interview');

                IF v_active_count >= 3 THEN
                    RETURN 'MELEBIHI_BATAS_AKTIF';
                END IF;

                -- Cek batasan umur
                SELECT age_min, age_max INTO v_age_min, v_age_max
                FROM job_postings
                WHERE id = p_job_id;

                IF v_age_min IS NOT NULL OR v_age_max IS NOT NULL THEN
                    SET v_age = fn_hitung_umur_pelamar(p_user_id);

                    IF v_age IS NULL THEN
                        RETURN 'TANGGAL_LAHIR_KOSONG';
                    END IF;

                    IF v_age_min IS NOT NULL AND v_age < v_age_min THEN
                        RETURN 'USIA_KURANG';
                    END IF;

                    IF v_age_max IS NOT NULL AND v_age > v_age_max THEN
                        RETURN 'USIA_MELEBIHI';
                    END IF;
                END IF;

                RETURN 'ELIGIBLE';
            END;
        ");

        // =============================================
        // 3. PROCEDURE: sp_laporan_rekrutmen
        //    Stored Procedure menghasilkan laporan agregasi rekrutmen
        //    per lowongan: total pelamar, shortlisted, interview, 
        //    rejected, hired, avg skor wawancara
        // =============================================
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_laporan_rekrutmen;");
        DB::unprepared("
            CREATE PROCEDURE sp_laporan_rekrutmen()
            BEGIN
                SELECT 
                    jp.id AS job_id,
                    jp.title AS job_title,
                    jp.status AS job_status,
                    jp.quota,
                    jp.passing_grade,
                    jp.age_min,
                    jp.age_max,
                    COUNT(a.id) AS total_pelamar,
                    SUM(CASE WHEN a.status = 'applied' THEN 1 ELSE 0 END) AS menunggu,
                    SUM(CASE WHEN a.status = 'shortlisted' THEN 1 ELSE 0 END) AS shortlisted,
                    SUM(CASE WHEN a.status = 'interview' THEN 1 ELSE 0 END) AS interview,
                    SUM(CASE WHEN a.status = 'rejected' THEN 1 ELSE 0 END) AS ditolak,
                    SUM(CASE WHEN a.status = 'accepted' THEN 1 ELSE 0 END) AS diterima,
                    ROUND(AVG(ir.score), 1) AS rata_rata_skor_interview,
                    MIN(ir.score) AS skor_terendah,
                    MAX(ir.score) AS skor_tertinggi
                FROM job_postings jp
                LEFT JOIN applications a ON a.job_id = jp.id
                LEFT JOIN interviews i ON i.application_id = a.id
                LEFT JOIN interview_results ir ON ir.interview_id = i.id
                GROUP BY jp.id, jp.title, jp.status, jp.quota, jp.passing_grade, jp.age_min, jp.age_max
                ORDER BY jp.created_at DESC;
            END;
        ");

        // =============================================
        // 4. PROCEDURE: sp_statistik_pelamar
        //    Menampilkan statistik profil pelamar:
        //    total lamaran, lamaran aktif, umur, status terakhir
        // =============================================
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_statistik_pelamar;");
        DB::unprepared("
            CREATE PROCEDURE sp_statistik_pelamar(IN p_user_id BIGINT)
            BEGIN
                SELECT 
                    u.id AS user_id,
                    u.name,
                    u.email,
                    fn_hitung_umur_pelamar(u.id) AS umur,
                    COUNT(a.id) AS total_lamaran,
                    SUM(CASE WHEN a.status IN ('applied', 'shortlisted', 'interview') THEN 1 ELSE 0 END) AS lamaran_aktif,
                    SUM(CASE WHEN a.status = 'accepted' THEN 1 ELSE 0 END) AS diterima,
                    SUM(CASE WHEN a.status = 'rejected' THEN 1 ELSE 0 END) AS ditolak,
                    (SELECT ROUND(AVG(ir2.score), 1) 
                     FROM interviews i2 
                     JOIN interview_results ir2 ON ir2.interview_id = i2.id 
                     JOIN applications a2 ON a2.id = i2.application_id 
                     WHERE a2.user_id = u.id) AS rata_rata_skor
                FROM users u
                LEFT JOIN applications a ON a.user_id = u.id
                WHERE u.id = p_user_id
                GROUP BY u.id, u.name, u.email;
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

        DB::unprepared("DROP FUNCTION IF EXISTS fn_hitung_umur_pelamar;");
        DB::unprepared("DROP FUNCTION IF EXISTS fn_cek_kelayakan_melamar;");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_laporan_rekrutmen;");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_statistik_pelamar;");
    }
};
