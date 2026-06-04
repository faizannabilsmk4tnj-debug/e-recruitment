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

    if (!Hash::check($request->password, $user->password_hash)) {
        return response()->json([
            'success' => false,
            'message' => 'Password salah'
        ]);
    }

    Auth::login($user);

    return response()->json([
        'success' => true,
        'role' => $user->role
    ]);
}
public function register(Request $request)
    {
        User::create([
            'name'          => $request->nama, // ← sesuaikan dengan nama field di form
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
            'role'          => 'applicant'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil'
        ]);
    }
}

