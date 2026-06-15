<?php

namespace App\Http\Controllers;

use App\Models\ApplicantSkill;
use App\Models\CvTemplate;
use App\Models\Education;
use App\Models\OrganizationExperience;
use App\Models\Portofolio;
use App\Models\UserProfile;
use App\Models\WorkExperience;
use Illuminate\Http\Response;

class ApplicantCvController extends Controller
{
    public function index()
    {
        $userId  = auth()->id();
        $user    = auth()->user();

        $profile       = UserProfile::where('user_id', $userId)->first();
        $works         = WorkExperience::where('user_id', $userId)->orderByDesc('start_date')->get();
        $educations    = Education::where('user_id', $userId)->orderByDesc('start_year')->get();
        $organizations = OrganizationExperience::where('user_id', $userId)->orderByDesc('start_date')->get();
        $skills        = ApplicantSkill::where('id_user', $userId)->get();
        $portos        = Portofolio::where('id_user', $userId)->get();

        // Hanya template yang sudah di-publish oleh HR yang tampil ke pelamar
        $templates = CvTemplate::where('status', 'published')
            ->orderByDesc('is_default')
            ->orderByDesc('updated_at')
            ->get();

        // Inisial dari nama user (untuk avatar placeholder)
        $initials = collect(explode(' ', $user->name))
            ->take(2)
            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
            ->implode('');

        // Data ringkas untuk PDF (jika masih digunakan)
        $cvJson = [
            'name'     => $user->name,
            'email'    => $user->email,
            'initials' => $initials,
            'bio'      => optional($profile)->bio ?? '',
            'city'     => optional($profile)->city ?? '',
            'province' => optional($profile)->province ?? '',
            'linkedin' => optional($profile)->linkedin_url ?? '',
            'works'    => $works->map(function ($w) {
                return [
                    'pos'  => $w->position,
                    'co'   => $w->company_name,
                    's'    => $w->start_date->format('Y'),
                    'e'    => $w->is_current ? 'Sekarang' : ($w->end_date ? $w->end_date->format('Y') : ''),
                    'desc' => $w->description ?? '',
                ];
            })->values()->all(),
            'educs'    => $educations->map(function ($e) {
                return [
                    'deg'  => $e->degree,
                    'maj'  => $e->major,
                    'inst' => $e->institution,
                    's'    => $e->start_year,
                    'e'    => $e->end_year,
                    'gpa'  => $e->gpa ?? '',
                ];
            })->values()->all(),
            'orgs'     => $organizations->map(function ($o) {
                return [
                    'pos' => $o->position,
                    'org' => $o->organization_name,
                    's'   => $o->start_date->format('Y'),
                    'e'   => $o->end_date ? $o->end_date->format('Y') : 'Sekarang',
                ];
            })->values()->all(),
            'skills'   => $skills->map(function ($s) {
                return [
                    'name' => $s->skill_name,
                    'lvl'  => $s->level ?? '',
                    'cat'  => $s->category ?? '',
                    'cert' => $s->cert_name ?? '',
                ];
            })->values()->all(),
        ];

        return view('pelamar.cv', compact(
            'user', 'profile', 'works', 'educations',
            'organizations', 'skills', 'portos', 'initials', 'cvJson', 'templates'
        ));
    }

