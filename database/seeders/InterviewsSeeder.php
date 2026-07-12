<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InterviewsSeeder extends Seeder
{
    public function run(): void
    {
        $tomorrow = Carbon::tomorrow();

        DB::table('interviews')->insert([
            [
                'id'                => 1,
                'application_id'    => 1, // Budi Santoso
                'scheduled_by'      => 1, // Admin HR
                'scheduled_at'      => $tomorrow->copy()->setTime(9, 0, 0),
                'duration_minutes'  => 60,
                'interview_type'    => 'online',
                'location_or_link'  => 'https://meet.google.com/abc-defg-hij',
                'status'            => 'scheduled',
                'notes'             => 'Interview teknis Flutter Developer.',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'id'                => 2,
                'application_id'    => 4, // Frankie Schmidt
                'scheduled_by'      => 2, // Siti Rahayu HR
                'scheduled_at'      => $tomorrow->copy()->setTime(11, 30, 0),
                'duration_minutes'  => 60,
                'interview_type'    => 'offline',
                'location_or_link'  => 'Ruang Meeting A2',
                'status'            => 'scheduled',
                'notes'             => 'Interview manajerial & kecocokan budaya.',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'id'                => 3,
                'application_id'    => 7, // Madeline Pollich
                'scheduled_by'      => 16, // Eco Green HR Master
                'scheduled_at'      => $tomorrow->copy()->setTime(14, 0, 0),
                'duration_minutes'  => 60,
                'interview_type'    => 'online',
                'location_or_link'  => 'https://zoom.us/j/123456789',
                'status'            => 'scheduled',
                'notes'             => 'Interview Data Science.',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}
