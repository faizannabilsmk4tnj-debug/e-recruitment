<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware untuk memastikan user sudah login DAN memiliki role yang sesuai.
 *
 * Penggunaan di route:
 *   ->middleware('role:hr')        → redirect ke /hr/login jika gagal
 *   ->middleware('role:applicant') → redirect ke /login jika gagal
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        // Jika belum login sama sekali
        if (!Auth::check()) {
            $loginRoute = ($role === 'hr' || $role === 'hr_master') ? '/hr/login' : '/login';
            return redirect($loginRoute);
        }

        $userRole = Auth::user()->role;
        $allowed = false;

        if ($role === 'hr') {
            $allowed = ($userRole === 'hr' || $userRole === 'hr_master');
        } else {
            $allowed = ($userRole === $role);
        }

        // Sudah login tapi role-nya salah
        if (!$allowed) {
            // Arahkan user ke dashboard yang sesuai dengan role-nya sendiri
            if ($userRole === 'hr' || $userRole === 'hr_master') {
                return redirect('/hr/dashboard');
            }
            // Pelamar yang nyasar ke halaman HR → kembali ke dashboard pelamar
            return redirect('/pelamar/dashboard');
        }

        return $next($request);
    }
}
