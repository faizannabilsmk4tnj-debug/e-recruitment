<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ApplicantEducationController extends Controller
{
    public function index(Request $request): View
    {
        return view('pelamar.pendidikan', [
            'educations' => $request->user()
                ->educations()
                ->latest('start_year')
                ->latest('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('pelamar.tambah-pendidikan', [
            'education' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('diploma_file')) {
            $data['diploma_file'] = $request->file('diploma_file')->store('education-documents', 'public');
        }

        if ($request->hasFile('skhu_file')) {
            $data['skhu_file'] = $request->file('skhu_file')->store('education-documents', 'public');
        }

        Education::create($data);

        return redirect('/pelamar/pendidikan')->with('success', 'Education history added successfully.');
    }

    public function edit(Request $request, Education $education): View
    {
        abort_unless($education->user_id === $request->user()->id, 403);

        return view('pelamar.tambah-pendidikan', [
            'education' => $education,
        ]);
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        abort_unless($education->user_id === $request->user()->id, 403);

        $data = $this->validatedData($request);

        if ($request->hasFile('diploma_file')) {
            $this->deleteStoredFile($education->diploma_file);
            $data['diploma_file'] = $request->file('diploma_file')->store('education-documents', 'public');
        }

        if ($request->hasFile('skhu_file')) {
            $this->deleteStoredFile($education->skhu_file);
            $data['skhu_file'] = $request->file('skhu_file')->store('education-documents', 'public');
        }

        $education->update($data);

        return redirect('/pelamar/pendidikan')->with('success', 'Education history updated successfully.');
    }

    public function destroy(Request $request, Education $education): RedirectResponse
    {
        abort_unless($education->user_id === $request->user()->id, 403);

        $this->deleteStoredFile($education->diploma_file);
        $this->deleteStoredFile($education->skhu_file);
        $education->delete();

        return back()->with('success', 'Education history deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'institution' => ['required', 'string', 'max:200'],
            'degree' => ['required', Rule::in(['SMA', 'D3', 'S1', 'S2', 'S3'])],
            'major' => ['nullable', 'string', 'max:150'],
            'certificate_number' => ['nullable', 'string', 'max:100'],
            'gpa' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'start_year' => ['required', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'end_year' => ['nullable', 'integer', 'min:1950', 'max:' . (date('Y') + 1), 'gte:start_year'],
            'diploma_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'skhu_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);
    }

    private function deleteStoredFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
