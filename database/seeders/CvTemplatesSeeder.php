<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CvTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cv_templates')->insert([
            ['id' => 1, 'name' => 'Modern Professional', 'preview_url' => null, 'is_active' => 1, 'created_at' => '2026-03-26 01:18:13'],
            ['id' => 2, 'name' => 'Classic Elegant',     'preview_url' => null, 'is_active' => 1, 'created_at' => '2026-03-26 01:18:13'],
            ['id' => 3, 'name' => 'Fresh Graduate',      'preview_url' => null, 'is_active' => 1, 'created_at' => '2026-03-26 01:18:13'],
            ['id' => 4, 'name' => 'Creative Portfolio',  'preview_url' => null, 'is_active' => 0, 'created_at' => '2026-03-26 01:18:13'],
        ]);
    }
}
