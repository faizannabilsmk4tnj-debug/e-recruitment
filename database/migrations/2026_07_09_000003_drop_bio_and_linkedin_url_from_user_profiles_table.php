<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('user_profiles', 'bio')) {
                $table->dropColumn('bio');
            }
            if (Schema::hasColumn('user_profiles', 'linkedin_url')) {
                $table->dropColumn('linkedin_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('user_profiles', 'bio')) {
                $table->text('bio')->nullable();
            }
            if (!Schema::hasColumn('user_profiles', 'linkedin_url')) {
                $table->string('linkedin_url')->nullable();
            }
        });
    }
};
