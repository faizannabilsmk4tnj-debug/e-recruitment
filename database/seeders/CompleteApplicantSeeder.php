<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompleteApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Completes Shin's profile (user_id = 17) to 100% completion rate.
     */
    public function run(): void
    {
        $userId = 17;

        // 1. Update phone in users table
        DB::table('users')->where('id', $userId)->update([
            'phone' => '081234567890'
        ]);

        // 2. Insert/update user_profiles
        DB::table('user_profiles')->updateOrInsert(
            ['user_id' => $userId],
            [
                'nik' => '2171012345678901',
                'address' => 'Ruko Eco Green Block A No. 12, Batam Center',
                'city' => 'Batam',
                'province' => 'Kepulauan Riau',
                'birth_date' => '1999-05-15',
                'gender' => 'male',
                'avatar_url' => 'avatars/default.png',
                'updated_at' => now(),
            ]
        );

        // 3. Insert/update educations
        DB::table('educations')->updateOrInsert(
            ['user_id' => $userId],
            [
                'institution' => 'Universitas Indonesia',
                'degree' => 'S1',
                'major' => 'Teknik Informatika',
                'gpa' => 3.90,
                'start_year' => '2019',
                'end_year' => '2023',
                'created_at' => now(),
            ]
        );

        // 4. Insert/update portofolio
        DB::table('portofolio')->updateOrInsert(
            ['user_id' => $userId],
            [
                'title' => 'EcoGreen E-Recruitment System Portal',
                'description' => 'A beautiful high-fidelity recruitment portal built with Laravel, TailwindCSS, and MySQL.',
                'type' => 'link',
                'link_url' => 'https://github.com/nouzenshin/e-recruitment',
                'created_at' => now(),
            ]
        );

        // 5. Insert/update work_experiences
        DB::table('work_experiences')->updateOrInsert(
            ['user_id' => $userId],
            [
                'company_name' => 'EcoGreen Corporation',
                'position' => 'Junior Web Developer',
                'start_date' => '2023-08-01',
                'end_date' => '2025-12-31',
                'is_current' => 0,
                'description' => 'Developing corporate applications and database optimization.',
            ]
        );

        // 6. Insert/update organization_experiences
        DB::table('organization_experiences')->updateOrInsert(
            ['user_id' => $userId],
            [
                'organization_name' => 'Himpunan Mahasiswa Informatika (HMTI)',
                'position' => 'Head of R&D Department',
                'start_date' => '2020-01-01',
                'end_date' => '2021-12-31',
                'description' => 'Organizing campus workshops, technical coding meetups, and open-source events.',
                'created_at' => now(),
            ]
        );

        // 7. Insert/update applicant_skills
        DB::table('applicant_skills')->updateOrInsert(
            ['user_id' => $userId, 'skill_name' => 'Laravel & Vue.js Full-Stack'],
            [
                'category' => 'technical',
                'level' => 'expert',
                'cert_name' => 'Certified Laravel Developer',
                'cert_file_path' => 'certs/laravel-dev.pdf',
                'created_at' => now(),
            ]
        );
    }
}
