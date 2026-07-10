<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ApplicantProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user()->load('profile');

        return view('pelamar.profil', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'nik' => ['nullable', 'digits:16'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'marital_status' => ['nullable', Rule::in(['single', 'married', 'divorced'])],
            'latest_education' => ['nullable', Rule::in(['sma', 'd3', 's1', 's2', 's3'])],
            'school_name' => ['nullable', 'string', 'max:150'],
            'education_completed_at' => ['nullable', 'date_format:Y-m'],
            'gpa' => ['nullable', 'string', 'max:20'],
            'ktp_province' => ['nullable', 'string', 'max:100'],
            'ktp_city' => ['nullable', 'string', 'max:100'],
            'ktp_district' => ['nullable', 'string', 'max:100'],
            'ktp_subdistrict' => ['nullable', 'string', 'max:100'],
            'ktp_address' => ['nullable', 'string', 'max:255'],
            'dom_province' => ['nullable', 'string', 'max:100'],
            'dom_city' => ['nullable', 'string', 'max:100'],
            'dom_district' => ['nullable', 'string', 'max:100'],
            'dom_subdistrict' => ['nullable', 'string', 'max:100'],
            'dom_address' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        try {
            DB::transaction(function () use ($request, $user, $validated): void {
                $user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                ]);

                $profileData = collect($validated)
                    ->except(['name', 'email', 'phone', 'avatar'])
                    ->toArray();

                $profileData['address'] = $validated['dom_address'] ?? $validated['ktp_address'] ?? null;
                $profileData['city'] = $validated['dom_city'] ?? $validated['ktp_city'] ?? null;
                $profileData['province'] = $validated['dom_province'] ?? $validated['ktp_province'] ?? null;
                $profileData['updated_at'] = now();

                $profile = $user->profile()->firstOrCreate(['user_id' => $user->id]);

                if ($request->hasFile('avatar')) {
                    if ($profile->avatar_url) {
                        Storage::disk('public')->delete($profile->avatar_url);
                    }

                    $profileData['avatar_url'] = $request->file('avatar')->store('avatars', 'public');
                }

                $profile->fill($profileData)->save();
            });
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), 'Batas usia minimal')) {
                return back()
                    ->withInput()
                    ->withErrors(['birth_date' => 'Database Constraint: The minimum age for registration is 17 years.']);
            }
            throw $e;
        }

        return back()->with('success', 'Profile saved successfully.');
    }

    public function destroyAvatar(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile;

        if ($profile && $profile->avatar_url) {
            Storage::disk('public')->delete($profile->avatar_url);
            $profile->forceFill([
                'avatar_url' => null,
                'updated_at' => now(),
            ])->save();
        }

        return back()->with('success', 'Profile photo deleted successfully.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile;

        if ($profile) {
            if ($profile->avatar_url) {
                Storage::disk('public')->delete($profile->avatar_url);
            }

            $profile->update([
                'nik' => null,
                'address' => null,
                'city' => null,
                'province' => null,
                'birth_place' => null,
                'birth_date' => null,
                'gender' => null,
                'marital_status' => null,
                'latest_education' => null,
                'school_name' => null,
                'education_completed_at' => null,
                'gpa' => null,
                'ktp_province' => null,
                'ktp_city' => null,
                'ktp_district' => null,
                'ktp_subdistrict' => null,
                'ktp_address' => null,
                'dom_province' => null,
                'dom_city' => null,
                'dom_district' => null,
                'dom_subdistrict' => null,
                'dom_address' => null,
                'avatar_url' => null,
                'portfolio_url' => null,
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Profile data deleted successfully. The login account remains active.');
    }
}
