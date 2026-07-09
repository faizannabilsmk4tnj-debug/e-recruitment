<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — PT Ecogreen Oleochemicals</title>
    @vite(['resources/css/app.css'])
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
<body class="min-h-screen flex flex-col bg-white">

    <!-- Navbar -->
    <nav style="background: #15803d !important; border-bottom: 2px solid #14532d !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08) !important;" class="px-16 py-3 flex items-center justify-between relative z-50">
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <a href="/" class="text-sm transition-colors font-medium @yield('nav-beranda', 'text-green-50 hover:text-white')">Home</a>
            <a href="/tentang-kami" class="text-sm transition-colors font-medium text-green-50 hover:text-white">About Us</a>
            <a href="/lowongan" class="text-sm transition-colors font-medium @yield('nav-lowongan', 'text-green-50 hover:text-white')">Vacancies</a>
            @guest
                <div class="flex items-center gap-2">
                    <a href="/login" class="border border-white bg-white text-[#15803d] text-sm font-semibold px-5 py-2 rounded-lg hover:bg-green-50 transition-colors">
                        Sign In
                    </a>
                    <a href="/register" class="border border-white text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-white hover:text-[#15803d] transition-colors">
                        Register
                    </a>
                </div>
            @endguest
            @auth
                <div class="flex items-center gap-3">
                    <a href="{{ Auth::user()->role === 'applicant' ? '/pelamar/dashboard' : '/hr/dashboard' }}" class="border border-white bg-white text-[#15803d] text-sm font-semibold px-5 py-2 rounded-lg hover:bg-green-50 transition-colors">
                        Dashboard
                    </a>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="border border-white text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-white hover:text-[#15803d] transition-colors cursor-pointer">
                            Sign Out
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background: #15803d !important; border: none !important; box-shadow: none !important;" class="text-white px-16 py-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-8 w-auto">
                <div>
                    <p class="text-sm font-semibold text-white">Ecogreen Oleochemicals</p>
                    <p class="text-green-50 text-xs mt-0.5">© 2024 PT Ecogreen Oleochemicals. Sustainable Excellence.</p>
                </div>
            </div>
            <div class="flex gap-6 text-sm text-green-50">
                <button onclick="showInfoModal('privacy')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Privacy Policy</button>
                <button onclick="showInfoModal('terms')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Terms of Service</button>
                <button onclick="showInfoModal('sustainability')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Sustainability Report</button>
                <button onclick="showInfoModal('support')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Contact Support</button>
            </div>
        </div>
    </footer>

    <!-- Login Prompt Modal -->
    <div id="modal-login-prompt" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-8 text-center relative">
            <!-- Close -->
            <button onclick="document.getElementById('modal-login-prompt').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <!-- Icon -->
            <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" x2="12" y1="8" y2="12"/>
                    <line x1="12" x2="12.01" y1="16" y2="16"/>
                </svg>
            </div>
            <!-- Title -->
            <h2 class="text-xl font-bold text-gray-900 mb-2">You Are Not Logged In</h2>
            <p class="text-sm text-gray-500 mb-8">Please login to your account or register if you don't have one.</p>
            <!-- Buttons -->
            <div class="space-y-3">
                <a href="/login" class="block w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors">
                    Sign In
                </a>
                <a href="/register" class="block w-full border border-gray-300 text-gray-700 font-semibold py-3 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Register
                </a>
            </div>
        </div>
    </div>

    <!-- Generic Information Modal -->
    <div id="info-modal" class="hidden fixed inset-0 z-[70] flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-[85vh]">
            <!-- Header -->
            <div class="bg-[#15803d] px-6 py-4 flex items-center justify-between text-white shrink-0">
                <h3 id="info-modal-title" class="font-bold text-base">Information</h3>
                <button id="btn-close-info" class="text-green-200 hover:text-white transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <!-- Body -->
            <div class="px-6 py-5 overflow-y-auto text-sm text-gray-600 leading-relaxed" id="info-modal-body">
                <!-- Dynamic Content -->
            </div>
            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end shrink-0">
                <button id="btn-close-info-footer" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl text-xs transition-colors focus:outline-none">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Global login prompt function
        function showLoginPrompt(e) {
            if (e) e.preventDefault();
            document.getElementById('modal-login-prompt').classList.remove('hidden');
        }
        // Close on overlay click
        document.getElementById('modal-login-prompt')?.addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
        // Attach to all elements with data-auth-required
        document.querySelectorAll('[data-auth-required]').forEach(el => {
            el.addEventListener('click', showLoginPrompt);
        });
    </script>
    @yield('scripts')
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

        // ===== FOOTER MODALS LOGIC =====
        const infoContent = {
            privacy: {
                title: 'Privacy Policy',
                body: `
                    <p class="mb-3">PT Ecogreen Oleochemicals is committed to maintaining the confidentiality and security of your personal data as a job applicant.</p>
                    <p class="mb-3"><strong>1. Data Collection:</strong> We collect personal data that you enter voluntarily, such as your name, email address, telephone number, education history, employment history, as well as CV files and other supporting certificates.</p>
                    <p class="mb-3"><strong>2. Data Usage:</strong> Your data will only be used for the employee selection process, contacting you regarding interview stages, and professional background verification.</p>
                    <p class="mb-3"><strong>3. Data Protection:</strong> We implement technical and organizational security standards to protect your personal data from unauthorized access, loss, or manipulation by third parties.</p>
                    <p>If you have questions regarding your data, please contact our recruitment team through the help menu.</p>
                `
            },
            terms: {
                title: 'Terms of Service',
                body: `
                    <p class="mb-3">Welcome to the PT Ecogreen Oleochemicals E-Recruitment Portal. By accessing and registering on this portal, you agree to comply with the following terms:</p>
                    <p class="mb-3"><strong>1. Accuracy of Information:</strong> You declare that all data, CVs, job information, and documents you upload are true, accurate, and do not manipulate any information.</p>
                    <p class="mb-3"><strong>2. Account Security:</strong> You are fully responsible for maintaining the confidentiality of your recruitment account password and the activities that occur under that account.</p>
                    <p class="mb-3"><strong>3. Prohibition of Misuse:</strong> You are prohibited from using this portal for illegal actions, hacking security systems, spreading spam, or uploading dangerous documents (such as malware).</p>
                    <p>Violations of these terms and conditions may result in the unilateral cancellation of your application process and account deactivation.</p>
                `
            },
            sustainability: {
                title: 'Sustainability Report',
                body: `
                    <p class="mb-3">As one of the world's leading natural fatty alcohol manufacturers, PT Ecogreen Oleochemicals places sustainability as a main pillar of our operations.</p>
                    <p class="mb-3"><strong>1. Responsible Sourcing:</strong> We are fully committed to using sustainable palm oil raw materials and complying with RSPO (Roundtable on Sustainable Palm Oil) certification standards.</p>
                    <p class="mb-3"><strong>2. Environmental Management:</strong> Our plants implement ISO 14001 certified environmental management systems to minimize carbon emissions, optimize water recycling, and manage production waste responsibly.</p>
                    <p class="mb-3"><strong>3. Social Responsibility:</strong> We support the welfare of local communities around our operational areas through sustainable CSR programs and local workforce empowerment.</p>
                    <p>The complete Sustainability Report can be accessed officially through our main corporate website at <a href="https://www.ecogreenoleo.com" target="_blank" class="text-green-700 underline font-semibold">www.ecogreenoleo.com</a>.</p>
                `
            },
            support: {
                title: 'Contact Support',
                body: `
                    <p class="mb-3">If you experience technical difficulties (such as difficulty registering, uploading documents, or not receiving a password reset email), our team is ready to help you.</p>
                    <p class="mb-3"><strong>Contact Us Via:</strong></p>
                    <ul class="list-style-none mb-3 space-y-1">
                        <li><strong>HR Team Email:</strong> <a href="mailto:career@ecogreenoleo.com" class="text-green-700 underline font-medium">career@ecogreenoleo.com</a></li>
                        <li><strong>Phone (Batam Head Office):</strong> +62 778 711 777</li>
                        <li><strong>Address:</strong> Kavling 1 Kabil, Nongsa, Batam City, Riau Islands, Indonesia</li>
                    </ul>
                    <p class="text-xs text-gray-500">Support services are available on business days (Monday - Friday) from 08:00 to 17:00 WIB.</p>
                `
            }
        };

        const infoModal = document.getElementById('info-modal');
        const infoTitle = document.getElementById('info-modal-title');
        const infoBody = document.getElementById('info-modal-body');
        const btnCloseInfo = document.getElementById('btn-close-info');
        const btnCloseInfoFooter = document.getElementById('btn-close-info-footer');

        window.showInfoModal = function(type) {
            if (infoContent[type]) {
                infoTitle.textContent = infoContent[type].title;
                infoBody.innerHTML = infoContent[type].body;
                infoModal.classList.remove('hidden');
            }
        };

        function closeInfoModal() {
            infoModal.classList.add('hidden');
        }

        if (btnCloseInfo) btnCloseInfo.addEventListener('click', closeInfoModal);
        if (btnCloseInfoFooter) btnCloseInfoFooter.addEventListener('click', closeInfoModal);
        if (infoModal) {
            infoModal.addEventListener('click', function(e) {
                if (e.target === infoModal) closeInfoModal();
            });
        }
    </script>
</body>
</html>