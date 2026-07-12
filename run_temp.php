<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = array_map('current', DB::select('SHOW TABLES'));
echo "Total Tables: " . count($tables) . "\n";
foreach ($tables as $index => $table) {
    echo ($index + 1) . ". " . $table . "\n";
}
