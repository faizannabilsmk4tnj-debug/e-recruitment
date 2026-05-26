<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('job_categories')->insert([
            ['id' => 1, 'name' => 'IT & Engineering',        'slug' => 'it-engineering',        'icon' => null, 'is_active' => 1],
            ['id' => 2, 'name' => 'Finance & Accounting',    'slug' => 'finance-accounting',    'icon' => null, 'is_active' => 1],
            ['id' => 3, 'name' => 'Human Resources',         'slug' => 'human-resources',       'icon' => null, 'is_active' => 1],
            ['id' => 4, 'name' => 'Operations & Production', 'slug' => 'operations-production', 'icon' => null, 'is_active' => 1],
            ['id' => 5, 'name' => 'Marketing & Sales',       'slug' => 'marketing-sales',       'icon' => null, 'is_active' => 1],
            ['id' => 6, 'name' => 'Logistics & Supply Chain','slug' => 'logistics-supply-chain','icon' => null, 'is_active' => 1],
            ['id' => 7, 'name' => 'Quality Control',         'slug' => 'quality-control',       'icon' => null, 'is_active' => 1],
            ['id' => 8, 'name' => 'Research & Development',  'slug' => 'research-development',  'icon' => null, 'is_active' => 1],
        ]);
    }
}
