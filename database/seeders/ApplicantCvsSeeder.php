<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicantCvsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('applicant_cvs')->insert([
            ['id' => 1,  'user_id' => 3,  'template_id' => 1, 'title' => 'CV Utama Budi Santoso',          'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:13', 'updated_at' => '2026-03-25 18:18:13'],
            ['id' => 2,  'user_id' => 4,  'template_id' => 1, 'title' => 'CV Utama Sari Dewi',              'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:13', 'updated_at' => '2026-03-25 18:18:13'],
            ['id' => 3,  'user_id' => 5,  'template_id' => 1, 'title' => 'CV Utama Ahmad Rizki',            'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:13', 'updated_at' => '2026-03-25 18:18:13'],
            ['id' => 4,  'user_id' => 6,  'template_id' => 1, 'title' => 'CV Utama Mr. Frankie Schmidt DDS','cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:13', 'updated_at' => '2026-03-25 18:18:13'],
            ['id' => 5,  'user_id' => 7,  'template_id' => 1, 'title' => 'CV Utama Milton Howe III',        'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:13', 'updated_at' => '2026-03-25 18:18:13'],
            ['id' => 6,  'user_id' => 8,  'template_id' => 1, 'title' => 'CV Utama Hattie Gerlach DDS',    'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:14', 'updated_at' => '2026-03-25 18:18:14'],
            ['id' => 7,  'user_id' => 9,  'template_id' => 1, 'title' => 'CV Utama Madeline Pollich',       'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:14', 'updated_at' => '2026-03-25 18:18:14'],
            ['id' => 8,  'user_id' => 10, 'template_id' => 1, 'title' => 'CV Utama Margot Goyette',         'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:14', 'updated_at' => '2026-03-25 18:18:14'],
            ['id' => 9,  'user_id' => 11, 'template_id' => 1, 'title' => 'CV Utama Lucile Bogan V',         'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:14', 'updated_at' => '2026-03-25 18:18:14'],
            ['id' => 10, 'user_id' => 12, 'template_id' => 1, 'title' => 'CV Utama Alf Schroeder',           'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:14', 'updated_at' => '2026-03-25 18:18:14'],
            ['id' => 11, 'user_id' => 13, 'template_id' => 1, 'title' => 'CV Utama Jerrold Hirthe',          'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:14', 'updated_at' => '2026-03-25 18:18:14'],
            ['id' => 12, 'user_id' => 14, 'template_id' => 1, 'title' => 'CV Utama Betsy Deckow',            'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:14', 'updated_at' => '2026-03-25 18:18:14'],
            ['id' => 13, 'user_id' => 15, 'template_id' => 1, 'title' => 'CV Utama Prof. Reginald King',     'cv_data' => '{"objective":"Mencari posisi yang sesuai dengan kemampuan saya.","sections":["experience","education","skills"]}', 'pdf_url' => null, 'is_primary' => 1, 'created_at' => '2026-03-25 18:18:14', 'updated_at' => '2026-03-25 18:18:14'],
        ]);
    }
}
