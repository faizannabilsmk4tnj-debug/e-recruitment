<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed default locations
        DB::table('work_locations')->insert([
            ['name' => 'Medan Plant (HQ)', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Batam Plant', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jakarta Office', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Singapore Office', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Remote', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('work_locations');
    }
};
