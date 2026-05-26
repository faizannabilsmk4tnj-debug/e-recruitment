<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('notifications')->insert([
            [
                'id'         => 1,
                'user_id'    => 3,
                'type'       => 'status_changed',
                'title'      => 'Lamaran Anda Diperbarui',
                'message'    => 'Selamat! Lamaran Anda untuk posisi Backend Developer Laravel telah masuk tahap Shortlisted.',
                'data'       => '{"application_id":1,"new_status":"shortlisted"}',
                'read_at'    => null,
                'created_at' => '2026-03-26 01:18:14',
            ],
            [
                'id'         => 2,
                'user_id'    => 3,
                'type'       => 'application_received',
                'title'      => 'Lamaran Berhasil Dikirim',
                'message'    => 'Lamaran Anda untuk posisi Frontend Developer telah berhasil dikirim.',
                'data'       => '{"application_id":2,"job_title":"Frontend Developer"}',
                'read_at'    => '2026-03-25 18:18:14',
                'created_at' => '2026-03-26 01:18:14',
            ],
            [
                'id'         => 3,
                'user_id'    => 4,
                'type'       => 'interview_scheduled',
                'title'      => 'Undangan Wawancara',
                'message'    => 'Anda dijadwalkan untuk wawancara online pada 29 Mar 2026 pukul 10.00 WIB.',
                'data'       => '{"interview_id":1,"type":"online","link":"https://meet.google.com/eco-green-interview"}',
                'read_at'    => null,
                'created_at' => '2026-03-26 01:18:14',
            ],
            [
                'id'         => 4,
                'user_id'    => 4,
                'type'       => 'status_changed',
                'title'      => 'Lamaran Masuk Tahap Interview',
                'message'    => 'Selamat! Lamaran Anda untuk posisi Staff Keuangan & Akuntansi telah masuk tahap Interview.',
                'data'       => '{"application_id":3,"new_status":"interview"}',
                'read_at'    => '2026-03-25 18:18:14',
                'created_at' => '2026-03-26 01:18:14',
            ],
            [
                'id'         => 5,
                'user_id'    => 5,
                'type'       => 'status_changed',
                'title'      => 'Update Status Lamaran',
                'message'    => 'Mohon maaf, lamaran Anda untuk posisi Backend Developer Laravel tidak dapat kami lanjutkan saat ini.',
                'data'       => '{"application_id":4,"new_status":"rejected"}',
                'read_at'    => null,
                'created_at' => '2026-03-26 01:18:14',
            ],
        ]);
    }
}
