<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Carbon;


class AuthController extends Controller
{
    // =========================================================
    //  LOGIN
    // =========================================================

    /**
     * Proses login — validasi input, cek kredensial, redirect berdasarkan role.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Tentukan URL redirect berdasarkan role
            $redirectUrl = Auth::user()->role === 'hr'
                ? '/hr/dashboard'
                : '/pelamar/dashboard';

            // Kembalikan JSON agar fetch() bisa handle redirect sendiri
            return response()->json([
                'success'      => true,
                'redirect_url' => $redirectUrl,
            ]);
        }

        // Kredensial salah — kembalikan JSON error agar ditampilkan di UI
        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah. Periksa kembali kredensial Anda.',
        ], 401);
    }

    // =========================================================
    //  HR LOGIN (portal terpisah, hanya untuk role=hr)
    // =========================================================

    /**
     * Proses login khusus HR.
     * Jika email/password valid tapi role-nya bukan HR, tetap ditolak.
     */
    public function hrLogin(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            // Cek role — hanya HR yang boleh masuk portal ini
            if (Auth::user()->role !== 'hr') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Akun ini bukan akun HR. Gunakan halaman login pelamar.',
                ], 403);
            }

            $request->session()->regenerate();

            return response()->json([
                'success'      => true,
                'redirect_url' => '/hr/dashboard',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.',
        ], 401);
    }

    // =========================================================
    //  REGISTER
    // =========================================================

    /**
     * Proses register — hanya untuk pelamar (applicant).
     * HR tidak bisa daftar sendiri, harus dibuat manual oleh admin.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:100'],
            'email'                 => ['required', 'email', 'max:150', 'unique:users,email'],
            'password'              => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role'      => 'applicant',
            'is_active' => true,
        ]);

        // Arahkan ke halaman login, bukan auto-login
        // User perlu login sendiri menggunakan akun yang baru dibuat
        return response()->json([
            'success'      => true,
            'redirect_url' => '/login?registered=1',
        ]);
    }

    // =========================================================
    //  LOGOUT
    // =========================================================

    /**
     * Proses logout — hapus session, redirect ke halaman login.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // =========================================================
    //  FORGOT PASSWORD
    // =========================================================

    /**
     * Proses permintaan reset password.
     * Generate token unik, simpan ke DB, kirim email berisi link.
     */
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

        // Kirim email berisi link reset
        $resetUrl = url('/reset-password/' . $token);
        Mail::raw(
            "Halo {$user->name},\n\n"
            . "Kami menerima permintaan reset password untuk akun Anda.\n"
            . "Klik link berikut untuk mengatur password baru (berlaku 60 menit):\n\n"
            . $resetUrl . "\n\n"
            . "Jika Anda tidak meminta reset ini, abaikan email ini.\n\n"
            . "Salam,\nTim PT Ecogreen Oleochemicals",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Reset Password — PT Ecogreen Oleochemicals');
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'Link reset password telah dikirim ke email Anda.',
        ]);
    }

    // =========================================================
    //  RESET PASSWORD
    // =========================================================

    /**
     * Tampilkan form reset password berdasarkan token dari URL.
     */
    public function showResetForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Proses reset password — validasi token, update password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => ['required'],
            'password'              => ['required', 'confirmed', Password::min(8)],
        ]);

        $hashedToken = hash('sha256', $request->token);

        $record = DB::table('password_reset_tokens')
            ->where('token', $hashedToken)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Link reset tidak valid atau sudah kadaluarsa. Minta link baru.',
            ], 422);
        }

        // Update password user
        $user = User::findOrFail($record->user_id);
        $user->password = $request->password; // auto-hash via cast
        $user->save();

        // Tandai token sebagai sudah dipakai
        DB::table('password_reset_tokens')
            ->where('token', $hashedToken)
            ->update(['is_used' => true]);

        // Redirect ke login dengan notif sukses
        return response()->json([
            'success'      => true,
            'redirect_url' => '/login?password_reset=1',
        ]);
    }
}
