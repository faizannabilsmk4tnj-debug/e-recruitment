<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
                'message' => 'Email not found'
            ]);
        }

        if ($user->role !== 'applicant') {
            return response()->json([
                'success' => false,
                'message' => 'Email is not registered as an applicant'
            ]);
        }

        if (!Hash::check($request->password, $user->getAuthPassword())) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password'
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
                'message' => 'Email not found'
            ]);
        }

        if ($user->role !== 'hr' && $user->role !== 'hr_master') {
            return response()->json([
                'success' => false,
                'message' => 'This account is not an HR account'
            ]);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account has been deactivated by the HR Master.'
            ]);
        }

        if (!Hash::check($request->password, $user->getAuthPassword())) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password'
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
        $validator = \Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        User::create([
            'name'          => $request->nama,
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
            'role'          => 'applicant',
            'is_active'     => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful'
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
                'message' => 'If the email is registered, a reset link will be sent.',
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

        $resetUrl = url("/reset-password/{$token}");

        // Kirim email reset password
        try {
            Mail::to($user->email)->send(new PasswordResetMail($resetUrl, $user->name));
        } catch (\Exception $e) {
            \Log::error("Gagal kirim email reset password ke {$user->email}: " . $e->getMessage());
            // Tetap return success agar tidak bocorkan info user
        }

        return response()->json([
            'success' => true,
            'message' => 'If the email is registered, a reset link will be sent.',
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
                'message' => 'Email is not registered.'
            ]);
        }

        $resetRecord = DB::table('password_reset_tokens')
            ->where('user_id', $user->id)
            ->where('is_used', false)
            ->first();

        if (!$resetRecord || !hash_equals($resetRecord->token, hash('sha256', $request->token))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password reset token.'
            ]);
        }

        if (Carbon::parse($resetRecord->expires_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Password reset token has expired.'
            ]);
        }

        $user->password_hash = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('id', $resetRecord->id)
            ->update(['is_used' => true]);

        return response()->json([
            'success' => true,
            'role'    => $user->role,
            'message' => 'Your password has been successfully updated.'
        ]);
    }

    public function logout(Request $request)
    {
        $redirectUrl = '/login?loggedout=1';
        if (Auth::check() && (Auth::user()->role === 'hr' || Auth::user()->role === 'hr_master')) {
            $redirectUrl = '/hr/login?loggedout=1';
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect($redirectUrl);
    }
}
