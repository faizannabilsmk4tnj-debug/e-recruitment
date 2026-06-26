<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    /**
     * Tampilkan daftar anggota tim HR.
     */
    public function index()
    {
        $members = User::whereIn('role', ['hr', 'hr_master'])
            ->orderBy('id', 'asc')
            ->get();

        $totalCount = $members->count();
        $masterCount = $members->where('role', 'hr_master')->count();
        $staffCount = $members->where('role', 'hr')->count();

        return view('hr.tim', compact('members', 'totalCount', 'masterCount', 'staffCount'));
    }

    /**
     * Tambahkan anggota staf HR baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'hr',
            'password_hash' => Hash::make($request->password),
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member added successfully.',
            'member' => $user
        ]);
    }

    /**
     * Edit data staf HR.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password_hash'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Member updated successfully.',
            'member' => $user
        ]);
    }

    /**
     * Hapus anggota staf HR.
     */
    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot remove yourself.'
            ], 400);
        }

        $user = User::findOrFail($id);
        \Illuminate\Support\Facades\Cache::put("deleted_user_{$id}", true, now()->addHours(24));
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member removed successfully.'
        ]);
    }

    /**
     * Aktifkan / nonaktifkan anggota staf HR.
     */
    public function toggleStatus(Request $request, $id)
    {
        if (Auth::id() == $id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot change your own active status.'
            ], 400);
        }

        $user = User::findOrFail($id);
        $user->is_active = $request->boolean('is_active');
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Member status updated successfully.',
            'is_active' => $user->is_active
        ]);
    }
}
