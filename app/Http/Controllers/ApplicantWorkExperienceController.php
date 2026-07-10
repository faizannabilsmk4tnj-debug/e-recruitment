<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicantWorkExperienceController extends Controller
{
    public function index(): View
    {
        $workExperiences = WorkExperience::query()
            ->where('user_id', auth()->id())
            ->orderByDesc('is_current')
            ->orderByDesc('start_date')
            ->get();

        return view('pelamar.pengalaman-kerja', compact('workExperiences'));
    }

    public function create(): View
    {
        return view('pelamar.tambah-pengalaman', [
            'workExperience' => new WorkExperience(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        WorkExperience::create($this->validatedData($request) + [
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('pelamar.pengalaman-kerja.index')
            ->with('success', 'Work experience added successfully.');
    }

    public function edit(WorkExperience $workExperience): View
    {
        $this->ensureOwner($workExperience);

        return view('pelamar.tambah-pengalaman', compact('workExperience'));
    }

    public function update(Request $request, WorkExperience $workExperience): RedirectResponse
    {
        $this->ensureOwner($workExperience);

        $workExperience->update($this->validatedData($request));

        return redirect()
            ->route('pelamar.pengalaman-kerja.index')
            ->with('success', 'Work experience updated successfully.');
    }

    public function destroy(WorkExperience $workExperience): RedirectResponse
    {
        $this->ensureOwner($workExperience);

        $workExperience->delete();

        return redirect()
            ->route('pelamar.pengalaman-kerja.index')
            ->with('success', 'Work experience deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'position' => ['required', 'string', 'max:150'],
            'company_name' => ['required', 'string', 'max:150'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date', 'required_without:is_current'],
            'is_current' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['is_current'] = $request->boolean('is_current');

        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        return $validated;
    }

    private function ensureOwner(WorkExperience $workExperience): void
    {
        abort_unless($workExperience->user_id === auth()->id(), 404);
    }
}
