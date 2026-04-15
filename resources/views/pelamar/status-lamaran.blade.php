@extends('layouts.pelamar')

@section('title', 'Status Lamaran')
@section('nav-status', 'active')

@section('content')

<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Riwayat & Tracking Lamaran</h1>
    <p class="text-gray-500 mt-1">Pantau perkembangan status lamaran pekerjaan Anda secara real-time.</p>
</div>

<!-- Search + Filters -->
<div class="flex items-center gap-3 mb-6">
    <div class="relative flex-1 max-w-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </div>
        <input type="text" id="search-input" placeholder="Cari posisi atau departemen..." class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
    </div>
    <div class="flex gap-2">
        <button class="filter-btn active bg-green-800 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors" data-filter="semua">Semua</button>
        <button class="filter-btn bg-white text-gray-600 border border-gray-300 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors" data-filter="terkirim">Terkirim</button>
        <button class="filter-btn bg-white text-gray-600 border border-gray-300 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors" data-filter="seleksi berkas">Seleksi Berkas</button>
        <button class="filter-btn bg-white text-gray-600 border border-gray-300 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors" data-filter="interview">Interview</button>
        <button class="filter-btn bg-white text-gray-600 border border-gray-300 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors" data-filter="selesai">Selesai</button>
    </div>
</div>

