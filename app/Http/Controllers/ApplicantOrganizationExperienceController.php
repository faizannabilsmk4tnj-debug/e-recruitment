<?php

namespace App\Http\Controllers;

use App\Models\OrganizationExperience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicantOrganizationExperienceController extends Controller
{
    public function index(): View
    {
        $organizationExperiences = OrganizationExperience::query()
            ->where('user_id', auth()->id())
            ->orderByDesc('start_date')
            ->orderByDesc('created_at')
            ->get();

        return view('pelamar.organisasi', compact('organizationExperiences'));
    }

    public function create(): View
    {
        return view('pelamar.tambah-organisasi', [
            'organizationExperience' => new OrganizationExperience(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        OrganizationExperience::create($this->validatedData($request) + [
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('pelamar.organisasi.index')
            ->with('success', 'Pengalaman organisasi berhasil ditambahkan.');
    }

    public function edit(OrganizationExperience $organizationExperience): View
    {
        $this->ensureOwner($organizationExperience);

        return view('pelamar.tambah-organisasi', compact('organizationExperience'));
    }

    public function update(Request $request, OrganizationExperience $organizationExperience): RedirectResponse
    {
        $this->ensureOwner($organizationExperience);

        $organizationExperience->update($this->validatedData($request));

        return redirect()
            ->route('pelamar.organisasi.index')
            ->with('success', 'Pengalaman organisasi berhasil diperbarui.');
    }

    public function destroy(OrganizationExperience $organizationExperience): RedirectResponse
    {
        $this->ensureOwner($organizationExperience);

        $organizationExperience->delete();

        return redirect()
            ->route('pelamar.organisasi.index')
            ->with('success', 'Pengalaman organisasi berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'position' => ['required', 'string', 'max:150'],
            'organization_name' => ['required', 'string', 'max:150'],
            'start_date' => ['nullable', 'date', 'required_with:end_date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string'],
        ]);
    }

    private function ensureOwner(OrganizationExperience $organizationExperience): void
    {
        abort_unless($organizationExperience->user_id === auth()->id(), 404);
    }
}
