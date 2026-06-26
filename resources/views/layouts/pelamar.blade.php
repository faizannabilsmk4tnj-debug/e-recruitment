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
                radial-gradient(ellipse at 60% 30%, rgba(187, 247, 208, 0.15) 0%, transparent 40%);
            background-size: 100% 100%, 100% 100%, 100% 100%;
        }
    </style>
    @yield('css')
    <style>
        body > nav, body > footer, body > footer * { background: #15803d !important; background-image: none !important; }
        button[class*="bg-green-600"], button[class*="bg-green-700"], button[class*="bg-green-800"], button[class*="bg-green-900"], button[class*="bg-[#0f3c20]"], button[class*="bg-[#166534]"],
        a[class*="bg-green-600"], a[class*="bg-green-700"], a[class*="bg-green-800"], a[class*="bg-green-900"], a[class*="bg-[#0f3c20]"], a[class*="bg-[#166534]"] {
            background-color: #15803d !important;
            border-color: #15803d !important;
        }
        button[class*="bg-green-600"]:hover, button[class*="bg-green-700"]:hover, button[class*="bg-green-800"]:hover, button[class*="bg-green-900"]:hover, button[class*="bg-[#0f3c20]"]:hover, button[class*="bg-[#166534]"]:hover,
        a[class*="bg-green-600"]:hover, a[class*="bg-green-700"]:hover, a[class*="bg-green-800"]:hover, a[class*="bg-green-900"]:hover, a[class*="bg-[#0f3c20]"]:hover, a[class*="bg-[#166534]"]:hover {
            background-color: #166534 !important;
            border-color: #166534 !important;
        }
    </style>
</head>
<body class="h-screen bg-gray-200 flex flex-col overflow-hidden">

    <!-- ========== NAVBAR (full-width, top) ========== -->
    <nav style="background: #15803d !important; border-bottom: 2px solid #14532d !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08) !important;" class="px-16 py-3 flex items-center justify-between z-50 shrink-0">
        <!-- Left: Logo + Company Name -->
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            </a>
        </div>

        <!-- Nav Links -->
        <div class="flex items-center gap-6">
            <a href="/" onclick="return confirmHomeExit(event, this)" class="text-sm transition-colors font-medium text-green-50 hover:text-white">Home</a>
            <a href="/tentang-kami" onclick="return confirmHomeExit(event, this)" class="text-sm transition-colors font-medium text-green-50 hover:text-white">About Us</a>
            <a href="/pelamar/lowongan" class="text-sm transition-colors font-medium {{ Request::is('pelamar/lowongan*') ? 'text-white font-semibold' : 'text-green-50 hover:text-white' }}">Vacancies</a>
            <a href="/pelamar/profil" class="text-sm transition-colors font-medium {{ Request::is('pelamar/profil*') ? 'text-white font-semibold' : 'text-green-50 hover:text-white' }}">My Profile</a>

            {{-- Notification Bell --}}
            <div class="relative">
                <button id="btn-notif-pelamar" onclick="document.getElementById('notif-dropdown-pelamar').classList.toggle('hidden')" class="relative text-green-200 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="notif-badge-pelamar" class="hidden absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-500 rounded-full text-[9px] flex items-center justify-center font-bold text-white">0</span>
                </button>

                <div id="notif-dropdown-pelamar" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-800">Notifikasi</h3>
                        <span id="notif-header-count-pelamar" class="text-[10px] text-green-700 font-semibold bg-green-50 px-2 py-0.5 rounded-full">0 baru</span>
                    </div>
                    <div id="notif-list-pelamar" class="max-h-80 overflow-y-auto">
                        <div class="px-4 py-8 text-center text-xs text-gray-400">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            Memuat notifikasi...
                        </div>
                    </div>
                    <div class="px-4 py-2 border-t border-gray-100 text-center">
                        <button onclick="markAllNotifPelamar()" class="text-xs font-semibold text-green-700 hover:text-green-900 transition-colors">Tandai Semua Dibaca</button>
                    </div>
                </div>
            </div>

            <!-- Avatar -->
            @php $navProfile = auth()->user() ? auth()->user()->profile : null; @endphp
            <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-green-900 font-bold text-sm ring-2 ring-green-300 overflow-hidden" id="user-avatar">
                @if ($navProfile && $navProfile->avatar_url)
                    <img src="{{ asset('storage/' . $navProfile->avatar_url) }}" alt="Avatar" class="w-full h-full object-cover">
                @elseif (auth()->check() && auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                @endif
            </div>

            <!-- Help / Tutorial -->
            <button id="btn-help" onclick="sessionStorage.removeItem('tour-done'); window.location.href='/pelamar/dashboard';" class="w-8 h-8 bg-[#15803d] hover:bg-[#166534] rounded-full flex items-center justify-center text-white transition-colors" title="User Guide">
                <span class="text-sm font-bold">?</span>
            </button>
        </div>
    </nav>

    <!-- ========== BODY: Sidebar + Content ========== -->
    <div class="flex flex-1 overflow-hidden">

        <!-- ========== SIDEBAR ========== -->
        <aside class="w-60 bg-white border-r border-gray-200 flex flex-col overflow-y-auto shrink-0">

            <!-- Profile Progress -->
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Your Profile</span>
                    <span class="text-xs font-bold text-green-700" id="profile-percent">{{ $persentase ?? 0 }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5">
                    <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ $persentase ?? 0 }}%; background-color: #16a34a !important;" id="profile-bar"></div>
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
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 transition-colors text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- ========== MAIN CONTENT ========== -->
        <main class="flex-1 p-8 content-bg overflow-y-auto">
            @yield('content')
        </main>

    </div>

    <!-- Footer -->
    <footer style="background: #15803d !important; border: none !important; box-shadow: none !important;" class="text-white px-16 py-3 shrink-0 relative z-50">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-2">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-6 w-auto">
                <p class="text-green-50 text-[11px] border-l border-green-700/30 pl-4">© 2023 PT Ecogreen Oleochemicals</p>
            </div>
            <div class="flex flex-wrap gap-5 text-[11px] text-green-50">
                <a href="#" class="cursor-pointer hover:text-white hover:underline transition-colors relative z-50">Career Portal</a>
                <a href="#" class="cursor-pointer hover:text-white hover:underline transition-colors relative z-50">Help Center</a>
                <a href="#" class="cursor-pointer hover:text-white hover:underline transition-colors relative z-50">Terms & Privacy</a>
            </div>
        </div>
    </footer>

    <!-- Centered Modal -->
    <div id="content-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-black/50 transition-opacity opacity-0" id="modal-backdrop" onclick="closeModal()"></div>
        <div class="relative w-full max-w-5xl h-[85vh] bg-white rounded-xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 flex flex-col overflow-hidden" id="modal-panel">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white z-10 shrink-0">
                <h2 id="modal-title" class="text-xl font-bold text-gray-800">Content</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-full transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex-1 relative bg-gray-50">
                <!-- Loader -->
                <div id="modal-loader" class="absolute inset-0 flex items-center justify-center bg-white z-10">
                    <div class="animate-spin rounded-full h-10 w-10 border-4 border-green-200 border-t-green-700"></div>
                </div>
                <!-- Iframe -->
                <iframe id="modal-iframe" class="w-full h-full border-0 opacity-0 transition-opacity duration-300 rounded-b-xl"></iframe>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function openModal(url, title) {
            const modal = document.getElementById('content-modal');
            const backdrop = document.getElementById('modal-backdrop');
            const panel = document.getElementById('modal-panel');
            const iframe = document.getElementById('modal-iframe');
            const titleEl = document.getElementById('modal-title');
            const loader = document.getElementById('modal-loader');
            
            titleEl.innerText = title;
            
            // Show modal container
            modal.classList.remove('hidden');
            
            // Trigger reflow for transitions
            void modal.offsetWidth;
            
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
            
            // Reset iframe state
            iframe.classList.add('opacity-0');
            iframe.classList.remove('opacity-100');
            loader.classList.remove('hidden');
            
            iframe.src = url;
            
            iframe.onload = function() {
                try {
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    
                    // Attempt to hide navbar and footer in the loaded page to keep the modal clean
                    const nav = iframeDoc.querySelector('nav');
                    const footer = iframeDoc.querySelector('footer');
                    if(nav) nav.style.display = 'none';
                    if(footer) footer.style.display = 'none';
                    
                    // Some pages might have a main wrapper with padding top because of fixed navs
                    const main = iframeDoc.querySelector('main');
                    if(main) {
                        main.style.paddingTop = '0';
                        main.style.minHeight = 'auto';
                    }
                } catch(e) {
                    console.error('Could not modify iframe content:', e);
                }
                
                loader.classList.add('hidden');
                iframe.classList.remove('opacity-0');
                iframe.classList.add('opacity-100');
            };
        }
        
        function closeModal() {
            const backdrop = document.getElementById('modal-backdrop');
            const panel = document.getElementById('modal-panel');
            const iframe = document.getElementById('modal-iframe');
            
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            
            panel.classList.remove('scale-100', 'opacity-100');
            panel.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                document.getElementById('content-modal').classList.add('hidden');
                iframe.src = '';
            }, 300); // Wait for transition
        }

        function confirmHomeExit(event, element) {
            if (event) event.preventDefault();
            const targetUrl = element ? element.getAttribute('href') : '/';
            
            const modal = document.getElementById('confirm-exit-modal');
            const panel = document.getElementById('confirm-exit-panel');
            const confirmBtn = document.getElementById('btn-confirm-exit-link');
            const subtitle = modal.querySelector('#confirm-exit-panel p.text-xs.text-gray-500');
            
            if (subtitle) {
                if (targetUrl === '/tentang-kami') {
                    subtitle.textContent = "Anda akan dialihkan ke halaman Tentang Kami.";
                } else {
                    subtitle.textContent = "Anda akan dialihkan ke halaman utama.";
                }
            }
            
            confirmBtn.setAttribute('href', targetUrl);
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Trigger transition
            void modal.offsetWidth;
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
            
            return false;
        }

        function closeConfirmExitModal() {
            const modal = document.getElementById('confirm-exit-modal');
            const panel = document.getElementById('confirm-exit-panel');
            
            panel.classList.remove('scale-100', 'opacity-100');
            panel.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
    </script>
    <script>
        // ===== PELAMAR NOTIFICATION SYSTEM =====
        const PELAMAR_NOTIF_ICONS = {
            status_change: {
                bg: 'bg-green-100', color: 'text-green-600',
                svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                link: '/pelamar/status-lamaran'
            },
            interview_scheduled: {
                bg: 'bg-purple-100', color: 'text-purple-600',
                svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                link: '/pelamar/status-lamaran'
            },
            new_applicant: {
                bg: 'bg-blue-100', color: 'text-blue-600',
                svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                link: '/pelamar/dashboard'
            }
        };
        const PELAMAR_NOTIF_DEFAULT = {
            bg: 'bg-gray-100', color: 'text-gray-600',
            svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>',
            link: '/pelamar/dashboard'
        };

        function escapeHtmlPelamar(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        function fetchNotifPelamar() {
            fetch('/api/notifications?limit=10', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;
                renderNotifPelamar(data.notifications, data.unread_count);
            })
            .catch(e => console.error('Failed to fetch notifications:', e));
        }

        function renderNotifPelamar(notifications, unreadCount) {
            const badge = document.getElementById('notif-badge-pelamar');
            const headerCount = document.getElementById('notif-header-count-pelamar');
            const list = document.getElementById('notif-list-pelamar');

            if (unreadCount > 0) {
                badge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }

            headerCount.textContent = unreadCount + ' baru';

            if (!notifications || notifications.length === 0) {
                list.innerHTML = `<div class="px-4 py-8 text-center text-xs text-gray-400">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Belum ada notifikasi
                </div>`;
                return;
            }

            let html = '';
            notifications.forEach((n, i) => {
                const icon = PELAMAR_NOTIF_ICONS[n.type] || PELAMAR_NOTIF_DEFAULT;
                const unreadBg = n.is_unread ? 'bg-green-50/50' : '';
                const unreadDot = n.is_unread ? '<div class="w-1.5 h-1.5 bg-green-500 rounded-full absolute top-3 right-3"></div>' : '';
                const borderClass = i < notifications.length - 1 ? 'border-b border-gray-50' : '';

                html += `<a href="${icon.link}" onclick="markNotifReadPelamar(event, ${n.id})" class="block px-4 py-3 hover:bg-gray-50 transition-colors ${borderClass} ${unreadBg} relative">
                    ${unreadDot}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full ${icon.bg} flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 ${icon.color}" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icon.svg}</svg>
                        </div>
                        <div class="pr-3">
                            <p class="text-xs text-gray-800 font-medium">${escapeHtmlPelamar(n.title)}</p>
                            <p class="text-[11px] text-gray-500 mt-0.5">${escapeHtmlPelamar(n.message)}</p>
                            <p class="text-[9px] text-gray-400 mt-1">${n.time_ago}</p>
                        </div>
                    </div>
                </a>`;
            });

            list.innerHTML = html;
        }

        function markNotifReadPelamar(event, notifId) {
            fetch('/api/notifications/' + notifId + '/read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).catch(() => {});
        }

        function markAllNotifPelamar() {
            fetch('/api/notifications/read-all', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) fetchNotifPelamar();
            })
            .catch(() => {});
        }

        // Fetch on page load + auto-refresh
        document.addEventListener('DOMContentLoaded', () => {
            fetchNotifPelamar();
            setInterval(fetchNotifPelamar, 60000);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notif-dropdown-pelamar');
            const btn = document.getElementById('btn-notif-pelamar');
            if (btn && dropdown && !btn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nav = document.querySelector('body > nav');
            const footer = document.querySelector('body > footer');
            if (nav && footer) {
                const navBg = getComputedStyle(nav).backgroundColor;
                footer.style.setProperty('background', navBg, 'important');
                footer.style.setProperty('background-color', navBg, 'important');
                footer.style.setProperty('background-image', 'none', 'important');
                footer.querySelectorAll('*').forEach(function(el) {
                    const elBg = getComputedStyle(el).backgroundColor;
                    if (elBg !== 'rgba(0, 0, 0, 0)' && elBg !== 'transparent' && elBg !== navBg) {
                        el.style.setProperty('background', navBg, 'important');
                        el.style.setProperty('background-color', navBg, 'important');
                        el.style.setProperty('background-image', 'none', 'important');
                    }
                });
            }
        });
    </script>

    {{-- Custom Confirm Exit Modal --}}
    <div id="confirm-exit-modal" class="fixed inset-0 z-[110] hidden overflow-y-auto flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeConfirmExitModal()"></div>
        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100 transform scale-95 opacity-0 transition-all duration-300 flex flex-col z-50 animate-preview" id="confirm-exit-panel">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Keluar dari Dashboard?</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Anda akan dialihkan ke halaman utama.</p>
                </div>
            </div>
            
            <p class="text-xs text-gray-600 leading-relaxed bg-gray-50 p-3.5 rounded-xl border border-gray-100 mb-6">
                Aktivitas Anda di dalam dashboard pelamar akan ditutup. Anda harus melakukan login ulang menggunakan akun Anda jika ingin masuk kembali ke dashboard ini.
            </p>

            <div class="flex items-center justify-end gap-3">
                <button onclick="closeConfirmExitModal()" class="px-4 py-2 rounded-lg text-xs font-semibold text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <a id="btn-confirm-exit-link" href="/" class="px-4 py-2 rounded-lg text-xs font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors shadow-sm">
                    Ya, Keluar
                </a>
            </div>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
