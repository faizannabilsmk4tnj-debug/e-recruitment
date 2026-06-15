<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function loginApplicant(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan'
            ]);
        }

        if ($user->role !== 'applicant') {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak terdaftar sebagai pelamar'
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'role' => $user->role
        ]);
    }

    public function loginHr(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan'
            ]);
        }

        if ($user->role !== 'hr') {
            return response()->json([
                'success' => false,
                'message' => 'Akun ini bukan akun HR'
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ]);
        }

        $remember = $request->input('remember', false);
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'role' => $user->role
        ]);
    }

    public function register(Request $request)
    {
        User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'applicant'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();

        // Selalu kembalikan success agar email tidak bisa di-enumerate
        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'Jika email terdaftar, link reset akan dikirim.',
            ]);
        }

        // Hapus token lama milik user ini
        DB::table('password_reset_tokens')->where('user_id', $user->id)->delete();

        // Generate token dan simpan (berlaku 60 menit)
        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'user_id'    => $user->id,
            'token'      => hash('sha256', $token),
            'expires_at' => Carbon::now()->addMinutes(60),
            'is_used'    => false,
            'created_at' => Carbon::now(),
        ]);

        \Log::info("Password Reset Link for {$user->email}: " . url("/reset-password/{$token}"));

        return response()->json([
            'success' => true,
            'message' => 'Jika email terdaftar, link reset akan dikirim.',
        ]);
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak terdaftar.'
            ]);
        }

        $resetRecord = DB::table('password_reset_tokens')
            ->where('user_id', $user->id)
            ->where('is_used', false)
            ->first();

        if (!$resetRecord || !hash_equals($resetRecord->token, hash('sha256', $request->token))) {
            return response()->json([
                'success' => false,
                'message' => 'Token reset password tidak valid.'
            ]);
        }

        if (Carbon::parse($resetRecord->expires_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Token reset password telah kedaluwarsa.'
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('id', $resetRecord->id)
            ->update(['is_used' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Password Anda berhasil diperbarui.'
        ]);
    }

    public function logout(Request $request)
    {
        $redirectUrl = '/login';
        if (Auth::check() && Auth::user()->role === 'hr') {
            $redirectUrl = '/hr/login';
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect($redirectUrl);
    }
}
