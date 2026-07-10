<?php

namespace App\Http\Controllers;

use App\Models\ApplicantSkill;
use App\Models\Portofolio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicantLampiranController extends Controller
{
    // ===== INDEX =====
    public function index()
    {
        $skills = ApplicantSkill::where('user_id', auth()->id())
            ->orderBy('category')
            ->orderBy('skill_name')
            ->get();

        $portofolios = Portofolio::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pelamar.lampiran', compact('skills', 'portofolios'));
    }

    // ===== SKILL STORE =====
    public function skillStore(Request $request): RedirectResponse
    {
        $request->validate([
            'skill_name' => ['required', 'string', 'max:100'],
            'category'   => ['required', 'in:technical,soft,language'],
            'level'      => ['required', 'in:beginner,intermediate,expert'],
            'cert_name'  => ['nullable', 'string', 'max:200'],
            'cert_file'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $certPath = null;
        $certSize = null;
        if ($request->hasFile('cert_file')) {
            $file     = $request->file('cert_file');
            $filename = 'cert_' . auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $certPath = $file->storeAs('certificates/' . auth()->id(), $filename, 'public');
            $certSize = $file->getSize();
        }

        ApplicantSkill::create([
            'user_id'         => auth()->id(),
            'skill_name'      => $request->skill_name,
            'category'        => $request->category,
            'level'           => $request->level,
            'cert_name'       => $request->cert_name,
            'cert_file_path'  => $certPath,
            'cert_file_size'  => $certSize,
        ]);

        return redirect()->route('pelamar.lampiran')
            ->with('success', 'Skill added successfully.');
    }

    // ===== SKILL UPDATE =====
    public function skillUpdate(Request $request, ApplicantSkill $skill): JsonResponse
    {
        abort_unless($skill->user_id === auth()->id(), 403);

        $request->validate([
            'skill_name' => ['required', 'string', 'max:100'],
            'category'   => ['required', 'in:technical,soft,language'],
            'level'      => ['required', 'in:beginner,intermediate,expert'],
            'cert_name'  => ['nullable', 'string', 'max:200'],
            'cert_file'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $data = $request->only('skill_name', 'category', 'level', 'cert_name');

        if ($request->hasFile('cert_file')) {
            // Hapus file lama jika ada
            if ($skill->cert_file_path) {
                Storage::disk('public')->delete($skill->cert_file_path);
            }
            $file = $request->file('cert_file');
            $filename = 'cert_' . auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $data['cert_file_path'] = $file->storeAs('certificates/' . auth()->id(), $filename, 'public');
            $data['cert_file_size'] = $file->getSize();
        }

        $skill->update($data);

        return response()->json(['message' => 'OK']);
    }

    // ===== SKILL DESTROY =====
    public function skillDestroy(ApplicantSkill $skill): JsonResponse
    {
        abort_unless($skill->user_id === auth()->id(), 403);

        if ($skill->cert_file_path) {
            Storage::disk('public')->delete($skill->cert_file_path);
        }

        $skill->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // ===== PORTOFOLIO STORE =====
    public function portofolioStore(Request $request): RedirectResponse
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
            $filename = 'porto_' . auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $fileUrl  = $file->storeAs('portofolio/' . auth()->id(), $filename, 'public');
            $fileSize = $file->getSize();
        }

        Portofolio::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description,
            'type'        => $request->type,
            'link_url'    => $request->type === 'link' ? $request->link_url : null,
            'file_url'    => $fileUrl,
            'file_size'   => $fileSize,
        ]);

        return redirect()->route('pelamar.lampiran')
            ->with('success', 'Portfolio added successfully.')
            ->withFragment('tab-portofolio');
    }

    // ===== PORTOFOLIO UPDATE =====
    public function portofolioUpdate(Request $request, Portofolio $portofolio): JsonResponse
    {
        abort_unless($portofolio->user_id === auth()->id(), 403);

        $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:500'],
            'link_url'    => ['required_if:type,link', 'nullable', 'url', 'max:500'],
            'porto_file'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $data = $request->only('title', 'description');

        if ($portofolio->type === 'link') {
            $data['link_url'] = $request->link_url;
        } elseif ($portofolio->type === 'file') {
            if ($request->hasFile('porto_file')) {
                // Hapus file lama jika ada
                if ($portofolio->file_url) {
                    Storage::disk('public')->delete($portofolio->file_url);
                }
                $file = $request->file('porto_file');
                $filename = 'porto_' . auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $data['file_url'] = $file->storeAs('portofolio/' . auth()->id(), $filename, 'public');
                $data['file_size'] = $file->getSize();
            }
        }

        $portofolio->update($data);
        
        return response()->json([
            'message' => 'OK',
            'portfolio' => [
                'title' => $portofolio->title,
                'description' => $portofolio->description,
                'link_url' => $portofolio->link_url,
                'file_url' => $portofolio->file_url ? Storage::url($portofolio->file_url) : null,
                'file_size_formatted' => $portofolio->file_size ? number_format($portofolio->file_size/1048576, 1) . ' MB' : null
            ]
        ]);
    }

    // ===== PORTOFOLIO DESTROY =====
    public function portofolioDestroy(Portofolio $portofolio): JsonResponse
    {
        abort_unless($portofolio->user_id === auth()->id(), 403);

        if ($portofolio->file_url) {
            \Storage::disk('public')->delete($portofolio->file_url);
        }

        $portofolio->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
