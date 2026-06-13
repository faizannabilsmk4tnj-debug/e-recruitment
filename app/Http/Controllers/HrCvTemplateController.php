<?php

namespace App\Http\Controllers;

use App\Models\CvTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HrCvTemplateController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'semua');
        $search = trim((string) $request->query('q', ''));

        $templates = CvTemplate::query()
            ->withCount('applicantCvs')
            ->when($status === 'published', fn ($query) => $query->where('status', 'published'))
            ->when($status === 'draft', fn ($query) => $query->where('status', 'draft'))
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderByDesc('is_default')
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();

        return view('hr.template-cv', [
            'templates' => $templates,
            'totalTemplates' => CvTemplate::count(),
            'publishedTemplates' => CvTemplate::where('status', 'published')->count(),
            'draftTemplates' => CvTemplate::where('status', 'draft')->count(),
            'activeStatus' => $status,
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:draft,published'],
            'content_html' => ['nullable', 'string'],
        ]);

        $template = CvTemplate::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'content_html' => $validated['content_html'] ?? null,
            'status' => $validated['status'],
            'is_active' => $validated['status'] === 'published',
            'is_default' => false,
        ]);

        return redirect()
            ->route('hr.template-cv.editor', $template)
            ->with('success', 'Template berhasil dibuat. Silakan edit layout.');
    }

    public function edit(CvTemplate $template): View
    {
        return view('hr.template-cv-editor', ['template' => $template]);
    }

    public function preview(CvTemplate $template): \Illuminate\Http\Response
    {
        $content = $template->content_html ?? '';

        $html = '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8">
<title>Preview: ' . e($template->name) . '</title>
<style>
body{margin:0;background:#cbd5e1;display:flex;flex-direction:column;align-items:center;
     padding:24px;font-family:\'Segoe UI\',sans-serif}
.page{width:595px;background:#fff;box-shadow:0 2px 16px rgba(0,0,0,.15);margin-bottom:24px}
[contenteditable]{outline:none;pointer-events:none}
.bh{display:none!important}
.blk{border:none!important}
.preview-bar{position:fixed;top:0;left:0;right:0;height:44px;background:#0f3c20;
             display:flex;align-items:center;padding:0 20px;gap:12px;z-index:100}
.preview-bar a{color:#86efac;font-size:12px;font-weight:600;text-decoration:none}
.preview-bar span{color:#fff;font-size:13px;font-weight:700;flex:1;text-align:center}
body{padding-top:68px}
</style></head><body>
<div class="preview-bar">
  <a href="javascript:history.back()">← Kembali</a>
  <span>Preview: ' . e($template->name) . '</span>
</div>';

        if ($content) {
            $html .= $content;
        } else {
            $html .= '<div style="text-align:center;padding:80px 40px;color:#9ca3af;">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 16px;display:block;opacity:.4">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p style="font-size:15px;font-weight:600;margin:0 0 8px">Template belum memiliki konten</p>
                <p style="font-size:13px;margin:0">Silakan buka editor dan simpan layout terlebih dahulu.</p>
            </div>';
        }

        $html .= '</body></html>';

        return response($html, 200, ['Content-Type' => 'text/html; charset=utf-8']);
    }

    public function create(): View
    {
        return view('hr.template-cv-editor', ['template' => null]);
    }

    public function update(Request $request, CvTemplate $template): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'content_html' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $template->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'content_html' => $validated['content_html'] ?? null,
            'status' => $validated['status'],
            'is_active' => $validated['status'] === 'published',
        ]);

        return redirect()
            ->route('hr.template-cv.editor', $template)
            ->with('success', $validated['status'] === 'published' ? 'Template berhasil dipublikasikan.' : 'Draft template berhasil disimpan.');
    }

    public function publish(CvTemplate $template): RedirectResponse
    {
        $template->update([
            'status' => 'published',
            'is_active' => true,
        ]);

        return back()->with('success', 'Template berhasil dipublikasikan.');
    }

    public function setDefault(CvTemplate $template): RedirectResponse
    {
        DB::transaction(function () use ($template): void {
            CvTemplate::query()->update(['is_default' => false]);

            $template->update([
                'status' => 'published',
                'is_active' => true,
                'is_default' => true,
            ]);
        });

        return back()->with('success', 'Template default berhasil diperbarui.');
    }

    public function destroy(CvTemplate $template): RedirectResponse
    {
        if ($template->applicantCvs()->exists()) {
            return back()->with('error', 'Template tidak bisa dihapus karena sudah digunakan pelamar.');
        }

        if ($template->is_default) {
            return back()->with('error', 'Template default tidak bisa dihapus. Pilih default lain terlebih dahulu.');
        }

        $template->delete();

        return redirect()
            ->route('hr.template-cv.index')
            ->with('success', 'Template berhasil dihapus.');
    }
}
