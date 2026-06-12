<?php

namespace App\Http\Controllers;

use App\Models\ApplicantSkill;
use App\Models\Education;
use App\Models\OrganizationExperience;
use App\Models\Portofolio;
use App\Models\UserProfile;
use App\Models\WorkExperience;

class ApplicantCvController extends Controller
{
    public function index()
    {
        $userId  = auth()->id();
        $user    = auth()->user();

        $profile = UserProfile::where('user_id', $userId)->first();
        $works   = WorkExperience::where('user_id', $userId)->orderByDesc('start_date')->get();
        $educations = Education::where('user_id', $userId)->orderByDesc('start_year')->get();
        $organizations = OrganizationExperience::where('user_id', $userId)->orderByDesc('start_date')->get();
        $skills  = ApplicantSkill::where('id_user', $userId)->get();
        $portos  = Portofolio::where('id_user', $userId)->get();

        // Inisial dari nama user (untuk avatar placeholder)
        $initials = collect(explode(' ', $user->name))
            ->take(2)
            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
            ->implode('');

        // Data ringkas untuk jsPDF di client-side (dikirim sebagai JSON)
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
            'organizations', 'skills', 'portos', 'initials', 'cvJson'
        ));
    }
}
