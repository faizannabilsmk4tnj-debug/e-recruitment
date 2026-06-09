<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicantPortofolioController extends Controller
{
    /**
     * Simpan portofolio baru (link atau file).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:500'],
            'type'        => ['required', 'in:link,file'],
            'link_url'    => ['required_if:type,link', 'nullable', 'url', 'max:500'],
            'porto_file'  => ['required_if:type,file', 'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $fileUrl  = null;
        $fileSize = null;

        if ($request->type === 'file' && $request->hasFile('porto_file')) {
            $file     = $request->file('porto_file');
            $fileUrl  = $file->store('portofolio/' . auth()->id(), 'public');
            $fileSize = $file->getSize();
        }

        Portofolio::create([
            'id_user'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description,
            'type'        => $request->type,
            'link_url'    => $request->type === 'link' ? $request->link_url : null,
            'file_url'    => $fileUrl,
            'file_size'   => $fileSize,
        ]);

        return redirect()
            ->route('pelamar.lampiran')
            ->with('success', 'Portofolio berhasil ditambahkan.')
            ->withFragment('tab-portofolio');
    }

    /**
     * Update portofolio via AJAX.
     */
    public function update(Request $request, Portofolio $portofolio): JsonResponse
    {
        abort_unless($portofolio->id_user === auth()->id(), 403);

        $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:500'],
            'link_url'    => ['nullable', 'url', 'max:500'],
        ]);

        $portofolio->update($request->only('title', 'description', 'link_url'));

        return response()->json(['message' => 'OK']);
    }

    /**
     * Hapus portofolio.
     */
    public function destroy(Portofolio $portofolio): JsonResponse
    {
        abort_unless($portofolio->id_user === auth()->id(), 403);

        if ($portofolio->file_url) {
            Storage::disk('public')->delete($portofolio->file_url);
        }

        $portofolio->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
