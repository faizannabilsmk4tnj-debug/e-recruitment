<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProfilesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user_profiles')->insert([
            ['id' => 1,  'user_id' => 1,  'address' => null, 'city' => 'Batam', 'province' => 'Kepulauan Riau', 'birth_date' => null, 'gender' => null, 'avatar_url' => null, 'updated_at' => null],
            ['id' => 2,  'user_id' => 2,  'address' => null, 'city' => 'Batam', 'province' => 'Kepulauan Riau', 'birth_date' => null, 'gender' => null, 'avatar_url' => null, 'updated_at' => null],
            ['id' => 3,  'user_id' => 3,  'address' => null, 'city' => 'Batam', 'province' => 'Kepulauan Riau', 'birth_date' => '2000-05-15', 'gender' => 'male', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 4,  'user_id' => 4,  'address' => null, 'city' => 'Batam', 'province' => 'Kepulauan Riau', 'birth_date' => '1998-08-22', 'gender' => 'female', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 5,  'user_id' => 5,  'address' => null, 'city' => 'Batam', 'province' => 'Kepulauan Riau', 'birth_date' => '1999-03-10', 'gender' => 'male', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 6,  'user_id' => 6,  'address' => null, 'city' => 'Jakarta', 'province' => 'DKI Jakarta', 'birth_date' => null, 'gender' => 'female', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 7,  'user_id' => 7,  'address' => null, 'city' => 'Tanjung Pinang', 'province' => 'Jawa Timur', 'birth_date' => null, 'gender' => 'male', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 8,  'user_id' => 8,  'address' => null, 'city' => 'Tanjung Pinang', 'province' => 'Jawa Timur', 'birth_date' => null, 'gender' => 'male', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 9,  'user_id' => 9,  'address' => null, 'city' => 'Batam', 'province' => 'DKI Jakarta', 'birth_date' => null, 'gender' => 'male', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 10, 'user_id' => 10, 'address' => null, 'city' => 'Batam', 'province' => 'Kepulauan Riau', 'birth_date' => null, 'gender' => 'male', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 11, 'user_id' => 11, 'address' => null, 'city' => 'Surabaya', 'province' => 'DKI Jakarta', 'birth_date' => null, 'gender' => 'female', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 12, 'user_id' => 12, 'address' => null, 'city' => 'Tanjung Pinang', 'province' => 'DKI Jakarta', 'birth_date' => null, 'gender' => 'female', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 13, 'user_id' => 13, 'address' => null, 'city' => 'Tanjung Pinang', 'province' => 'DKI Jakarta', 'birth_date' => null, 'gender' => 'female', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 14, 'user_id' => 14, 'address' => null, 'city' => 'Tanjung Pinang', 'province' => 'Kepulauan Riau', 'birth_date' => null, 'gender' => 'male', 'avatar_url' => null, 'updated_at' => null],
            ['id' => 15, 'user_id' => 15, 'address' => null, 'city' => 'Batam', 'province' => 'Jawa Timur', 'birth_date' => null, 'gender' => 'female', 'avatar_url' => null, 'updated_at' => null],
        ]);
    }
}
