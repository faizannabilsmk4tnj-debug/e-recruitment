<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicantCertificateController extends Controller
{
    /**
     * Upload satu atau beberapa sertifikat.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'files'   => ['required', 'array', 'max:10'],
            'files.*' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        foreach ($request->file('files') as $file) {
            $path = $file->store('certificates/' . auth()->id(), 'public');

            Certificate::create([
                'user_id'   => auth()->id(),
                'title'     => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_ext'  => strtoupper($file->getClientOriginalExtension()),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()
            ->route('pelamar.lampiran')
            ->with('success', 'Certificate berhasil diunggah.');
    }

    /**
     * Update judul sertifikat via AJAX.
     */
    public function update(Request $request, Certificate $certificate): JsonResponse
    {
        abort_unless($certificate->user_id === auth()->id(), 403);

        $request->validate(['title' => ['required', 'string', 'max:200']]);

        $certificate->update(['title' => $request->title]);

        return response()->json(['message' => 'OK']);
    }

    /**
     * Hapus sertifikat.
     */
    public function destroy(Certificate $certificate): JsonResponse
    {
        abort_unless($certificate->user_id === auth()->id(), 403);

        Storage::disk('public')->delete($certificate->file_path);
        $certificate->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
