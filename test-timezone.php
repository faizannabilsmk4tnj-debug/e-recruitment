<?php
require __DIR__ . '/vendor/autoload.php';

$c = \Carbon\Carbon::parse('2026-07-13'); // Simulating Eloquent retrieved Carbon instance (UTC)
echo "Direct parse: " . \Carbon\Carbon::parse($c, 'Asia/Jakarta')->endOfDay()->toIso8601String() . "\n";
echo "Format first parse: " . \Carbon\Carbon::parse($c->format('Y-m-d'), 'Asia/Jakarta')->endOfDay()->toIso8601String() . "\n";
