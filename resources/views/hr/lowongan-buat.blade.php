@extends('layouts.hr')

@section('title', 'Tambah Lowongan')
@section('page-title', 'Tambah Lowongan')
@section('nav-lowongan', 'text-green-800 border-green-700 font-semibold')

@section('content')
<div class="px-8 py-6">

    <!-- Breadcrumb + Title + Actions -->
    <div class="flex items-start justify-between mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-400 mb-2">
                <a href="/hr/lowongan" class="hover:text-green-700 transition-colors">Vacancies</a>
                <span>/</span>
                <span class="text-green-700 font-medium">Create New</span>
            </div>
            <h1 class="text-3xl font-extrabold text-green-800">Formulir Perekrutan</h1>
        </div>
        <div class="flex items-center gap-3 mt-2">
            <div class="flex items-center gap-1.5 text-xs text-gray-400" id="autosave-indicator">
                <svg id="autosave-icon" xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <span id="autosave-text">Draft tersimpan</span>
            </div>
            <button id="btn-preview" class="px-5 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg text-sm hover:bg-gray-50 transition-colors">Preview</button>
            <button id="btn-publish" class="px-5 py-2 bg-green-800 hover:bg-green-700 text-white font-semibold rounded-lg text-sm transition-colors">Publish Vacancy</button>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">

        <!-- LEFT: Form -->
        <div class="col-span-2 space-y-5">

            <!-- Dasar Jabatan -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <div class="flex items-center gap-2 mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    <h2 class="font-bold text-gray-900">Dasar Jabatan</h2>
                </div>

                <div class="mb-5">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Position Title</label>
                    <input type="text" id="f-title" placeholder="e.g. Senior Chemical Process Engineer"
                           class="w-full border-0 border-b border-gray-300 pb-2 text-sm focus:outline-none focus:border-green-600 bg-transparent transition-colors placeholder:text-gray-300">
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Job Category</label>
                        <div class="relative">
                            <select id="f-category" class="w-full appearance-none border-0 border-b border-gray-300 pb-2 text-sm focus:outline-none focus:border-green-600 bg-transparent pr-6">
                                <option>Production & Operations</option>
                                <option>Logistics</option>
                                <option>Technology</option>
                                <option>R&D Lab</option>
                                <option>Finance</option>
                                <option>HR & Legal</option>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute right-0 top-0.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Work Location</label>
                        <div class="relative">
                            <select id="f-location" class="w-full appearance-none border-0 border-b border-gray-300 pb-2 text-sm focus:outline-none focus:border-green-600 bg-transparent pr-6">
                                <option>Medan Plant (HQ)</option>
                                <option>Batam Plant</option>
                                <option>Jakarta Office</option>
                                <option>Singapore Office</option>
                                <option>Remote</option>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute right-0 top-0.5 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi & Kualifikasi -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <div class="flex items-center gap-2 mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <h2 class="font-bold text-gray-900">Deskripsi & Kualifikasi</h2>
                </div>

                <!-- Job Description -->
                <div class="mb-5">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Job Description</label>
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="flex items-center gap-1 px-3 py-2 border-b border-gray-100 bg-gray-50">
                            <button type="button" class="fmt-btn w-7 h-7 flex items-center justify-center rounded text-gray-500 hover:bg-gray-200 text-sm font-bold transition-colors" data-cmd="bold"><strong>B</strong></button>
                            <button type="button" class="fmt-btn w-7 h-7 flex items-center justify-center rounded text-gray-500 hover:bg-gray-200 text-sm italic transition-colors" data-cmd="italic"><em>I</em></button>
                            <button type="button" class="fmt-btn w-7 h-7 flex items-center justify-center rounded text-gray-500 hover:bg-gray-200 transition-colors" data-cmd="insertUnorderedList">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
                            </button>
                        </div>
                        <div id="f-description" contenteditable="true"
                             class="min-h-[120px] p-4 text-sm text-gray-600 focus:outline-none"
                             data-placeholder="Describe the daily responsibilities and goals for this role..."></div>
                    </div>
                </div>

                <!-- Requirements -->
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Requirements</label>
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="flex items-center gap-1 px-3 py-2 border-b border-gray-100 bg-gray-50">
                            <button type="button" class="fmt-btn w-7 h-7 flex items-center justify-center rounded text-gray-500 hover:bg-gray-200 text-sm font-bold transition-colors" data-cmd="bold" data-target="f-requirements"><strong>B</strong></button>
                            <button type="button" class="fmt-btn w-7 h-7 flex items-center justify-center rounded text-gray-500 hover:bg-gray-200 transition-colors" data-cmd="insertUnorderedList" data-target="f-requirements">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
                            </button>
                        </div>
                        <div id="f-requirements" contenteditable="true"
                             class="min-h-[120px] p-4 text-sm text-gray-600 focus:outline-none"
                             data-placeholder="Minimum education, years of experience, specific technical skills..."></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT: Sidebar panels -->
        <div class="space-y-5">

            <!-- Perencanaan -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Perencanaan</p>

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Target Quota</label>
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                        <input type="number" id="f-quota" value="1" min="1"
                               class="flex-1 px-3 py-2.5 text-sm focus:outline-none bg-transparent">
                        <span class="px-3 py-2.5 text-xs font-semibold text-gray-400 bg-gray-50 border-l border-gray-200">PERSONEL</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Application Deadline</label>
                    <input type="date" id="f-deadline"
                           class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
            </div>

            <!-- Kompensasi -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Kompensasi</p>

                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Show Salary Range</p>
                        <p class="text-[10px] text-gray-400">Publicly visible on career portal</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle-salary" class="sr-only peer" checked>
                        <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-700 peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    </label>
                </div>

                <div id="salary-range" class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Min (IDR)</label>
                        <input type="text" id="f-salary-min" value="10.000.000"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Max (IDR)</label>
                        <input type="text" id="f-salary-max" value="15.000.000"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Included Benefits</label>
                    <div class="flex flex-wrap gap-2" id="benefits-list">
                        <span class="benefit-tag flex items-center gap-1 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            Health Insurance
                            <button class="remove-benefit text-green-500 hover:text-red-500 transition-colors ml-0.5">×</button>
                        </span>
                        <span class="benefit-tag flex items-center gap-1 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            Meal Allowance
                            <button class="remove-benefit text-green-500 hover:text-red-500 transition-colors ml-0.5">×</button>
                        </span>
                        <span class="benefit-tag flex items-center gap-1 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            Transport
                            <button class="remove-benefit text-green-500 hover:text-red-500 transition-colors ml-0.5">×</button>
                        </span>
                        <button id="btn-add-benefit" class="text-xs text-green-700 border border-dashed border-green-300 px-2.5 py-1 rounded-full hover:bg-green-50 transition-colors">+ Add Benefit</button>
                    </div>
                </div>
            </div>

            <!-- Header Image -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Header Image</p>

                <!-- Upload area -->
                <div id="upload-area" class="border-2 border-dashed border-green-300 bg-green-50 rounded-xl p-6 text-center cursor-pointer hover:bg-green-100 transition-colors mb-3" id="img-upload-area">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600 mx-auto mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    <p class="text-xs font-bold text-green-700">UPLOAD MEDIA</p>
                    <p class="text-[10px] text-gray-400 mt-1">1200 × 630px recommended</p>
                    <input type="file" id="header-image-input" accept="image/*" class="hidden">
                </div>

                <!-- Default preview -->
                <div class="relative rounded-xl overflow-hidden" id="img-preview-wrap">
                    <div class="w-full h-28 bg-gradient-to-br from-green-900 to-green-700 flex items-center justify-center" id="img-preview-default">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-green-400 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m2 10 20 0"/></svg>
                    </div>
                    <img id="img-preview" src="" alt="" class="hidden w-full h-28 object-cover">
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-[10px] text-gray-400" id="img-filename">default_factory.jpg</span>
                        <button id="btn-remove-img" class="text-gray-400 hover:text-red-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Preview -->
