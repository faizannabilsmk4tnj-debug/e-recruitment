@extends('layouts.hr')

@section('title', 'Tim HR')
@section('page-title', 'Kelola HR')
@section('nav-tim', 'text-green-800 border-green-700 font-semibold')

@section('content')
<div class="px-8 py-8">

    <!-- Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-green-900">Tim HR</h1>
            <p class="text-gray-500 mt-1">Kelola akses dan peran anggota tim manajemen SDM Anda.</p>
        </div>
        <button id="btn-tambah-anggota" class="flex items-center gap-2 bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M19 8v6"/><path d="M22 11h-6"/></svg>
            Tambah Anggota Baru
        </button>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border-b-4 border-green-700 p-6">
            <p class="text-sm text-gray-500">Total Anggota</p>
            <p class="text-4xl font-extrabold text-green-900 mt-1">4</p>
        </div>
        <div class="bg-gray-50 rounded-xl border-b-4 border-gray-200 p-6">
            <p class="text-sm text-gray-500">HR Master</p>
            <p class="text-4xl font-extrabold text-gray-800 mt-1">1</p>
        </div>
        <div class="bg-white rounded-xl border-b-4 border-green-300 p-6">
            <p class="text-sm text-gray-500">HR Staff</p>
            <p class="text-4xl font-extrabold text-green-900 mt-1">3</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-green-900">Daftar Anggota</h2>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" id="search-member" placeholder="Cari nama atau email..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent w-64">
            </div>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Anggota</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Peran</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Status</th>
                    <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody id="member-table">

                <!-- Row 1: HR Master -->
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors member-row"
                    data-id="1" data-name="Gilbert Blythe" data-email="gilbert.blythe@ecogreen.com" data-role="HR Master" data-status="aktif">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-800 flex items-center justify-center text-white font-bold text-sm shrink-0">GB</div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">Gilbert Blythe</p>
                                <p class="text-xs text-gray-400">gilbert.blythe@ecogreen.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold text-purple-700 bg-purple-50 border border-purple-200 px-3 py-1 rounded-full">HR Master</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer toggle-status" checked>
                                <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-700 peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                            <span class="text-xs font-semibold text-green-700 status-label">AKTIF</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn-action text-gray-400 hover:text-gray-700 transition-colors p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                    </td>
                </tr>

                <!-- Row 2: HR -->
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors member-row"
                    data-id="2" data-name="Ahmad Riva'i" data-email="ahmad.rivai@ecogreen.com" data-role="HR" data-status="aktif">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm shrink-0">AR</div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">Ahmad Riva'i</p>
                                <p class="text-xs text-gray-400">ahmad.rivai@ecogreen.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold text-green-800 bg-green-50 border border-green-200 px-3 py-1 rounded-full">HR</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer toggle-status" checked>
                                <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-700 peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                            <span class="text-xs font-semibold text-green-700 status-label">AKTIF</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn-action text-gray-400 hover:text-gray-700 transition-colors p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                    </td>
                </tr>

                <!-- Row 3: HR nonaktif -->
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors member-row"
                    data-id="3" data-name="Siti Aminah" data-email="siti.aminah@ecogreen.com" data-role="HR" data-status="nonaktif">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-pink-400 flex items-center justify-center text-white font-bold text-sm shrink-0">SA</div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">Siti Aminah</p>
                                <p class="text-xs text-gray-400">siti.aminah@ecogreen.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold text-green-800 bg-green-50 border border-green-200 px-3 py-1 rounded-full">HR</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer toggle-status">
                                <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-700 peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                            <span class="text-xs font-semibold text-gray-400 status-label">NONAKTIF</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn-action text-gray-400 hover:text-gray-700 transition-colors p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                    </td>
                </tr>

                <!-- Row 4: HR -->
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors member-row"
                    data-id="4" data-name="Budi Santoso" data-email="budi.santoso@ecogreen.com" data-role="HR" data-status="aktif">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white font-bold text-sm shrink-0">BS</div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">Budi Santoso</p>
                                <p class="text-xs text-gray-400">budi.santoso@ecogreen.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold text-green-800 bg-green-50 border border-green-200 px-3 py-1 rounded-full">HR</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer toggle-status" checked>
                                <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-700 peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                            <span class="text-xs font-semibold text-green-700 status-label">AKTIF</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn-action text-gray-400 hover:text-gray-700 transition-colors p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
            <p class="text-xs text-gray-500">Menampilkan 4 dari 4 anggota</p>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 border border-gray-300 rounded-lg text-xs text-gray-400 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1.5 bg-green-800 text-white rounded-lg text-xs font-semibold">1</button>
                <button class="px-3 py-1.5 border border-gray-300 rounded-lg text-xs text-gray-400 cursor-not-allowed">Berikutnya</button>
            </div>
        </div>
    </div>
