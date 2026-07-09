<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — PT Ecogreen Oleochemicals</title>
    @vite(['resources/css/app.css'])
    <style>
        .bg-gradient-eco {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 50%, #cbd5e1 100%);
        }
        .green-blob-left {
            position: absolute;
            top: 10%;
            left: -5%;
            width: 400px;
            height: 500px;
            background: radial-gradient(ellipse, rgba(187, 247, 208, 0.4) 0%, transparent 70%);
            pointer-events: none;
        }
        .green-blob-right {
            position: absolute;
            top: 5%;
            right: -5%;
            width: 450px;
            height: 600px;
            background: radial-gradient(ellipse, rgba(187, 247, 208, 0.3) 0%, transparent 70%);
            pointer-events: none;
        }
        .green-blob-bottom {
            position: absolute;
            bottom: 10%;
            right: 10%;
            width: 350px;
            height: 400px;
            background: radial-gradient(ellipse, rgba(220, 252, 231, 0.5) 0%, transparent 70%);
            pointer-events: none;
        }
    </style>
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
<body class="min-h-screen flex flex-col bg-gray-200">

    <!-- Navbar -->
    <nav style="background: #15803d !important; border-bottom: 2px solid #14532d !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08) !important;" class="px-10 py-3 flex items-center justify-between relative z-50">
        <div class="flex items-center gap-3">
            <!-- Logo + Company Name -->
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <a href="/" class="text-green-50 hover:text-white text-sm transition-colors font-medium">Home</a>
            <a href="/tentang-kami" class="text-green-50 hover:text-white text-sm transition-colors font-medium">About Us</a>
            <!-- Help Icon → Toggle HR/Applicant Login -->
            @if(request()->is('hr*'))
                <a href="/login"
                   title="Masuk sebagai Pelamar"
                   class="text-white hover:text-green-200 transition-colors relative group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                        <path d="M12 17h.01"/>
                    </svg>
                    {{-- Tooltip --}}
                    <span class="absolute right-0 top-8 bg-gray-900 text-white text-xs font-medium px-2.5 py-1.5 rounded-lg whitespace-nowrap
                                 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 shadow-lg">
                        Login sebagai Pelamar
                    </span>
                </a>
            @else
                <a href="/hr/login"
                   title="Masuk sebagai HR Staff"
                   class="text-white hover:text-green-200 transition-colors relative group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                        <path d="M12 17h.01"/>
                    </svg>
                    {{-- Tooltip --}}
                    <span class="absolute right-0 top-8 bg-gray-900 text-white text-xs font-medium px-2.5 py-1.5 rounded-lg whitespace-nowrap
                                 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 shadow-lg">
                        Login sebagai HR
                    </span>
                </a>
            @endif
            @yield('nav-right')
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 relative overflow-hidden bg-gradient-eco">
        <!-- Decorative blobs -->
        <div class="green-blob-left"></div>
        <div class="green-blob-right"></div>
        <div class="green-blob-bottom"></div>

        <div class="relative z-10 flex items-center justify-center py-12 px-4">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer style="background: #15803d !important; border: none !important; box-shadow: none !important;" class="text-white py-4 px-8 relative z-50">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-8 w-auto">
                <div>
                    <h3 class="font-semibold text-sm text-white">@yield('footer-title', 'PT Ecogreen Oleochemicals')</h3>
                    <p class="text-green-50 text-xs mt-0.5">© 2024 PT Ecogreen Oleochemicals. All rights reserved.</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs text-green-50">
                <button onclick="showInfoModal('privacy')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Privacy Policy</button>
                <button onclick="showInfoModal('terms')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Terms of Service</button>
                <button onclick="showInfoModal('sustainability')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Sustainability Report</button>
                <button onclick="showInfoModal('support')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Contact Support</button>
            </div>
        </div>
    </footer>

    <!-- Generic Information Modal -->
    <div id="info-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
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