    /**
     * Generate CV preview: inject applicant's real data into a template's blocks.
     * Returns raw HTML for AJAX consumption.
     */
    public function generate(CvTemplate $template): Response
    {
        $userId  = auth()->id();
        $user    = auth()->user();

        $profile       = UserProfile::where('user_id', $userId)->first();
        $works         = WorkExperience::where('user_id', $userId)->orderByDesc('start_date')->get();
        $educations    = Education::where('user_id', $userId)->orderByDesc('start_year')->get();
        $organizations = OrganizationExperience::where('user_id', $userId)->orderByDesc('start_date')->get();
        $skills        = ApplicantSkill::where('id_user', $userId)->get();

        $templateHtml = $template->content_html ?? '';

        // Ekstrak data-type dari tiap blok template untuk mengetahui urutan section
        preg_match_all('/data-type="([^"]+)"/', $templateHtml, $matches);
        $blockTypes = $matches[1] ?? [];

        // Warna aksen: ambil dari template jika ada, fallback ke hijau default
        $accentColor = '#0f3c20';

        // Inisial
        $initials = collect(explode(' ', $user->name))
            ->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('');

        // Nama pelamar
        $name = e($user->name);

        // Posisi dari pengalaman kerja terbaru
        $latestJob = $works->first();
        $position  = $latestJob ? e($latestJob->position) : '';

        // Kontak
        $email    = e($user->email);
        $phone    = e($user->phone ?? (optional($profile)->phone ?? ''));
        $city     = e(optional($profile)->city ?? '');
        $province = e(optional($profile)->province ?? '');
        $linkedin = e(optional($profile)->linkedin_url ?? '');
        $bio      = e(optional($profile)->bio ?? '');

        $blocksHtml = '';

        if (empty($blockTypes)) {
            // Template kosong: tampilkan semua section default
            $blockTypes = ['header', 'contact', 'summary', 'exp', 'edu', 'skills'];
        }

        foreach ($blockTypes as $type) {
            $blocksHtml .= $this->renderBlockWithData(
                $type, $accentColor,
                $name, $initials, $position,
                $email, $phone, $city, $province, $linkedin, $bio,
                $works, $educations, $organizations, $skills
            );
        }

        // Bungkus dengan page wrapper yang sama seperti editor
        $html = '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8">
<title>CV — ' . $name . '</title>
<style>
*{box-sizing:border-box}
body{margin:0;background:#cbd5e1;display:flex;flex-direction:column;align-items:center;
     padding:0;font-family:\'Segoe UI\',sans-serif}
.page{width:595px;background:#fff;min-height:842px;box-shadow:0 2px 16px rgba(0,0,0,.15)}
.blk{position:relative}
@media print{
  body{background:#fff;padding:0}
  .page{box-shadow:none;width:100%}
}
</style>
</head><body>
<div class="page">
' . $blocksHtml . '
</div>
</body></html>';

        return response($html, 200, ['Content-Type' => 'text/html; charset=utf-8']);
    }

    /**
     * Render satu block CV dengan data nyata pelamar berdasarkan data-type.
     */
    private function renderBlockWithData(
        string $type, string $accent,
        string $name, string $initials, string $position,
        string $email, string $phone, string $city, string $province, string $linkedin, string $bio,
        $works, $educations, $organizations, $skills
    ): string {
        switch ($type) {
            case 'header':
                return '<div class="blk" data-type="header">
                    <div style="display:flex;align-items:center;gap:16px;padding:20px 28px">
                        <div style="width:64px;height:64px;border-radius:50%;background:' . $accent . ';flex-shrink:0;
                             display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800;color:#fff">
                            ' . $initials . '
                        </div>
                        <div>
                            <div style="font-size:20px;font-weight:800;color:#111">' . $name . '</div>
                            ' . ($position ? '<div style="font-size:12px;font-weight:600;margin-top:3px;color:' . $accent . '">' . $position . '</div>' : '') . '
                        </div>
                    </div>
                </div>';

            case 'contact':
                $parts = [];
                if ($email)    $parts[] = '&#9993; ' . $email;
                if ($phone)    $parts[] = '&#128222; ' . $phone;
                if ($city)     $parts[] = '&#128205; ' . $city . ($province ? ', ' . $province : '');
                if ($linkedin) $parts[] = '&#128279; ' . $linkedin;
                $contactHtml = implode('&nbsp;&nbsp;•&nbsp;&nbsp;', $parts) ?: '<span style="color:#9ca3af">Belum ada kontak</span>';
                return '<div class="blk" data-type="contact">
                    <div style="padding:10px 28px;background:#f9fafb;font-size:11px;color:#374151;
                         display:flex;flex-wrap:wrap;gap:6px 20px">
                        ' . implode('', array_map(fn($p) => '<span>' . $p . '</span>', $parts)) . '
                    </div>
                </div>';

            case 'summary':
                if (!$bio) return '';
                return '<div class="blk" data-type="summary">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:8px">Ringkasan Profil</div>
                        <p style="font-size:11px;line-height:1.7;color:#374151;margin:0;
                           border-left:3px solid ' . $accent . ';padding-left:10px">' . $bio . '</p>
                    </div>
                </div>';

            case 'exp':
                $inner = '';
                if ($works->count()) {
                    foreach ($works as $w) {
                        $s   = $w->start_date->format('M Y');
                        $end = $w->is_current ? 'Sekarang' : ($w->end_date ? $w->end_date->format('M Y') : '');
                        $inner .= '<div style="margin-bottom:12px">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                                <div>
                                    <div style="font-size:12px;font-weight:700;color:#111">' . e($w->position) . '</div>
                                    <div style="font-size:11px;color:#6b7280">' . e($w->company_name) . '</div>
                                </div>
                                <div style="font-size:10px;color:#9ca3af;white-space:nowrap">' . $s . ' &ndash; ' . $end . '</div>
                            </div>
                            ' . ($w->description ? '<p style="font-size:10px;color:#374151;margin:4px 0 0 0;line-height:1.5">' . e($w->description) . '</p>' : '') . '
                        </div>';
                    }
                } else {
                    $inner = '<p style="font-size:11px;color:#9ca3af">Belum ada pengalaman kerja.</p>';
                }
                return '<div class="blk" data-type="exp">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:10px">Pengalaman Kerja</div>
                        ' . $inner . '
                    </div>
                </div>';

            case 'edu':
                $inner = '';
                if ($educations->count()) {
                    foreach ($educations as $edu) {
                        $inner .= '<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px">
                            <div>
                                <div style="font-size:12px;font-weight:700;color:#111">' . e($edu->degree) . ' — ' . e($edu->major) . '</div>
                                <div style="font-size:11px;color:#6b7280">' . e($edu->institution) . '</div>
                                ' . ($edu->gpa ? '<div style="font-size:10px;color:#9ca3af">GPA: ' . $edu->gpa . '</div>' : '') . '
                            </div>
                            <div style="font-size:10px;color:#9ca3af;white-space:nowrap">' . $edu->start_year . ' &ndash; ' . $edu->end_year . '</div>
                        </div>';
                    }
                } else {
                    $inner = '<p style="font-size:11px;color:#9ca3af">Belum ada data pendidikan.</p>';
                }
                return '<div class="blk" data-type="edu">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:10px">Pendidikan</div>
                        ' . $inner . '
                    </div>
                </div>';

            case 'org':
            case 'organisasi':
                if ($organizations->isEmpty()) return '';
                $inner = '';
                foreach ($organizations as $org) {
                    $e   = $org->end_date ? $org->end_date->format('Y') : 'Sekarang';
                    $inner .= '<div style="margin-bottom:8px">
                        <div style="font-size:12px;font-weight:700;color:#111">' . e($org->position) . '</div>
                        <div style="font-size:11px;color:#6b7280">' . e($org->organization_name) . ' &bull; ' . $org->start_date->format('Y') . '&ndash;' . $e . '</div>
                    </div>';
                }
                return '<div class="blk" data-type="org">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:10px">Organisasi</div>
                        ' . $inner . '
                    </div>
                </div>';

            case 'skills':
                $inner = '';
                if ($skills->count()) {
                    foreach ($skills as $s) {
                        $inner .= '<span style="background:#f0fdf4;color:' . $accent . ';font-size:10px;font-weight:600;
                                   padding:2px 9px;border-radius:20px;border:1px solid #bbf7d0;margin:2px">'
                                 . e($s->skill_name) . '</span>';
                    }
                } else {
                    $inner = '<span style="font-size:11px;color:#9ca3af">Belum ada keahlian.</span>';
                }
                return '<div class="blk" data-type="skills">
                    <div style="padding:16px 28px">
                        <div style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;
                             color:' . $accent . ';margin-bottom:8px">Keahlian</div>
                        <div style="display:flex;flex-wrap:wrap;gap:4px">' . $inner . '</div>
                    </div>
                </div>';

            case 'div':
                return '<div class="blk" data-type="div">
                    <div style="padding:4px 0">
                        <hr style="border:none;border-top:1px solid #e5e7eb;margin:0 28px">
                    </div>
                </div>';

            default:
                return '';
        }
    }
}
