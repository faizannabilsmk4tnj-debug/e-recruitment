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
        if (!Auth::check()) {
            // Jika belum login, redirect ke login yang sesuai
            session()->flash('auth_warning', 'Anda harus login terlebih dahulu untuk mengakses halaman tersebut.');
            return redirect($role === 'hr' ? '/hr/login' : '/login');
        }

        if (Auth::user()->role !== $role) {
            // Jika role tidak sesuai
            session()->flash('auth_warning', 'Anda tidak memiliki hak akses untuk halaman tersebut.');
            return redirect(Auth::user()->role === 'hr' ? '/hr/dashboard' : '/pelamar/dashboard');
        }

        return $next($request);
    }
}
