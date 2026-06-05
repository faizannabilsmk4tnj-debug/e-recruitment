<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

public function login(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Email tidak ditemukan'
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
