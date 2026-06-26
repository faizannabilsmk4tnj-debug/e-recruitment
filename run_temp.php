<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\Artisan;

echo "Running check-vacancy-deadlines command...\n";
Artisan::call('app:check-vacancy-deadlines');
echo Artisan::output();
echo "Done!\n";
