@extends('layouts.hr')

@section('title', 'Applicant Detail')
@section('page-title', 'Applicant Detail')
@section('nav-pelamar', 'text-green-800 border-green-800')

@section('content')
<div class="px-8 py-8 max-w-7xl mx-auto">

    {{-- Breadcrumb (Optional, based on standard patterns) --}}
    <div class="mb-6 flex items-center text-sm text-gray-500 gap-2">
        <a href="/hr/pelamar" class="hover:text-green-800 transition-colors">Applicants</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        <span class="text-gray-900 font-medium">Applicant Detail</span>
    </div>

    {{-- Header Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-start gap-6 relative">
        {{-- Photo --}}
        <div class="relative">
            <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=14532d&color=fff&size=128" alt="Budi Santoso" class="w-28 h-28 rounded-xl object-cover shadow-sm">
            {{-- Verified Badge --}}
            <div class="absolute -bottom-2 -right-2 bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center border-2 border-white">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>

        {{-- Info --}}
        <div class="flex-1 pt-1">
            <h2 class="text-2xl font-bold text-gray-900">Budi Santoso, S.T.</h2>
            <div class="text-gray-600 mt-1 mb-4 font-medium">Software Engineer (Senior) Applicant</div>
            
            <div class="flex flex-wrap items-center gap-x-8 gap-y-2 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    budi.santoso@email.com
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    +62 812 3456 7890
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Batam, Kepulauan Riau
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Applied: 24 Oct 2023
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col items-end">
            <div class="bg-green-100 text-green-800 px-4 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase mb-6 border border-green-200">
                Assessment Phase
            </div>
            <div class="flex items-center gap-2">
                <button class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-500 hover:text-green-800 hover:border-green-800 hover:bg-green-50 transition-colors shadow-sm" title="Download CV">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                </button>
                <button class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-500 hover:text-green-800 hover:border-green-800 hover:bg-green-50 transition-colors shadow-sm" title="Share Profile">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                </button>
            </div>
        </div>
    </div>



    {{-- Content Layout --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Column (Profil Lengkap) --}}
        <div class="lg:col-span-2 space-y-10">
            
            {{-- Informasi Pribadi --}}
            <section>
                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-3">
                    <svg class="w-5 h-5 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <h3 class="text-lg font-bold text-gray-900">Personal Information</h3>
                </div>
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NIK</div>
                        <div class="text-sm font-semibold text-gray-900">2171011210920003</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">FULL NAME</div>
                        <div class="text-sm font-semibold text-gray-900">Budi Santoso, S.T.</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">GENDER</div>
                        <div class="text-sm font-semibold text-gray-900">Male</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">PHONE NUMBER</div>
                        <div class="text-sm font-semibold text-gray-900">+62 812 3456 7890</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">EMAIL</div>
                        <div class="text-sm font-semibold text-gray-900">budi.santoso@email.com</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">PLACE, DATE OF BIRTH</div>
                        <div class="text-sm font-semibold text-gray-900">Batam, 12 October 1992</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">AGE</div>
                        <div class="text-sm font-semibold text-gray-900">31 Years Old</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">MARITAL STATUS</div>
                        <div class="text-sm font-semibold text-gray-900">Married</div>
                    </div>
                </div>
            </section>

            {{-- Pendidikan --}}
            <section>
                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-3">
                    <svg class="w-5 h-5 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    <h3 class="text-lg font-bold text-gray-900">Education</h3>
                </div>
                <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">LAST EDUCATION</div>
                        <div class="text-sm font-semibold text-gray-900">B.Eng. Informatics Engineering</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">SCHOOL / UNIVERSITY</div>
                        <div class="text-sm font-semibold text-gray-900">Institut Teknologi Bandung</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">GRADUATION YEAR</div>
                        <div class="text-sm font-semibold text-gray-900">September 2018</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">GPA</div>
                        <div class="text-sm font-semibold text-gray-900">3.85 / 4.00</div>
                    </div>
                </div>
            </section>

            {{-- Informasi Alamat --}}
            <section>
                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-3">
                    <svg class="w-5 h-5 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <h3 class="text-lg font-bold text-gray-900">Address Information</h3>
                </div>
                
                {{-- KTP Address Card --}}
                <div class="bg-green-50/30 border border-green-100 rounded-xl p-6 mb-5">
                    <h4 class="text-sm font-bold text-green-900 tracking-wider mb-4">ID CARD ADDRESS (KTP)</h4>
                    <div class="grid grid-cols-2 gap-x-8 gap-y-5">
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">PROVINCE</div>
                            <div class="text-sm font-semibold text-gray-900">Kepulauan Riau</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">CITY / REGENCY</div>
                            <div class="text-sm font-semibold text-gray-900">Kota Batam</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">DISTRICT</div>
                            <div class="text-sm font-semibold text-gray-900">Batam Kota</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">SUB-DISTRICT</div>
                            <div class="text-sm font-semibold text-gray-900">Belian</div>
                        </div>
                        <div class="col-span-2">
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">FULL ADDRESS</div>
                            <div class="text-sm font-semibold text-gray-900">Jl. Gajah Mada No. 123, Komplek Mega Legenda Blok A1 No. 5</div>
                        </div>
                    </div>
                </div>

                {{-- Domisili Address Card --}}
                <div class="bg-gray-50/50 border border-gray-100 rounded-xl p-6 relative">
                    <div class="absolute top-6 right-6 bg-gray-200 text-gray-700 px-2 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase">
                        SAME AS ID CARD
                    </div>
                    <h4 class="text-sm font-bold text-green-900 tracking-wider mb-4">DOMICILE ADDRESS</h4>
                    <div class="grid grid-cols-2 gap-x-8 gap-y-5">
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">PROVINCE</div>
                            <div class="text-sm font-semibold text-gray-900">Kepulauan Riau</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">CITY / REGENCY</div>
                            <div class="text-sm font-semibold text-gray-900">Kota Batam</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">DISTRICT</div>
                            <div class="text-sm font-semibold text-gray-900">Batam Kota</div>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">SUB-DISTRICT</div>
                            <div class="text-sm font-semibold text-gray-900">Belian</div>
                        </div>
                        <div class="col-span-2">
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">FULL ADDRESS</div>
                            <div class="text-sm font-semibold text-gray-900">Jl. Gajah Mada No. 123, Komplek Mega Legenda Blok A1 No. 5</div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- CV Preview Inline --}}
            <section>
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="text-lg font-bold text-gray-900">CV Preview</h3>
                    </div>
                    <button class="text-sm text-green-800 font-bold hover:underline flex items-center gap-1 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PDF
                    </button>
                </div>
                
                {{-- Mockup CV Document --}}
                <div class="bg-gray-100/70 p-4 sm:p-8 rounded-xl overflow-hidden flex justify-center">
                    {{-- A4 Paper Aspect Ratio --}}
                    <div class="bg-white w-full max-w-[800px] shadow-sm border border-gray-200 rounded-sm aspect-[1/1.414] overflow-hidden flex flex-col relative">
                        
                        {{-- Header CV --}}
                        <div class="bg-green-950 text-white p-6 sm:p-10 shrink-0">
                            <h1 class="text-2xl sm:text-4xl font-black mb-1 sm:mb-2 uppercase tracking-wide">Budi Santoso, S.T.</h1>
                            <h2 class="text-sm sm:text-lg font-medium text-green-300">Software Engineer (Senior)</h2>
                        </div>
                        
                        {{-- Body CV --}}
                        <div class="flex-1 flex flex-col sm:flex-row p-6 sm:p-10 gap-6 sm:gap-10">
                            
                            {{-- Left Sidebar --}}
                            <div class="w-full sm:w-1/3 border-b sm:border-b-0 sm:border-r border-gray-200 pb-6 sm:pb-0 sm:pr-8 space-y-6 sm:space-y-8 shrink-0">
                                <div>
                                    <h3 class="text-[11px] sm:text-xs font-black text-gray-900 border-b-2 border-gray-900 pb-1.5 mb-3 uppercase tracking-widest">Contact</h3>
                                    <div class="space-y-2.5 text-[10px] sm:text-[11px] text-gray-600">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                                                <svg class="w-3 h-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                                            </div>
                                            <span class="truncate">budi.santoso@email.com</span>
                                        </div>
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                                                <svg class="w-3 h-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                                            </div>
                                            <span>+62 812 3456 7890</span>
                                        </div>
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                                                <svg class="w-3 h-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                            </div>
                                            <span>Batam, Kepri</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h3 class="text-[11px] sm:text-xs font-black text-gray-900 border-b-2 border-gray-900 pb-1.5 mb-3 uppercase tracking-widest">Skills</h3>
                                    <div class="flex flex-wrap gap-1.5">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[9px] sm:text-[10px] font-bold">PHP</span>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[9px] sm:text-[10px] font-bold">Laravel</span>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[9px] sm:text-[10px] font-bold">Vue.js</span>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[9px] sm:text-[10px] font-bold">MySQL</span>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[9px] sm:text-[10px] font-bold">Docker</span>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[9px] sm:text-[10px] font-bold">Git</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <h3 class="text-[11px] sm:text-xs font-black text-gray-900 border-b-2 border-gray-900 pb-1.5 mb-3 uppercase tracking-widest">Languages</h3>
                                    <ul class="space-y-2 text-[10px] sm:text-[11px] text-gray-600 font-medium">
                                        <li class="flex justify-between"><span>Indonesia</span> <span class="font-bold text-gray-900">Native</span></li>
                                        <li class="flex justify-between"><span>English</span> <span class="font-bold text-gray-900">Fluent</span></li>
                                    </ul>
                                </div>
                            </div>
                            
                            {{-- Right Main Content --}}
                            <div class="flex-1 space-y-6 sm:space-y-8">
                                <div>
                                    <h3 class="text-[11px] sm:text-xs font-black text-green-950 border-b-2 border-gray-200 pb-1.5 mb-3 uppercase tracking-widest">Professional Summary</h3>
                                    <p class="text-[10px] sm:text-[11px] text-gray-600 leading-relaxed text-justify">
                                        Professional Software Engineer with over 5 years of experience in modern web development. Expert in designing large-scale application architecture, database performance optimization, and leading agile development teams. Deeply committed to clean code principles and high-quality software delivery.
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 class="text-[11px] sm:text-xs font-black text-green-950 border-b-2 border-gray-200 pb-1.5 mb-3 uppercase tracking-widest">Work Experience</h3>
                                    
                                    <div class="mb-5 relative pl-4 border-l-2 border-green-200">
                                        <div class="absolute w-2 h-2 bg-green-600 rounded-full -left-[5px] top-1.5"></div>
                                        <div class="flex justify-between items-baseline mb-0.5">
                                            <h4 class="text-[11px] sm:text-xs font-black text-gray-900">Senior Web Developer</h4>
                                            <span class="text-[9px] sm:text-[10px] font-bold text-gray-500 whitespace-nowrap">2020 - Present</span>
                                        </div>
                                        <div class="text-[10px] sm:text-[11px] font-bold text-green-800 mb-2">PT Teknologi Nusantara</div>
                                        <ul class="list-disc list-outside ml-3 text-[10px] sm:text-[11px] text-gray-600 leading-relaxed space-y-1">
                                            <li>Designed and deployed a microservices architecture for the company's internal ERP system.</li>
                                            <li>Improved MySQL database query performance by 40% and optimized page load times.</li>
                                            <li>Led and mentored 3 junior developers in the engineering team.</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="relative pl-4 border-l-2 border-gray-200">
                                        <div class="absolute w-2 h-2 bg-gray-300 rounded-full -left-[5px] top-1.5"></div>
                                        <div class="flex justify-between items-baseline mb-0.5">
                                            <h4 class="text-[11px] sm:text-xs font-black text-gray-900">Fullstack Engineer</h4>
                                            <span class="text-[9px] sm:text-[10px] font-bold text-gray-500 whitespace-nowrap">2018 - 2020</span>
                                        </div>
                                        <div class="text-[10px] sm:text-[11px] font-bold text-gray-700 mb-2">CV Kreatif Media</div>
                                        <ul class="list-disc list-outside ml-3 text-[10px] sm:text-[11px] text-gray-600 leading-relaxed space-y-1">
                                            <li>Developed over 15 client websites using the Laravel and Vue.js frameworks.</li>
                                            <li>Integrated various local payment gateways (Midtrans, Xendit).</li>
                                            <li>Implemented CI/CD pipeline using GitHub Actions.</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div>
                                    <h3 class="text-[11px] sm:text-xs font-black text-green-950 border-b-2 border-gray-200 pb-1.5 mb-3 uppercase tracking-widest">Education</h3>
                                    <div class="relative pl-4 border-l-2 border-gray-200">
                                        <div class="absolute w-2 h-2 bg-gray-300 rounded-full -left-[5px] top-1.5"></div>
                                        <div class="flex justify-between items-baseline mb-0.5">
                                            <h4 class="text-[11px] sm:text-xs font-black text-gray-900">B.Eng. Informatics Engineering</h4>
                                            <span class="text-[9px] sm:text-[10px] font-bold text-gray-500 whitespace-nowrap">2014 - 2018</span>
                                        </div>
                                        <div class="text-[10px] sm:text-[11px] font-bold text-gray-700">Institut Teknologi Bandung</div>
                                        <div class="text-[9px] sm:text-[10px] text-gray-500 mt-1 font-medium">GPA: 3.85 / 4.00 | Cum Laude</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- Right Column (Actions & Notes) --}}
        <div class="lg:col-span-1 space-y-6">
            
            {{-- Ubah Status Pelamar --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <svg class="w-5 h-5 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <h3 class="text-base font-bold text-gray-900">Change Applicant Status</h3>
                </div>

                <form action="#" method="POST" id="form-ubah-status">
                    <div class="mb-4">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">NEW STATUS</label>
                        <div class="relative">
                            <select class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5 appearance-none font-medium">
                                <option value="Applied">Applied</option>
                                <option value="HR Screening">HR Screening</option>
                                <option value="Assessment Phase" selected>Assessment Phase</option>
                                <option value="Technical Interview">Technical Interview</option>
                                <option value="User Interview">User Interview</option>
                                <option value="Offered">Offered</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">REASON FOR CHANGE</label>
                        <textarea rows="3" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-3 placeholder-gray-400" placeholder="Write the reason or notes for the status change..."></textarea>
                    </div>

                    <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-100">
                        <div class="flex items-center gap-2 text-sm text-gray-700 font-medium">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Send Email Notification
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-800"></div>
                        </label>
                    </div>

                    <button type="submit" class="w-full text-white bg-green-900 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
            Save Changes
        </button>
                </form>
            </div>

            {{-- Catatan Internal HR --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <svg class="w-5 h-5 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <h3 class="text-base font-bold text-gray-900">Internal HR Notes</h3>
                </div>

                {{-- Input Note --}}
                <div class="relative mb-6">
                    <input type="text" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-3 pr-12 placeholder-gray-400" placeholder="Add a personal note...">
                    <button class="absolute right-1.5 top-1.5 bottom-1.5 w-8 bg-green-900 hover:bg-green-800 text-white rounded flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                {{-- Notes List --}}
                <div class="space-y-4">
                    {{-- Note Item 1 --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Sarah+Recruiter&background=f3f4f6&color=374151" alt="Sarah" class="w-5 h-5 rounded-full">
                                <span class="text-xs font-bold text-gray-900">Sarah (Recruiter)</span>
                            </div>
                            <span class="text-[10px] text-gray-400">Today, 10:45 AM</span>
                        </div>
                        <div class="bg-gray-50 rounded-lg rounded-tl-none p-3.5 text-sm text-gray-700 border border-gray-100">
                            Technical assessment results are very impressive. Candidate showed strong grasp of architectural tradeoffs.
                        </div>
                    </div>

                    {{-- Note Item 2 --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name=Dodi+User&background=f3f4f6&color=374151" alt="Dodi" class="w-5 h-5 rounded-full">
                                <span class="text-xs font-bold text-gray-900">Dodi (User Manager)</span>
                            </div>
                            <span class="text-[10px] text-gray-400">25 Oct, 03:20 PM</span>
                        </div>
                        <div class="bg-gray-50 rounded-lg rounded-tl-none p-3.5 text-sm text-gray-700 border border-gray-100">
                            Shortlisted for technical interview. Background matches our new expansion project in Batam.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Next Event --}}
            <div class="bg-green-900 rounded-xl p-6 relative overflow-hidden shadow-md">
                {{-- Decorative background --}}
                <div class="absolute -right-6 -bottom-6 opacity-10">
                    <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-7 5h5v5h-5v-5z"></path></svg>
                </div>
                
                <div class="relative z-10">
                    <h3 class="text-[11px] font-bold text-green-300 uppercase tracking-wider mb-4">NEXT EVENT</h3>
                    
                    <div class="flex items-start gap-4">
                        <div class="bg-white/10 rounded-lg p-2.5 text-center min-w-[60px] border border-white/20">
                            <div class="text-2xl font-black text-white leading-none">28</div>
                            <div class="text-[10px] font-bold text-green-200 mt-1 uppercase tracking-wider">OCT</div>
                        </div>
                        <div class="pt-0.5">
                            <div class="text-white font-bold text-base mb-1">Technical Interview</div>
                            <div class="text-green-200 text-sm flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                14:00 - 15:30 (Online via Zoom)
                            </div>
                        </div>
                    </div>

                    <button class="w-full mt-6 bg-white/10 hover:bg-white/20 text-white border border-white/20 font-medium rounded-lg text-sm px-5 py-2.5 transition flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        View Full Schedule
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Penjadwalan Wawancara (Slide-over) -->
<div id="modal-jadwal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0" id="modal-jadwal-backdrop"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-2xl bg-white shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col" id="modal-jadwal-panel">
        <!-- Header -->
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
            <div>
                <h2 class="text-2xl font-extrabold text-green-900">Schedule Interview Session</h2>
                <p class="text-sm text-gray-500 mt-1">Fill in the details below to send an interview invitation to the candidate.</p>
            </div>
            <button type="button" id="btn-close-modal" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
        
        <!-- Body -->
        <div class="flex-1 overflow-y-auto px-8 py-6">
            <div class="grid grid-cols-5 gap-8">
                <!-- Form (Col 3) -->
                <div class="col-span-3 space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Candidate</label>
                        <input type="text" id="jadwal-kandidat" value="Budi Santoso, S.T." readonly class="w-full px-4 py-2 border border-gray-200 bg-gray-50 rounded-lg text-sm text-gray-700 font-semibold focus:outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Date & Time</label>
                            <input type="datetime-local" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Durasi</label>
                            <select class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                                <option>30 Minutes</option>
                                <option selected>60 Minutes</option>
                                <option>90 Minutes</option>
                                <option>120 Minutes</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Interview Type</label>
                        <div class="flex gap-2" id="tipe-wawancara-container">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="tipe_wawancara" value="technical" class="peer sr-only" checked>
                                <div class="px-4 py-2 text-center text-sm font-semibold text-gray-500 border border-gray-200 rounded-lg peer-checked:bg-green-50 peer-checked:text-green-700 peer-checked:border-green-300 hover:bg-gray-50 transition-colors">Technical</div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="tipe_wawancara" value="hr" class="peer sr-only">
                                <div class="px-4 py-2 text-center text-sm font-semibold text-gray-500 border border-gray-200 rounded-lg peer-checked:bg-green-50 peer-checked:text-green-700 peer-checked:border-green-300 hover:bg-gray-50 transition-colors">HR</div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="tipe_wawancara" value="user" class="peer sr-only">
                                <div class="px-4 py-2 text-center text-sm font-semibold text-gray-500 border border-gray-200 rounded-lg peer-checked:bg-green-50 peer-checked:text-green-700 peer-checked:border-green-300 hover:bg-gray-50 transition-colors">User</div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Location / Meeting Link</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                            <input type="text" placeholder="https://meet.google.com/..." class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Special Notes</label>
                        <textarea rows="3" placeholder="Add special instructions for the candidate or interviewer..." class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                </div>

                <!-- Sidebar (Col 2) -->
                <div class="col-span-2 space-y-4">
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <h3 class="flex items-center gap-2 text-xs font-bold text-gray-700 uppercase tracking-widest mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Invitation Preview
                        </h3>
                        <div class="space-y-3 opacity-50">
                            <div class="h-2 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-2 bg-gray-200 rounded w-1/2"></div>
                            <div class="h-16 bg-gray-200 rounded w-full mt-4"></div>
                            <p class="text-[10px] text-center text-gray-400 mt-2">Fill in the form to see the preview</p>
                        </div>
                    </div>

                    <div class="bg-green-900 rounded-xl p-5 text-white shadow-lg relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                        </div>
                        <h3 class="text-sm font-bold mb-3 relative z-10">Scheduling Guidelines</h3>
                        <ul class="space-y-2 text-xs text-green-100 relative z-10">
                            <li class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 mt-0.5 shrink-0 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Ensure the interviewer is available at that time.
                            </li>
                            <li class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 mt-0.5 shrink-0 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                The meeting link will be automatically attached to the calendar.
                            </li>
                            <li class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 mt-0.5 shrink-0 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                The candidate will receive a confirmation email immediately.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-100 px-8 py-4 flex items-center justify-between bg-white">
            <button type="button" id="btn-cancel-modal" class="text-sm font-semibold text-gray-600 hover:text-gray-900 px-4 py-2 transition-colors flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                Cancel
            </button>
            <div class="flex items-center gap-3">
                <button type="button" id="btn-submit-modal" class="inline-flex items-center gap-2 bg-green-800 hover:bg-green-900 text-white text-sm font-semibold px-6 py-2.5 rounded-lg shadow-md transition-all hover:shadow-lg active:scale-95">
                    Schedule Session & Save
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formUbahStatus = document.getElementById('form-ubah-status');
        const statusSelect = formUbahStatus.querySelector('select');
        
        const modalJadwal = document.getElementById('modal-jadwal');
        const modalBackdrop = document.getElementById('modal-jadwal-backdrop');
        const modalPanel = document.getElementById('modal-jadwal-panel');
        const btnCloseModal = document.getElementById('btn-close-modal');
        const btnCancelModal = document.getElementById('btn-cancel-modal');
        const btnSubmitModal = document.getElementById('btn-submit-modal');
        
        function openModal() {
            // Check interview type to set default radio
            const selectedStatus = statusSelect.value;
            if (selectedStatus === 'Technical Interview') {
                document.querySelector('input[name="tipe_wawancara"][value="technical"]').checked = true;
            } else if (selectedStatus === 'User Interview') {
                document.querySelector('input[name="tipe_wawancara"][value="user"]').checked = true;
            } else {
                document.querySelector('input[name="tipe_wawancara"][value="hr"]').checked = true;
            }

            modalJadwal.classList.remove('hidden');
            void modalJadwal.offsetWidth; // Reflow
            modalBackdrop.classList.remove('opacity-0');
            modalBackdrop.classList.add('opacity-100');
            modalPanel.classList.remove('translate-x-full');
            modalPanel.classList.add('translate-x-0');
        }

        function closeModal() {
            modalBackdrop.classList.remove('opacity-100');
            modalBackdrop.classList.add('opacity-0');
            modalPanel.classList.remove('translate-x-0');
            modalPanel.classList.add('translate-x-full');
            setTimeout(() => {
                modalJadwal.classList.add('hidden');
            }, 300);
        }

        function showToast(message, type = 'success') {
            const existing = document.getElementById('custom-toast');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.id = 'custom-toast';
            toast.className = `fixed top-6 left-1/2 -translate-x-1/2 z-[200] flex items-center gap-3 px-5 py-4 rounded-xl shadow-2xl transform transition-all duration-300 -translate-y-full opacity-0`;
            
            if (type === 'success') {
                toast.classList.add('bg-green-900', 'text-white', 'border', 'border-green-800');
                toast.innerHTML = `
                    <div class="w-8 h-8 bg-green-800 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold">Success!</h4>
                        <p class="text-xs text-green-200 mt-0.5">${message}</p>
                    </div>
                    <button type="button" class="ml-4 text-green-400 hover:text-white transition-colors p-1" onclick="this.parentElement.classList.remove('translate-y-0', 'opacity-100'); this.parentElement.classList.add('-translate-y-full', 'opacity-0'); setTimeout(() => this.parentElement.remove(), 300)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;
            }

            document.body.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('-translate-y-full', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            });

            setTimeout(() => {
                if (document.body.contains(toast)) {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('-translate-y-full', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 4000);
        }

        formUbahStatus.addEventListener('submit', function(e) {
            const selectedStatus = statusSelect.value;
            // Intercept form submission if the new status involves an interview
            if (selectedStatus.includes('Interview')) {
                e.preventDefault(); // Prevent standard submission
                openModal();
            } else {
                // Let the form submit normally if not an interview
                e.preventDefault();
                showToast('Applicant status successfully changed to ' + selectedStatus, 'success');
            }
        });

        btnCloseModal.addEventListener('click', closeModal);
        btnCancelModal.addEventListener('click', closeModal);
        modalBackdrop.addEventListener('click', closeModal);
        
        btnSubmitModal.addEventListener('click', function() {
            closeModal();
            showToast('Interview schedule created and invitation sent successfully!', 'success');
            // Here you would normally submit the combined data to the server
        });
    });
</script>
@endsection