</div>

<!-- Dropdown action menu (Edit + Hapus only) -->
<div id="action-dropdown" class="hidden fixed bg-white border border-gray-200 rounded-xl shadow-lg z-50 w-40 py-1.5">
    <button id="action-edit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
        Edit Anggota
    </button>
    <div class="my-1 border-t border-gray-100"></div>
    <button id="action-hapus" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
        Hapus Anggota
    </button>
</div>

<!-- Modal: Tambah Anggota -->
<div id="modal-tambah" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 overflow-hidden shadow-2xl">
        <div class="bg-green-900 px-6 py-5 flex items-center justify-between">
            <h2 class="text-white font-bold">Tambah Anggota HR</h2>
            <button id="btn-close-tambah" class="text-green-300 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <input type="text" id="new-name" placeholder="Masukkan nama lengkap" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                <input type="email" id="new-email" placeholder="nama@ecogreen.com" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Peran</label>
                <select id="new-role" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                    <option value="">Pilih peran...</option>
                    <option value="HR">HR</option>
                    <option value="HR Master">HR Master</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Password Sementara</label>
                <input type="password" id="new-pass" placeholder="Min. 8 karakter" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <p class="text-[10px] text-gray-400 mt-1">Anggota dapat mengubah password setelah login pertama.</p>
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="btn-cancel-tambah" class="flex-1 border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Batal</button>
            <button id="btn-save-tambah" class="flex-1 bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Tambah Anggota</button>
        </div>
    </div>
</div>

<!-- Modal: Edit Anggota -->
<div id="modal-edit" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 overflow-hidden shadow-2xl">
        <div class="bg-green-900 px-6 py-5 flex items-center justify-between">
            <h2 class="text-white font-bold">Edit Anggota</h2>
            <button id="btn-close-edit" class="text-green-300 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <input type="text" id="edit-name" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                <input type="email" id="edit-email" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Peran</label>
                <select id="edit-role" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                    <option value="HR">HR</option>
                    <option value="HR Master">HR Master</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Password Baru <span class="text-gray-300 normal-case font-normal">(kosongkan jika tidak diubah)</span></label>
                <input type="password" id="edit-pass" placeholder="Min. 8 karakter" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="btn-cancel-edit" class="flex-1 border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Batal</button>
            <button id="btn-save-edit" class="flex-1 bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Simpan Perubahan</button>
        </div>
    </div>
</div>

<!-- Modal: Hapus Anggota -->
<div id="modal-hapus" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 text-center relative">
        <button id="btn-close-hapus" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Anggota?</h3>
        <p class="text-sm text-gray-500 mb-1">Anggota berikut akan dihapus dari sistem:</p>
        <p class="text-sm font-semibold text-gray-900 mb-5" id="hapus-name"></p>
        <div class="space-y-2.5">
            <button id="btn-confirm-hapus" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Ya, Hapus Anggota</button>
            <button id="btn-cancel-hapus" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Batal</button>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/hr/tim.js') }}"></script>
@endsection