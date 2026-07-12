<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Urutan seeder penting! Mengikuti dependency foreign key.
     * Jalankan: php artisan migrate --seed
     * Atau:     php artisan db:seed
     */
    public function run(): void
    {
        $this->call([
            // 1. Tabel utama (tidak ada FK ke tabel lain)
            UsersSeeder::class,
            UserProfilesSeeder::class,

            // 2. Template CV (dibutuhkan sebelum applicant_cvs)
            CvTemplatesSeeder::class,

            // 3. CV pelamar (FK ke users & cv_templates)
            ApplicantCvsSeeder::class,

            // 4. Pendidikan & Skill (FK ke users)
            EducationsAndSkillsSeeder::class,

            // 5. Pengalaman kerja (FK ke users)
            WorkExperiencesSeeder::class,

            // 6. Kategori & Lowongan kerja
            JobCategoriesSeeder::class,
            TestJobPostingsSeeder::class,

            // 7. Lamaran & log status (FK ke users, job_postings, applicant_cvs)
            ApplicationsSeeder::class,

            // 8. Wawancara & hasil (FK ke applications)
            InterviewsSeeder::class,

            // 9. Notifikasi (FK ke users)
            NotificationsSeeder::class,
        ]);
    }
}
