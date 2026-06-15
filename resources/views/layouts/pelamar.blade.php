<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — Applicant Portal</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar-link.active {
            background-color: #dcfce7;
            color: #15803d;
            font-weight: 600;
        }
        .sidebar-link:hover:not(.active) {
            background-color: #f0fdf4;
        }
        .content-bg {
            background-color: #f1f5f2;
            background-image:
                radial-gradient(ellipse at 0% 0%, rgba(34, 197, 94, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 100% 100%, rgba(34, 197, 94, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 30%, rgba(187, 247, 208, 0.15) 0%, transparent 40%),
                linear-gradient(rgba(0, 80, 40, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 80, 40, 0.02) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 100% 100%, 32px 32px, 32px 32px;
        }
    </style>
    @yield('css')
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

    <!-- ========== NAVBAR (full-width, top) ========== -->
    <nav class="bg-green-900 px-8 py-3 flex items-center justify-between sticky top-0 z-50">
        <!-- Left: Logo + Company Name -->
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto">
            </a>
        </div>

        <!-- Nav Links -->
        <div class="flex items-center gap-6">
            <a href="/pelamar/lowongan" class="text-green-300 hover:text-white text-sm transition-colors">Vacancies</a>
            <a href="/pelamar/profil" class="text-green-300 hover:text-white text-sm transition-colors">My Profile</a>

            <!-- Avatar -->
            <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-green-900 font-bold text-sm ring-2 ring-green-300 overflow-hidden" id="user-avatar">
                <img src="{{ asset('images/avatar.png') }}" alt="Avatar" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.textContent='A';">
            </div>

            <!-- Help / Tutorial -->
            <button id="btn-help" onclick="sessionStorage.removeItem('tour-done'); window.location.href='/pelamar/dashboard';" class="w-8 h-8 bg-green-800 hover:bg-green-700 rounded-full flex items-center justify-center text-white transition-colors" title="User Guide">
                <span class="text-sm font-bold">?</span>
            </button>
        </div>
    </nav>

    <!-- ========== BODY: Sidebar + Content ========== -->
    <div class="flex flex-1">

        <!-- ========== SIDEBAR ========== -->
        <aside class="w-60 bg-white border-r border-gray-200 flex flex-col sticky top-[52px] h-[calc(100vh-52px)]">

            <!-- Profile Progress -->
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Your Profile</span>
                    <span class="text-xs font-bold text-green-700" id="profile-percent">{{ $persentase ?? 0 }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5">
                    <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ session('profile_percent', 0) }}%" id="profile-bar"></div>
                </div>
                <p class="text-xs text-gray-400 mt-2">Complete education to reach 100%</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                <a href="/pelamar/dashboard" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-700 transition-colors @yield('nav-dashboard')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/>
                    </svg>
                    Dashboard
                </a>
                <a href="/pelamar/profil" id="sidebar-profil" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-700 transition-colors @yield('nav-profil')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    Profile
                </a>
                <a href="/pelamar/pengalaman-kerja" id="sidebar-pengalaman" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-700 transition-colors @yield('nav-pengalaman')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                    Work Experience
                </a>
                <a href="/pelamar/pendidikan" id="sidebar-pendidikan" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-700 transition-colors @yield('nav-pendidikan')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                    </svg>
                    Education
                </a>
                <a href="/pelamar/organisasi" id="sidebar-organisasi" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-700 transition-colors @yield('nav-organisasi')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Organization Experience
                </a>
                <a href="/pelamar/lampiran" id="sidebar-lampiran" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-700 transition-colors @yield('nav-lampiran')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57a4 4 0 1 1 5.66 5.66l-8.58 8.58a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
                    </svg>
                    Attachments
                </a>
                <a href="/pelamar/cv" id="sidebar-cv" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-700 transition-colors @yield('nav-cv')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/>
                    </svg>
                    My CV
                </a>
                <a href="/pelamar/status-lamaran" id="sidebar-status" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-700 transition-colors @yield('nav-status')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="m9 14 2 2 4-4"/>
                    </svg>
                    Application Status
                </a>
            </nav>

            <!-- Logout -->
            <div class="px-4 py-4 border-t border-gray-100">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- ========== MAIN CONTENT ========== -->
        <div class="flex-1 flex flex-col min-h-[calc(100vh-52px)]">

            <!-- Page Content -->
            <main class="flex-1 p-8 content-bg">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-green-950 text-white px-8 py-6">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-5 w-auto">
                        </div>
                        <p class="text-green-400 text-xs">© 2023 Human Resources Department. All Rights Reserved.</p>
                    </div>
                    <div class="flex flex-wrap gap-6 text-xs text-green-300">
                        <a href="/" class="hover:text-white transition-colors">Career Portal</a>
                        <a href="/" class="hover:text-white transition-colors">About Us</a>
                        <a href="/" class="hover:text-white transition-colors">Help Center</a>
                        <a href="/" class="hover:text-white transition-colors">Privacy</a>
                        <a href="/" class="hover:text-white transition-colors">Terms</a>
                    </div>
                </div>
            </footer>
        </div>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
