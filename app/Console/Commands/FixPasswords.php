<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FixPasswords extends Command
{
    protected $signature = 'fix:passwords';
    protected $description = 'Fix password_hash for all users';

    public function handle()
    {
        // Fix hr@ecogreen.com - password is 'password'
        $hash1 = Hash::make('password');
        DB::table('users')->where('email', 'hr@ecogreen.com')->update([
            'password_hash' => $hash1,
            'password' => $hash1,
        ]);
        $this->info("Fixed hr@ecogreen.com -> password: 'password'");

        // Verify all 3 key users
        $checks = [
            ['email' => 'nouzenshin@gmail.com', 'pw' => '12345678'],
            ['email' => 'ecorgeen@gmail.com', 'pw' => '12345678'],
            ['email' => 'hr@ecogreen.com', 'pw' => 'password'],
        ];

        foreach ($checks as $c) {
            $hash = DB::table('users')->where('email', $c['email'])->value('password_hash');
            $result = Hash::check($c['pw'], $hash) ? 'PASS' : 'FAIL';
            $this->info("{$c['email']} ({$c['pw']}): {$result}");
        }
    }
}
