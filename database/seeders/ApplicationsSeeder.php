<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('applications')->insert([
            [
                'id'           => 1,
                'user_id'      => 3, // Budi Santoso
                'job_id'       => 1, // Mobile Developer (Flutter)
                'cv_id'        => 1,
                'cover_letter' => 'Saya sangat tertarik dengan posisi Flutter Developer di Eco Green. Saya memiliki pengalaman 2 tahun.',
                'resume_url'   => null,
                'status'       => 'interview',
                'hr_notes'     => 'Kandidat memiliki dasar Flutter yang kuat.',
                'created_at'   => now()->subDays(5),
                'updated_at'   => now()->subDays(2),
            ],
            [
                'id'           => 2,
                'user_id'      => 4, // Sari Dewi
                'job_id'       => 1, // Mobile Developer (Flutter)
                'cv_id'        => 2,
                'cover_letter' => 'Saya Flutter Developer junior yang siap belajar banyak di Eco Green.',
                'resume_url'   => null,
                'status'       => 'applied',
                'hr_notes'     => null,
                'created_at'   => now()->subDays(4),
                'updated_at'   => now()->subDays(4),
            ],
            [
                'id'           => 3,
                'user_id'      => 5, // Ahmad Rizki
                'job_id'       => 2, // DevOps Engineer
                'cv_id'        => 3,
                'cover_letter' => 'Saya memiliki sertifikasi AWS Practitioner dan terbiasa dengan Docker & CI/CD.',
                'resume_url'   => null,
                'status'       => 'shortlisted',
                'hr_notes'     => 'Cocok untuk diundang interview tahap berikutnya.',
                'created_at'   => now()->subDays(3),
                'updated_at'   => now()->subDay(),
            ],
            [
                'id'           => 4,
                'user_id'      => 6, // Frankie Schmidt
                'job_id'       => 3, // Senior Frontend Developer (React)
                'cv_id'        => 4,
                'cover_letter' => 'I have 4 years of experience building React applications and optimizing performance.',
                'resume_url'   => null,
                'status'       => 'interview',
                'hr_notes'     => 'Good communication skills, strong technical foundation.',
                'created_at'   => now()->subDays(6),
                'updated_at'   => now()->subDays(2),
            ],
            [
                'id'           => 5,
                'user_id'      => 7, // Milton Howe III
                'job_id'       => 3, // Senior Frontend Developer (React)
                'cv_id'        => 5,
                'cover_letter' => 'I am looking for a challenging React developer role in Batam.',
                'resume_url'   => null,
                'status'       => 'accepted',
                'hr_notes'     => 'Lolos semua tahapan seleksi dengan nilai sangat baik.',
                'created_at'   => now()->subDays(8),
                'updated_at'   => now()->subDays(1),
            ],
            [
                'id'           => 6,
                'user_id'      => 8, // Hattie Gerlach
                'job_id'       => 4, // HR Training & Development Specialist
                'cv_id'        => 6,
                'cover_letter' => 'Saya lulusan Psikologi dengan ketertarikan tinggi di bidang L&D.',
                'resume_url'   => null,
                'status'       => 'rejected',
                'hr_notes'     => 'Kurang berpengalaman di bidang korporat L&D.',
                'created_at'   => now()->subDays(7),
                'updated_at'   => now()->subDays(3),
            ],
            [
                'id'           => 7,
                'user_id'      => 9, // Madeline Pollich
                'job_id'       => 5, // Data Scientist
                'cv_id'        => 7,
                'cover_letter' => 'I specialize in machine learning models and Python analysis.',
                'resume_url'   => null,
                'status'       => 'interview',
                'hr_notes'     => 'Excellent statistical knowledge.',
                'created_at'   => now()->subDays(4),
                'updated_at'   => now()->subDays(1),
            ],
            [
                'id'           => 8,
                'user_id'      => 10, // Margot Goyette
                'job_id'       => 7, // Production Line Supervisor
                'cv_id'        => 8,
                'cover_letter' => 'Saya siap bekerja keras memimpin tim lini produksi.',
                'resume_url'   => null,
                'status'       => 'applied',
                'hr_notes'     => null,
                'created_at'   => now()->subDays(2),
                'updated_at'   => now()->subDays(2),
            ],
            [
                'id'           => 9,
                'user_id'      => 11, // Lucile Bogan V
                'job_id'       => 7, // Production Line Supervisor
                'cv_id'        => 9,
                'cover_letter' => 'Memiliki pengalaman 2 tahun mengelola shift pabrik oleokimia.',
                'resume_url'   => null,
                'status'       => 'applied',
                'hr_notes'     => null,
                'created_at'   => now()->subDays(2),
                'updated_at'   => now()->subDays(2),
            ],
            [
                'id'           => 10,
                'user_id'      => 12, // Alf Schroeder
                'job_id'       => 7, // Production Line Supervisor
                'cv_id'        => 10,
                'cover_letter' => 'Siap diposisikan onsite di Batam untuk supervisor lini produksi.',
                'resume_url'   => null,
                'status'       => 'applied',
                'hr_notes'     => null,
                'created_at'   => now()->subDays(1),
                'updated_at'   => now()->subDays(1),
            ],
        ]);
    }
}
