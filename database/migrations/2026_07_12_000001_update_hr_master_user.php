<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. If shinnouzen@gmail.com exists, update its email, name, and password
        $shinnouzen = DB::table('users')->where('email', 'shinnouzen@gmail.com')->first();
        if ($shinnouzen) {
            DB::table('users')->where('id', $shinnouzen->id)->update([
                'name' => 'Eco Green HR Master',
                'email' => 'ecogreenhrmaster@gmail.com',
                'password_hash' => Hash::make('12345678'),
                'role' => 'hr_master',
                'is_active' => 1,
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // If shinnouzen@gmail.com does not exist, check if ecogreenhrmaster@gmail.com exists
            $exists = DB::table('users')->where('email', 'ecogreenhrmaster@gmail.com')->exists();
            if (!$exists) {
                $id_available = DB::table('users')->where('id', 16)->count() === 0;
                $insertData = [
                    'name' => 'Eco Green HR Master',
                    'email' => 'ecogreenhrmaster@gmail.com',
                    'password_hash' => Hash::make('12345678'),
                    'role' => 'hr_master',
                    'is_active' => 1,
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if ($id_available) {
                    $insertData['id'] = 16;
                }
                DB::table('users')->insert($insertData);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back ecogreenhrmaster@gmail.com to shinnouzen@gmail.com
        DB::table('users')->where('email', 'ecogreenhrmaster@gmail.com')->update([
            'name' => 'Nouzen',
            'email' => 'shinnouzen@gmail.com',
            'password_hash' => Hash::make('12345678'),
        ]);
    }
};
