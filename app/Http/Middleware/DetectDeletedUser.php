<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class DetectDeletedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = null;
        foreach (session()->all() as $key => $value) {
            if (str_starts_with($key, 'login_web_')) {
                $userId = $value;
                break;
            }
        }

        if ($userId && Cache::has("deleted_user_{$userId}")) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'is_deleted' => true,
                    'message' => 'Akun HR Anda telah dihapus oleh HR Master.',
                    'redirect' => route('hr.logout-deleted')
                ], 403);
            }

            return redirect('/hr/login')->with('auth_warning', 'Akun HR Anda telah dihapus oleh HR Master.');
        }

        return $next($request);
    }
}
