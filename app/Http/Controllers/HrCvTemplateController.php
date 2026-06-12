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