<div id="modal-preview" class="fixed inset-0 bg-black/70 z-[60] flex items-center justify-center hidden p-4">
    <div class="bg-gray-50 rounded-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl">

        <div class="bg-white px-6 py-4 border-b border-gray-200 flex items-center justify-between shrink-0">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Preview Lowongan</p>
                <p class="text-xs text-gray-500 mt-0.5">Tampilan di halaman publik / portal pelamar</p>
            </div>
            <button id="btn-close-preview" class="text-gray-400 hover:text-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <div class="overflow-y-auto flex-1">
            <!-- Header Image -->
            <div class="relative h-44 overflow-hidden">
                <div id="prev-header-default" class="w-full h-full bg-gradient-to-br from-green-900 to-green-700 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-green-400 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m2 10 20 0"/></svg>
                </div>
                <img id="prev-header-img" src="" alt="" class="hidden w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
            </div>

            <!-- Job Card -->
            <div class="bg-white mx-6 -mt-8 relative rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">
                <div class="mb-4">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="text-[10px] font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded uppercase" id="prev-category">Production &amp; Operations</span>
                    </div>
                    <h1 class="text-2xl font-extrabold text-gray-900" id="prev-title">(Belum Diisi)</h1>
                    <div class="flex items-center flex-wrap gap-x-4 gap-y-1 mt-2 text-xs text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span id="prev-location">Medan Plant (HQ)</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            Deadline: <span id="prev-deadline">-</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            <span id="prev-quota">1</span> Personel
                        </span>
                    </div>
                </div>

                <div id="prev-salary-wrap" class="bg-green-50 border border-green-100 rounded-xl p-4 mb-5">
                    <p class="text-[10px] font-bold text-green-700 uppercase tracking-wider mb-1">Rentang Gaji</p>
                    <p class="text-lg font-bold text-green-900">Rp <span id="prev-salary-min">10.000.000</span> &ndash; Rp <span id="prev-salary-max">15.000.000</span></p>
                </div>

                <div class="mb-5">
                    <h3 class="font-bold text-gray-900 mb-2">Deskripsi Pekerjaan</h3>
                    <div class="text-sm text-gray-600 leading-relaxed" id="prev-description">
                        <em class="text-gray-400">Belum ada deskripsi.</em>
                    </div>
                </div>

                <div class="mb-5">
                    <h3 class="font-bold text-gray-900 mb-2">Kualifikasi</h3>
                    <div class="text-sm text-gray-600 leading-relaxed" id="prev-requirements">
                        <em class="text-gray-400">Belum ada persyaratan.</em>
                    </div>
                </div>

                <div id="prev-benefits-wrap" class="mb-5">
                    <h3 class="font-bold text-gray-900 mb-2">Benefit &amp; Tunjangan</h3>
                    <div class="flex flex-wrap gap-2" id="prev-benefits"></div>
                </div>

                <div class="border-t border-gray-100 pt-5 flex items-center justify-between">
                    <p class="text-xs text-gray-400">Ini hanya preview untuk HR</p>
                    <button class="bg-green-800 text-white font-semibold px-5 py-2.5 rounded-lg text-sm cursor-not-allowed opacity-60" disabled>
                        Lamar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Benefit -->
<div id="modal-benefit" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-80 mx-4 p-6 relative">
        <button id="btn-close-benefit" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <h3 class="font-bold text-gray-900 mb-4">Tambah Benefit</h3>
        <input type="text" id="benefit-input" placeholder="e.g. BPJS Kesehatan" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 mb-4">
        <button id="btn-confirm-benefit" class="w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Tambah</button>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/hr/lowongan-buat.js') }}"></script>
@endsection