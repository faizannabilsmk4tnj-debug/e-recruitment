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
                'user_id'      => 3,
                'job_id'       => 1,
                'cv_id'        => 1,
                'cover_letter' => 'Saya sangat tertarik dengan posisi Backend Developer di PT Eco Green. Dengan pengalaman 2 tahun menggunakan Laravel dan MySQL, saya yakin dapat berkontribusi maksimal.',
                'resume_url'   => null,
                'status'       => 'shortlisted',
                'hr_notes'     => null,
                'created_at'   => '2026-03-25 18:18:14',
                'updated_at'   => '2026-03-25 18:18:14',
            ],
            [
                'id'           => 2,
                'user_id'      => 3,
                'job_id'       => 2,
                'cv_id'        => 1,
                'cover_letter' => 'Saya juga memiliki kemampuan frontend dan ingin mengembangkan keahlian di bidang ini.',
                'resume_url'   => null,
                'status'       => 'applied',
                'hr_notes'     => null,
                'created_at'   => '2026-03-25 18:18:14',
                'updated_at'   => '2026-03-25 18:18:14',
            ],
            [
                'id'           => 3,
                'user_id'      => 4,
                'job_id'       => 3,
                'cv_id'        => 2,
                'cover_letter' => 'Dengan pengalaman 3 tahun di bidang akuntansi, saya siap memberikan kontribusi terbaik untuk PT Eco Green Oleochemicals.',
                'resume_url'   => null,
                'status'       => 'interview',
                'hr_notes'     => null,
                'created_at'   => '2026-03-25 18:18:14',
                'updated_at'   => '2026-03-25 18:18:14',
            ],
            [
                'id'           => 4,
                'user_id'      => 5,
                'job_id'       => 1,
                'cv_id'        => 3,
                'cover_letter' => 'Saya ingin bergabung dan berkembang bersama tim IT PT Eco Green.',
                'resume_url'   => null,
                'status'       => 'rejected',
                'hr_notes'     => 'Pengalaman kurang dari yang dibutuhkan. Bisa dipertimbangkan untuk posisi junior di masa depan.',
                'created_at'   => '2026-03-25 18:18:14',
                'updated_at'   => '2026-03-25 18:18:14',
            ],
            [
                'id'           => 5,
                'user_id'      => 5,
                'job_id'       => 5,
                'cv_id'        => 3,
                'cover_letter' => 'Saya bersedia bekerja dalam sistem shift dan siap bekerja keras.',
                'resume_url'   => null,
                'status'       => 'applied',
                'hr_notes'     => null,
                'created_at'   => '2026-03-25 18:18:14',
                'updated_at'   => '2026-03-25 18:18:14',
            ],
        ]);

        // Application Status Logs
        DB::table('application_status_logs')->insert([
            ['id' => 1, 'application_id' => 1, 'changed_by' => 1, 'old_status' => 'applied',     'new_status' => 'shortlisted', 'reason' => 'Kandidat masuk dalam daftar shortlist untuk wawancara.', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 3, 'application_id' => 3, 'changed_by' => 1, 'old_status' => 'applied',     'new_status' => 'shortlisted', 'reason' => 'Kandidat terbaik dari semua pelamar.', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 5, 'application_id' => 3, 'changed_by' => 1, 'old_status' => 'shortlisted', 'new_status' => 'interview',   'reason' => 'Dijadwalkan wawancara tahap pertama.', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 7, 'application_id' => 4, 'changed_by' => 1, 'old_status' => 'applied',     'new_status' => 'rejected',    'reason' => 'Kualifikasi belum memenuhi standar minimum posisi ini.', 'created_at' => '2026-03-26 01:18:14'],
        ]);
    }
}
