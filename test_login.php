<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Fix hr@ecogreen.com - set password to 'password' (as documented in seeder)
$hash = Hash::make('password');
DB::table('users')->where('email', 'hr@ecogreen.com')->update([
    'password_hash' => $hash,
    'password' => $hash,
]);

// Verify
echo "hr@ecogreen.com check 'password': " . (Hash::check('password', DB::table('users')->where('email', 'hr@ecogreen.com')->value('password_hash')) ? 'PASS ✓' : 'FAIL ✗') . PHP_EOL;
echo "nouzenshin check '12345678': " . (Hash::check('12345678', DB::table('users')->where('email', 'nouzenshin@gmail.com')->value('password_hash')) ? 'PASS ✓' : 'FAIL ✗') . PHP_EOL;
echo "shinnouzen check '12345678': " . (Hash::check('12345678', DB::table('users')->where('email', 'shinnouzen@gmail.com')->value('password_hash')) ? 'PASS ✓' : 'FAIL ✗') . PHP_EOL;
