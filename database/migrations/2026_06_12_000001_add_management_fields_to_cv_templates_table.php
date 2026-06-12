<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cv_templates', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->longText('content_html')->nullable()->after('preview_url');
            $table->enum('status', ['draft', 'published'])->default('draft')->after('content_html');
            $table->boolean('is_default')->default(false)->after('is_active');
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });

        DB::table('cv_templates')
            ->where('is_active', true)
            ->update(['status' => 'published']);

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

    public function down(): void
    {
        Schema::table('cv_templates', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'content_html',
                'status',
                'is_default',
                'updated_at',
            ]);
        });
    }
};
