<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:test-routes', function () {
    $user = \App\Models\User::find(17);
    if (!$user) {
        $this->error("User ID 17 not found!");
        return;
    }
    \Illuminate\Support\Facades\Auth::login($user);
    $this->info("Logged in as: " . $user->name . " (Role: " . $user->role . ")");

    // Test /pelamar/cv
    $this->info("Testing /pelamar/cv...");
    try {
        $response = $this->call('route:call', ['uri' => '/pelamar/cv']);
    } catch (\Exception $e) {
        $this->error("Exception: " . $e->getMessage());
        $this->error($e->getTraceAsString());
    }

    // Direct invocation of controller index to inspect the error
    $this->info("Invoking ApplicantCvController@index directly...");
    try {
        $controller = app(\App\Http\Controllers\ApplicantCvController::class);
        $res = $controller->index();
        $this->info("Success calling index()!");
    } catch (\Exception $e) {
        $this->error("Exception: " . $e->getMessage());
        $this->error("File: " . $e->getFile() . " Line: " . $e->getLine());
        $this->error($e->getTraceAsString());
    }

    // Direct invocation of ApplicantLampiranController@index
    $this->info("Invoking ApplicantLampiranController@index directly...");
    try {
        $controller = app(\App\Http\Controllers\ApplicantLampiranController::class);
        $res = $controller->index();
        $this->info("Success calling index()!");
    } catch (\Exception $e) {
        $this->error("Exception: " . $e->getMessage());
        $this->error("File: " . $e->getFile() . " Line: " . $e->getLine());
        $this->error($e->getTraceAsString());
    }
});

