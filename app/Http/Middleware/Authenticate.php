<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Flash pesan peringatan ke session
        session()->flash('auth_warning', 'Anda harus login terlebih dahulu untuk mengakses halaman tersebut.');

        // Redirect ke HR login jika akses route HR
        if (str_starts_with($request->path(), 'hr/')) {
            return '/hr/login';
        }

        return route('login');
    }
}