<!-- Main Grid -->
<div class="grid grid-cols-5 gap-6">

    <!-- LEFT: Table (3/5) -->
    <div class="col-span-3">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-3">Nama Posisi</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-3">Tanggal</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-3">Status</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="lamaran-tbody">
                    <tr class="border-b border-gray-50 hover:bg-green-50/30 transition-colors cursor-pointer lamaran-row" data-id="1" data-status="interview">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-sm text-green-800">Process Engineer</p>
                            <p class="text-xs text-gray-400">Operation Dept.</p>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600">12 Okt 2023</td>
                        <td class="px-5 py-4">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">INTERVIEW</span>
                        </td>
                        <td class="px-5 py-4">
                            <button class="btn-detail text-sm font-semibold text-green-700 hover:text-green-600 transition-colors" data-id="1">Detail ›</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-50 hover:bg-green-50/30 transition-colors cursor-pointer lamaran-row" data-id="2" data-status="seleksi berkas">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-sm text-gray-900">QA Technician</p>
                            <p class="text-xs text-gray-400">Quality Dept.</p>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600">05 Okt 2023</td>
                        <td class="px-5 py-4">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700">SELEKSI BERKAS</span>
                        </td>
                        <td class="px-5 py-4">
                            <button class="btn-detail text-sm font-semibold text-green-700 hover:text-green-600 transition-colors" data-id="2">Detail ›</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-green-50/30 transition-colors cursor-pointer lamaran-row" data-id="3" data-status="terkirim">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-sm text-gray-900">Human Resources Admin</p>
                            <p class="text-xs text-gray-400">HR & Legal</p>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600">28 Sep 2023</td>
                        <td class="px-5 py-4">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-100 text-gray-600">TERKIRIM</span>
                        </td>
                        <td class="px-5 py-4">
                            <button class="btn-detail text-sm font-semibold text-green-700 hover:text-green-600 transition-colors" data-id="3">Detail ›</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- RIGHT: Timeline Panel (2/5) -->
    <div class="col-span-2">
        <!-- Empty state -->
        <div class="bg-white rounded-xl border border-gray-200 p-8 text-center" id="timeline-empty">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/></svg>
            <p class="text-sm text-gray-400">Klik "Detail" pada lamaran untuk melihat timeline status.</p>
        </div>

        <!-- Timeline: Process Engineer (id=1) -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hidden timeline-panel" id="timeline-1">
            <div class="flex items-center gap-2 mb-5 pb-4 border-b border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/></svg>
                <h3 class="font-bold text-gray-900">Timeline Status</h3>
            </div>

            <!-- Timeline Items -->
            <div class="relative pl-6 space-y-6">
                <div class="absolute left-[7px] top-2 bottom-8 w-0.5 bg-gray-200"></div>

                <!-- Step 1: Terkirim ✓ -->
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                    <p class="font-semibold text-sm text-gray-900">Lamaran Terkirim</p>
                    <p class="text-xs text-gray-400 mt-0.5">12 Okt 2023, 10:45 WIB</p>
                    <p class="text-xs text-gray-500 mt-1">Dokumen berhasil diunggah dan diverifikasi sistem.</p>
                </div>

                <!-- Step 2: Seleksi ✓ -->
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                    <p class="font-semibold text-sm text-gray-900">Seleksi Berkas</p>
                    <p class="text-xs text-gray-400 mt-0.5">14 Okt 2023, 15:20 WIB</p>
                    <p class="text-xs text-gray-500 mt-1">Berkas Anda sedang ditinjau oleh tim rekrutmen.</p>
                </div>

                <!-- Step 3: Interview (Active) -->
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-blue-500 rounded-full border-2 border-white ring-4 ring-blue-100"></div>
                    <p class="font-semibold text-sm text-blue-700">Interview HR & User</p>
                    <p class="text-xs text-gray-400 mt-0.5">18 Okt 2023, 09:00 WIB</p>

                    <!-- Interview Detail Card -->
                    <div class="mt-3 bg-gray-50 rounded-lg p-4 space-y-2.5">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            <span class="text-sm font-medium text-gray-700">20 Okt 2023 • 13:00 WIB</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Kantor Pusat Ecogreen</span>
                                <a href="#" class="block text-xs text-green-700 hover:text-green-600 underline">Lihat di Google Maps</a>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 bg-amber-50 px-3 py-2 rounded-md">Harap membawa identitas diri (KTP) dan CV hardcopy.</p>
                    </div>
                </div>

                <!-- Step 4: Keputusan (Pending) -->
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-300 rounded-full border-2 border-white"></div>
                    <p class="font-semibold text-sm text-gray-400">Keputusan Akhir</p>
                    <p class="text-xs text-gray-400 mt-0.5 italic">Menunggu hasil interview.</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 space-y-2.5">
                <button class="w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
                    Konfirmasi Kehadiran
                </button>
                <button class="btn-tarik w-full border border-red-300 text-red-600 font-semibold py-2.5 rounded-lg text-sm hover:bg-red-50 transition-colors">
                    Tarik Lamaran
                </button>
                <p class="text-xs text-gray-400 text-center">Penarikan lamaran bersifat permanen.</p>
            </div>
        </div>

        <!-- Timeline: QA Technician (id=2) -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hidden timeline-panel" id="timeline-2">
            <div class="flex items-center gap-2 mb-5 pb-4 border-b border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/></svg>
                <h3 class="font-bold text-gray-900">Timeline Status</h3>
            </div>
            <div class="relative pl-6 space-y-6">
                <div class="absolute left-[7px] top-2 bottom-8 w-0.5 bg-gray-200"></div>
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                    <p class="font-semibold text-sm text-gray-900">Lamaran Terkirim</p>
                    <p class="text-xs text-gray-400 mt-0.5">05 Okt 2023, 14:30 WIB</p>
                </div>
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-amber-500 rounded-full border-2 border-white ring-4 ring-amber-100"></div>
                    <p class="font-semibold text-sm text-amber-700">Seleksi Berkas</p>
                    <p class="text-xs text-gray-400 mt-0.5">Berkas sedang ditinjau.</p>
                </div>
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-300 rounded-full border-2 border-white"></div>
                    <p class="font-semibold text-sm text-gray-400">Interview</p>
                    <p class="text-xs text-gray-400 mt-0.5 italic">Menunggu hasil seleksi.</p>
                </div>
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-300 rounded-full border-2 border-white"></div>
                    <p class="font-semibold text-sm text-gray-400">Keputusan Akhir</p>
                </div>
            </div>
            <div class="mt-8">
                <button class="btn-tarik w-full border border-red-300 text-red-600 font-semibold py-2.5 rounded-lg text-sm hover:bg-red-50 transition-colors">Tarik Lamaran</button>
                <p class="text-xs text-gray-400 text-center mt-2">Penarikan lamaran bersifat permanen.</p>
            </div>
        </div>

        <!-- Timeline: HR Admin (id=3) -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hidden timeline-panel" id="timeline-3">
            <div class="flex items-center gap-2 mb-5 pb-4 border-b border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/></svg>
                <h3 class="font-bold text-gray-900">Timeline Status</h3>
            </div>
            <div class="relative pl-6 space-y-6">
                <div class="absolute left-[7px] top-2 bottom-8 w-0.5 bg-gray-200"></div>
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-500 rounded-full border-2 border-white ring-4 ring-gray-100"></div>
                    <p class="font-semibold text-sm text-gray-700">Lamaran Terkirim</p>
                    <p class="text-xs text-gray-400 mt-0.5">28 Sep 2023, 09:15 WIB</p>
                    <p class="text-xs text-gray-500 mt-1">Menunggu proses review oleh HRD.</p>
                </div>
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-300 rounded-full border-2 border-white"></div>
                    <p class="font-semibold text-sm text-gray-400">Seleksi Berkas</p>
                </div>
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-300 rounded-full border-2 border-white"></div>
                    <p class="font-semibold text-sm text-gray-400">Interview</p>
                </div>
                <div class="relative">
                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-300 rounded-full border-2 border-white"></div>
                    <p class="font-semibold text-sm text-gray-400">Keputusan Akhir</p>
                </div>
            </div>
            <div class="mt-8">
                <button class="btn-tarik w-full border border-red-300 text-red-600 font-semibold py-2.5 rounded-lg text-sm hover:bg-red-50 transition-colors">Tarik Lamaran</button>
                <p class="text-xs text-gray-400 text-center mt-2">Penarikan lamaran bersifat permanen.</p>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== FILTER BUTTONS =====
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('bg-green-800', 'text-white', 'active');
                b.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-300');
            });
            this.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-300');
            this.classList.add('bg-green-800', 'text-white', 'active');

            const filter = this.dataset.filter;
            document.querySelectorAll('.lamaran-row').forEach(row => {
                if (filter === 'semua' || row.dataset.status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // ===== SEARCH =====
    document.getElementById('search-input').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.lamaran-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });

    // ===== DETAIL: Show Timeline =====
    document.querySelectorAll('.btn-detail, .lamaran-row').forEach(el => {
        el.addEventListener('click', function (e) {
            const row = this.closest('.lamaran-row') || this;
            const id = row.dataset.id || this.dataset.id;

            // Highlight active row
            document.querySelectorAll('.lamaran-row').forEach(r => r.classList.remove('bg-green-50'));
            row.classList.add('bg-green-50');

            // Show timeline
            document.getElementById('timeline-empty').classList.add('hidden');
            document.querySelectorAll('.timeline-panel').forEach(p => p.classList.add('hidden'));
            const panel = document.getElementById('timeline-' + id);
            if (panel) panel.classList.remove('hidden');
        });
    });

    // ===== TARIK LAMARAN =====
    document.querySelectorAll('.btn-tarik').forEach(btn => {
        btn.addEventListener('click', function () {
            if (confirm('Apakah Anda yakin ingin menarik lamaran ini? Tindakan ini bersifat PERMANEN dan tidak dapat dibatalkan.')) {
                alert('Lamaran berhasil ditarik. (demo)');
            }
        });
    });

});
</script>
@endsection