<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('cv_templates')
            ->where('is_active', true)
            ->where('status', 'draft')
            ->update(['status' => 'published']);

        $hasDefault = DB::table('cv_templates')->where('is_default', true)->exists();

        if (! $hasDefault) {
            $defaultTemplateId = DB::table('cv_templates')
                ->where('status', 'published')
                ->orderBy('id')
                ->value('id');

            if ($defaultTemplateId) {
                DB::table('cv_templates')
                    ->where('id', $defaultTemplateId)
                    ->update(['is_default' => true]);
            }
        }
    }

    public function down(): void
    {
        //
    }
};
