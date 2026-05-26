<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterviewsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('interviews')->insert([
            [
                'id'               => 1,
                'application_id'   => 3,
                'scheduled_by'     => 1,
                'scheduled_at'     => '2026-03-29 10:00:00',
                'duration_minutes' => 60,
                'interview_type'   => 'online',
                'location_or_link' => 'https://meet.google.com/eco-green-interview',
                'status'           => 'scheduled',
                'notes'            => 'Mohon hadir 5 menit sebelum jadwal. Siapkan dokumen pendukung.',
                'created_at'       => '2026-03-25 18:18:14',
                'updated_at'       => '2026-03-25 18:18:14',
            ],
            [
                'id'               => 2,
                'application_id'   => 3,
                'scheduled_by'     => 1,
                'scheduled_at'     => '2026-03-19 14:00:00',
                'duration_minutes' => 45,
                'interview_type'   => 'offline',
                'location_or_link' => 'Kantor PT Eco Green, Gedung A Lantai 2, Batam',
                'status'           => 'completed',
                'notes'            => 'Wawancara awal untuk mengenal kandidat.',
                'created_at'       => '2026-03-25 18:18:14',
                'updated_at'       => '2026-03-25 18:18:14',
            ],
        ]);

        DB::table('interview_results')->insert([
            [
                'id'             => 1,
                'interview_id'   => 2,
                'reviewed_by'    => 1,
                'score'          => 82,
                'feedback'       => 'Kandidat memiliki pemahaman akuntansi yang baik dan komunikasi yang lancar. Pengalaman relevan dengan kebutuhan posisi. Perlu dites lebih lanjut terkait kemampuan software akuntansi.',
                'recommendation' => 'proceed',
                'created_at'     => '2026-03-26 01:18:14',
            ],
        ]);
    }
}
