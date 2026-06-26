<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        // 2. Detect if user is inactive (shows modal)
        if (Auth::check() && (Auth::user()->role === 'hr' || Auth::user()->role === 'hr_master') && !Auth::user()->is_active) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda telah dinonaktifkan oleh HR Master.',
                    'redirect' => route('hr.logout-deactivated')
                ], 403);
            }
            // Let non-AJAX web requests render the page so layouts.hr can display the alert with the page in the background before redirecting
        }

        if (!Auth::check()) {
            // Jika belum login, redirect ke login yang sesuai
            session()->flash('auth_warning', 'Anda harus login terlebih dahulu untuk mengakses halaman tersebut.');
            return redirect(($role === 'hr' || $role === 'hr_master') ? '/hr/login' : '/login');
        }

        $userRole = Auth::user()->role;
        $allowed = false;

        if ($role === 'hr') {
            $allowed = ($userRole === 'hr' || $userRole === 'hr_master');
        } else {
            $allowed = ($userRole === $role);
        }

        if (!$allowed) {
            // Jika role tidak sesuai
            session()->flash('auth_warning', 'Anda tidak memiliki hak akses untuk halaman tersebut.');
            return redirect(($userRole === 'hr' || $userRole === 'hr_master') ? '/hr/dashboard' : '/pelamar/dashboard');
        }

        return $next($request);
    }
}
