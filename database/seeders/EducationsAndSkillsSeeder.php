<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationsAndSkillsSeeder extends Seeder
{
    public function run(): void
    {
        // Educations
        DB::table('educations')->insert([
            ['id' => 1,  'user_id' => 3,  'institution' => 'Universitas Riau',          'degree' => 'S1', 'major' => 'Teknik Informatika', 'gpa' => 3.75, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:13'],
            ['id' => 2,  'user_id' => 4,  'institution' => 'Politeknik Negeri Batam',   'degree' => 'D3', 'major' => 'Akuntansi',           'gpa' => 3.12, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:13'],
            ['id' => 3,  'user_id' => 5,  'institution' => 'Universitas Riau',          'degree' => 'S1', 'major' => 'Teknik Industri',     'gpa' => 3.07, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:13'],
            ['id' => 4,  'user_id' => 6,  'institution' => 'Universitas Indonesia',     'degree' => 'D3', 'major' => 'Teknik Industri',     'gpa' => 3.54, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:13'],
            ['id' => 5,  'user_id' => 7,  'institution' => 'Universitas Indonesia',     'degree' => 'S1', 'major' => 'Teknik Industri',     'gpa' => 3.06, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 6,  'user_id' => 8,  'institution' => 'Universitas Riau',          'degree' => 'D3', 'major' => 'Sistem Informasi',    'gpa' => 3.78, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 7,  'user_id' => 9,  'institution' => 'Universitas Riau',          'degree' => 'D3', 'major' => 'Akuntansi',           'gpa' => 3.08, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 8,  'user_id' => 10, 'institution' => 'Universitas Putera Batam',  'degree' => 'D3', 'major' => 'Sistem Informasi',    'gpa' => 3.74, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 9,  'user_id' => 11, 'institution' => 'Universitas Riau',          'degree' => 'S1', 'major' => 'Sistem Informasi',    'gpa' => 3.29, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 10, 'user_id' => 12, 'institution' => 'Politeknik Negeri Batam',   'degree' => 'D3', 'major' => 'Teknik Industri',     'gpa' => 3.39, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 11, 'user_id' => 13, 'institution' => 'Universitas Riau',          'degree' => 'D3', 'major' => 'Manajemen',           'gpa' => 3.91, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 12, 'user_id' => 14, 'institution' => 'Politeknik Negeri Batam',   'degree' => 'D3', 'major' => 'Sistem Informasi',    'gpa' => 3.55, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:14'],
            ['id' => 13, 'user_id' => 15, 'institution' => 'Universitas Indonesia',     'degree' => 'S1', 'major' => 'Akuntansi',           'gpa' => 3.07, 'start_year' => '2019', 'end_year' => '2023', 'created_at' => '2026-03-26 01:18:14'],
        ]);

        // Applicant Skills (sample - 3 users)
        DB::table('applicant_skills')->insert([
            ['id' => 1,  'id_user' => 3, 'skill_name' => 'Microsoft Office', 'category' => 'technical', 'level' => 'expert',       'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:13', 'updated_at' => '2026-03-26 01:18:13'],
            ['id' => 2,  'id_user' => 3, 'skill_name' => 'Komunikasi',       'category' => 'soft',      'level' => 'expert',       'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:13', 'updated_at' => '2026-03-26 01:18:13'],
            ['id' => 3,  'id_user' => 3, 'skill_name' => 'Bahasa Inggris',   'category' => 'language',  'level' => 'intermediate', 'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:13', 'updated_at' => '2026-03-26 01:18:13'],
            ['id' => 4,  'id_user' => 4, 'skill_name' => 'Microsoft Office', 'category' => 'technical', 'level' => 'expert',       'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:13', 'updated_at' => '2026-03-26 01:18:13'],
            ['id' => 5,  'id_user' => 4, 'skill_name' => 'Komunikasi',       'category' => 'soft',      'level' => 'expert',       'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:13', 'updated_at' => '2026-03-26 01:18:13'],
            ['id' => 6,  'id_user' => 4, 'skill_name' => 'Bahasa Inggris',   'category' => 'language',  'level' => 'intermediate', 'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:13', 'updated_at' => '2026-03-26 01:18:13'],
            ['id' => 7,  'id_user' => 5, 'skill_name' => 'Microsoft Office', 'category' => 'technical', 'level' => 'expert',       'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:13', 'updated_at' => '2026-03-26 01:18:13'],
            ['id' => 8,  'id_user' => 5, 'skill_name' => 'Komunikasi',       'category' => 'soft',      'level' => 'expert',       'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:13', 'updated_at' => '2026-03-26 01:18:13'],
            ['id' => 9,  'id_user' => 5, 'skill_name' => 'Bahasa Inggris',   'category' => 'language',  'level' => 'intermediate', 'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:13', 'updated_at' => '2026-03-26 01:18:13'],
            ['id' => 40, 'id_user' => 3, 'skill_name' => 'Laravel',          'category' => 'technical', 'level' => 'expert',       'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:14', 'updated_at' => '2026-03-26 01:18:14'],
            ['id' => 41, 'id_user' => 3, 'skill_name' => 'MySQL',            'category' => 'technical', 'level' => 'intermediate', 'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:14', 'updated_at' => '2026-03-26 01:18:14'],
            ['id' => 42, 'id_user' => 3, 'skill_name' => 'JavaScript',       'category' => 'technical', 'level' => 'intermediate', 'cert_name' => null, 'cert_file_path' => null, 'created_at' => '2026-03-26 01:18:14', 'updated_at' => '2026-03-26 01:18:14'],
        ]);
    }
}
