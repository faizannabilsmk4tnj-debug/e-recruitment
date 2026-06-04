@extends('layouts.pelamar')

@section('title', 'Dashboard')
@section('nav-dashboard', 'active')

@section('css')
<style>
    .stat-card { position: relative; overflow: hidden; }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; border-radius: 4px 0 0 4px; }
    .stat-card.green::before { background: #15803d; }
    .stat-card.emerald::before { background: #059669; }
    .stat-card.red::before { background: #dc2626; }
    .stat-card.blue::before { background: #2563eb; }
    .saved-job:hover .saved-job-title { color: #15803d; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
    .animate-card { animation: fadeInUp 0.4s ease-out forwards; opacity: 0; }
    .animate-card:nth-child(1) { animation-delay: 0.05s; }
    .animate-card:nth-child(2) { animation-delay: 0.1s; }
    .animate-card:nth-child(3) { animation-delay: 0.15s; }
    .animate-card:nth-child(4) { animation-delay: 0.2s; }
</style>
@endsection

@section('content')

<!-- Greeting -->
<a href="/pelamar/profil" class="block relative rounded-xl mb-6 overflow-hidden cursor-pointer group border border-gray-200 shadow-sm hover:shadow-md transition-shadow" id="greeting-card">
    <!-- Background: white base -->
    <div class="absolute inset-0 bg-white"></div>
    <!-- Green fill based on percentage -->
    <div class="absolute inset-0 bg-gradient-to-r from-green-800 to-green-900 transition-all duration-1000 ease-out" id="progress-fill" style="width: 0%"></div>
    <!-- Content -->
    <div class="relative z-10 p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold" id="greeting-text">Hello, <span id="user-name">{{ Auth::user()->name }}</span>!</h1>
            <p class="mt-1 text-sm" id="greeting-sub">Welcome back. Here is a summary of your application activities.</p>
        </div>
        <div class="text-right flex items-center gap-4">
            <div>
                <p class="text-xs uppercase tracking-wider font-medium" id="progress-label">Complete Profile</p>
                <p class="text-3xl font-bold mt-0.5" id="progress-number">85%</p>
            </div>
            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" id="progress-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </div>
        </div>
    </div>
</a>

<!-- Stat Cards -->
<div class="grid grid-cols-4 gap-5 mb-8">
    <!-- Total Lamaran -->
    <div class="stat-card green animate-card bg-white rounded-xl border border-gray-200 p-5 cursor-pointer hover:shadow-lg hover:border-green-200 transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Applications</p>
                <p class="text-3xl font-bold text-gray-900" id="stat-total">12</p>
            </div>
            <div class="w-11 h-11 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/>
                </svg>
            </div>
        </div>
        <div class="flex items-center gap-1.5 mt-3 bg-green-50 rounded-md px-2 py-1 w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            <span class="text-xs font-semibold text-green-700">+2 this month</span>
        </div>
    </div>

    <!-- Aktif -->
    <div class="stat-card emerald animate-card bg-white rounded-xl border border-gray-200 p-5 cursor-pointer hover:shadow-lg hover:border-green-200 transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Active</p>
                <p class="text-3xl font-bold text-emerald-700" id="stat-aktif">4</p>
            </div>
            <div class="w-11 h-11 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-3">In review process</p>
    </div>

    <!-- Ditolak -->
    <div class="stat-card red animate-card bg-white rounded-xl border border-gray-200 p-5 cursor-pointer hover:shadow-lg hover:border-red-200 transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Rejected</p>
                <p class="text-3xl font-bold text-red-600" id="stat-ditolak">2</p>
            </div>
            <div class="w-11 h-11 bg-gradient-to-br from-red-50 to-red-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-3">Keep it up!</p>
    </div>

    <!-- Wawancara -->
    <div class="stat-card blue animate-card bg-white rounded-xl border border-gray-200 p-5 cursor-pointer hover:shadow-lg hover:border-blue-200 transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Interviews</p>
                <p class="text-3xl font-bold text-blue-600" id="stat-wawancara">3</p>
            </div>
            <div class="w-11 h-11 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-3">Prepare yourself</p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-3 gap-6">

    <!-- LEFT: Daftar Lamaran Terbaru -->
    <div class="col-span-2">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-green-700 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-900">Latest Applications</h2>
                </div>
                <a href="/pelamar/status-lamaran" class="text-sm font-semibold text-green-700 hover:text-green-600 flex items-center gap-1 transition-colors">
                    See All
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>

            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Position</th>
                        <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Date</th>
                        <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody id="lamaran-table">
                    <tr class="border-b border-gray-50 hover:bg-green-50/40 transition-colors cursor-pointer group">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Process Engineer</p>
                            <p class="text-xs text-gray-400">Plant Division - Batam</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">12 Okt 2023</td>
                        <td class="px-6 py-4"><span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-50 text-green-700 border border-green-200">Shortlisted</span></td>
                    </tr>
                    <tr class="border-b border-gray-50 hover:bg-green-50/40 transition-colors cursor-pointer group">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Quality Assurance Specialist</p>
                            <p class="text-xs text-gray-400">Laboratory - Medan</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">08 Okt 2023</td>
                        <td class="px-6 py-4"><span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200">Interview</span></td>
                    </tr>
                    <tr class="border-b border-gray-50 hover:bg-green-50/40 transition-colors cursor-pointer group">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Finance & Accounting Staff</p>
                            <p class="text-xs text-gray-400">Head Office - Jakarta</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">05 Okt 2023</td>
                        <td class="px-6 py-4"><span class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-50 text-gray-500 border border-gray-200">Applied</span></td>
                    </tr>
                    <tr class="border-b border-gray-50 hover:bg-green-50/40 transition-colors cursor-pointer group">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm text-gray-900 group-hover:text-green-800 transition-colors">HR Generalist</p>
                            <p class="text-xs text-gray-400">Head Office - Jakarta</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">30 Sep 2023</td>
                        <td class="px-6 py-4"><span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-50 text-red-600 border border-red-200">Rejected</span></td>
                    </tr>
                    <tr class="hover:bg-green-50/40 transition-colors cursor-pointer group">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Supply Chain Manager</p>
                            <p class="text-xs text-gray-400">Logistics - Batam</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">25 Sep 2023</td>
                        <td class="px-6 py-4"><span class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-50 text-gray-500 border border-gray-200">Applied</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- RIGHT: Lowongan Tersimpan + Notifikasi -->
    <div class="col-span-1 space-y-6">

        <!-- Lowongan Tersimpan -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 flex items-center justify-between border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-blue-500 rounded-full"></div>
                    <h3 class="font-bold text-gray-900 text-sm">Saved Vacancies</h3>
                </div>
                <a href="/#lowongan" class="text-xs font-semibold text-green-700 hover:text-green-600 transition-colors">See All</a>
            </div>
            <div class="divide-y divide-gray-50" id="saved-jobs">
                <div class="saved-job flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50 transition-colors cursor-pointer">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="saved-job-title font-semibold text-sm text-gray-900 truncate transition-colors">Maintenance Supervisor</p>
                        <p class="text-xs text-gray-400">Batam • 5 days ago</p>
                    </div>
                    <button class="text-gray-300 hover:text-yellow-500 transition-colors shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                    </button>
                </div>
                <div class="saved-job flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50 transition-colors cursor-pointer">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="saved-job-title font-semibold text-sm text-gray-900 truncate transition-colors">Chemical Lab Tech</p>
                        <p class="text-xs text-gray-400">Medan • 2 days ago</p>
                    </div>
                    <button class="text-gray-300 hover:text-yellow-500 transition-colors shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                    </button>
                </div>
                <div class="saved-job flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50 transition-colors cursor-pointer">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="saved-job-title font-semibold text-sm text-gray-900 truncate transition-colors">Talent Acquisition Lead</p>
                        <p class="text-xs text-gray-400">Jakarta • New</p>
                    </div>
                    <button class="text-gray-300 hover:text-yellow-500 transition-colors shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifikasi -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 flex items-center justify-between border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-amber-500 rounded-full"></div>
                    <h3 class="font-bold text-gray-900 text-sm">Notifications</h3>
                </div>
                <span class="text-xs font-bold text-white bg-green-600 px-2.5 py-0.5 rounded-full animate-pulse">3 New</span>
            </div>
            <div class="divide-y divide-gray-50" id="notifications">
                <div class="flex items-start gap-3 px-5 py-4 hover:bg-blue-50/30 transition-colors cursor-pointer">
                    <div class="w-2.5 h-2.5 bg-blue-500 rounded-full mt-1.5 shrink-0 ring-2 ring-blue-200"></div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900">Interview Schedule Confirmed</p>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Technical interview invitation for Process Engineer has been sent to your email.</p>
                        <p class="text-xs text-gray-400 mt-1.5 font-medium">1 hour ago</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 px-5 py-4 hover:bg-blue-50/30 transition-colors cursor-pointer">
                    <div class="w-2.5 h-2.5 bg-blue-500 rounded-full mt-1.5 shrink-0 ring-2 ring-blue-200"></div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900">Application Status Update</p>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Your application for the QA Specialist position has been updated to 'Shortlisted'.</p>
                        <p class="text-xs text-gray-400 mt-1.5 font-medium">Yesterday, 14:20</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 px-5 py-4 hover:bg-blue-50/30 transition-colors cursor-pointer">
                    <div class="w-2.5 h-2.5 bg-blue-500 rounded-full mt-1.5 shrink-0 ring-2 ring-blue-200"></div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900">Complete Your Profile</p>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Your TOEFL certificate is expiring soon. Please update your supporting documents.</p>
                        <p class="text-xs text-gray-400 mt-1.5 font-medium">2 days ago</p>
                    </div>
                </div>
            </div>
            <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/50">
                <a href="#" class="text-sm font-semibold text-green-700 hover:text-green-600 transition-colors flex items-center justify-center gap-1">
                    See All Notifications
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ========== ONBOARDING GUIDED TOUR ========== -->
<div id="tour-overlay" class="fixed inset-0 z-[70] hidden" style="pointer-events:none;">
    <!-- Dark backdrop with hole -->
    <svg id="tour-backdrop" class="absolute inset-0 w-full h-full" style="pointer-events:all;">
        <defs>
            <mask id="tour-mask">
                <rect width="100%" height="100%" fill="white"/>
                <rect id="tour-hole" rx="12" fill="black"/>
            </mask>
        </defs>
        <rect width="100%" height="100%" fill="rgba(0,0,0,0.6)" mask="url(#tour-mask)"/>
    </svg>

    <!-- Tooltip card -->
    <div id="tour-tooltip" class="absolute bg-white rounded-xl shadow-2xl border border-gray-200 w-80 p-5 transition-all duration-300" style="pointer-events:all;">
        <!-- Progress -->
        <div class="flex items-center justify-between mb-3">
            <span id="tour-step-label" class="text-[10px] font-bold text-green-700 uppercase tracking-widest"></span>
            <button id="tour-skip" class="text-[10px] text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-wider font-medium">Skip</button>
        </div>
        <div class="h-1 bg-gray-100 rounded-full mb-4">
            <div id="tour-progress" class="h-1 bg-green-600 rounded-full transition-all duration-500"></div>
        </div>
        <h3 id="tour-title" class="font-bold text-gray-900 mb-1.5"></h3>
        <p id="tour-desc" class="text-sm text-gray-500 leading-relaxed"></p>
        <!-- Nav -->
        <div class="flex items-center justify-between mt-5">
            <button id="tour-prev" class="text-sm text-gray-400 hover:text-gray-700 transition-colors flex items-center gap-1 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                Back
            </button>
            <div></div>
            <button id="tour-next" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition-colors flex items-center gap-1">
                Next
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/pelamar/dashboard.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (sessionStorage.getItem('tour-done')) return;

    const steps = [
        {
            target: '#greeting-card',
            title: 'Welcome!',
            desc: 'This is your Dashboard. The green bar shows your profile completion progress. Click to go directly to the Profile page and start filling in your data.',
            pos: 'bottom'
        },
        {
            target: '#sidebar-profil',
            title: '1. Complete Your Profile',
            desc: 'Start here! Fill in your personal data: name, ID number, phone, email, date of birth, address, and upload your profile photo.',
            pos: 'right'
        },
        {
            target: '#sidebar-pengalaman',
            title: '2. Work Experience',
            desc: 'Add your work history: position, company, industry, location, work period, and job description.',
            pos: 'right'
        },
        {
            target: '#sidebar-pendidikan',
            title: '3. Education',
            desc: 'Fill in your education history: school/university, major, GPA, and upload your diploma and certificate.',
            pos: 'right'
        },
        {
            target: '#sidebar-organisasi',
            title: '4. Organization Experience',
            desc: 'Add organization experience as an added value: position, organization name, and activity description.',
            pos: 'right'
        },
        {
            target: '#sidebar-lampiran',
            title: '5. Attachments & Certificates',
            desc: 'Upload supporting documents: training certificates, TOEFL/IELTS, portfolio, and other relevant documents.',
            pos: 'right'
        },
        {
            target: '#sidebar-cv',
            title: '6. Build Your CV',
            desc: 'Choose a professional CV template. Data from your profile is automatically filled in the CV. Just pick a design and download the PDF.',
            pos: 'right'
        },
        {
            target: '#sidebar-status',
            title: '7. Track Your Application Status',
            desc: 'After applying, track your application progress here. View the timeline from submitted to final decision.',
            pos: 'right'
        }
    ];

    const overlay = document.getElementById('tour-overlay');
    const hole = document.getElementById('tour-hole');
    const tooltip = document.getElementById('tour-tooltip');
    const titleEl = document.getElementById('tour-title');
    const descEl = document.getElementById('tour-desc');
    const labelEl = document.getElementById('tour-step-label');
    const progressEl = document.getElementById('tour-progress');
    const btnNext = document.getElementById('tour-next');
    const btnPrev = document.getElementById('tour-prev');
    const btnSkip = document.getElementById('tour-skip');
    let current = 0;
    const pad = 8;

    function showStep(i) {
        const step = steps[i];
        const el = document.querySelector(step.target);
        if (!el) return;

        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        setTimeout(() => {
            const rect = el.getBoundingClientRect();

            // Spotlight hole
            hole.setAttribute('x', rect.left - pad);
            hole.setAttribute('y', rect.top - pad);
            hole.setAttribute('width', rect.width + pad * 2);
            hole.setAttribute('height', rect.height + pad * 2);

            // Highlight target
            el.style.position = 'relative';
            el.style.zIndex = '71';
            el.style.pointerEvents = 'none';

            // Position tooltip
            if (step.pos === 'right') {
                tooltip.style.left = (rect.right + 16) + 'px';
                tooltip.style.top = Math.max(8, rect.top - 10) + 'px';
            } else if (step.pos === 'bottom') {
                tooltip.style.left = rect.left + 'px';
                tooltip.style.top = (rect.bottom + 16) + 'px';
            }

            // Content
            titleEl.textContent = step.title;
            descEl.textContent = step.desc;
            labelEl.textContent = `Step ${i + 1} of ${steps.length}`;
            progressEl.style.width = ((i + 1) / steps.length * 100) + '%';

            btnPrev.classList.toggle('hidden', i === 0);
            if (i === steps.length - 1) {
                btnNext.innerHTML = 'Get Started! <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
            } else {
                btnNext.innerHTML = 'Next <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>';
            }
        }, 300);
    }

    function clearHighlights() {
        steps.forEach(s => {
            const el = document.querySelector(s.target);
            if (el) { el.style.position = ''; el.style.zIndex = ''; el.style.pointerEvents = ''; }
        });
    }

    function closeTour() {
        clearHighlights();
        overlay.classList.add('hidden');
        sessionStorage.setItem('tour-done', '1');
    }

    btnNext.addEventListener('click', () => {
        clearHighlights();
        if (current < steps.length - 1) { current++; showStep(current); }
        else closeTour();
    });

    btnPrev.addEventListener('click', () => {
        if (current > 0) { clearHighlights(); current--; showStep(current); }
    });

    btnSkip.addEventListener('click', closeTour);

    // Start tour
    setTimeout(() => {
        overlay.classList.remove('hidden');
        showStep(0);
    }, 1000);
});
</script>
@endsection
