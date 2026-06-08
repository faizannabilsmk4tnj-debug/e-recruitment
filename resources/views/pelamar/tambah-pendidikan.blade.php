@extends('layouts.pelamar')

@section('title', 'Add Education')
@section('nav-pendidikan', 'active')

@section('content')

<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
    <a href="/pelamar/pendidikan" class="hover:text-green-700 transition-colors">Education</a>
    <span>›</span>
    <span class="text-gray-700 font-medium">{{ $education ? 'Edit' : 'Add New' }}</span>
</div>

<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">{{ $education ? 'Edit Education History' : 'Add Education History' }}</h1>
    <p class="text-gray-500 mt-1">Fill in the form below with your education information.</p>
</div>

@if ($errors->any())
    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <p class="font-semibold">Mohon periksa kembali form pengisian Anda. Ada beberapa kesalahan data.</p>
    </div>
@endif

<!-- Form -->
<form method="POST" action="{{ $education ? route('pelamar.pendidikan.update', $education) : route('pelamar.pendidikan.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-gray-200 p-8">
    @csrf
    @if ($education)
        @method('PUT')
    @endif

    <div class="space-y-6">

        <!-- Nama Sekolah & Tingkat -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="sekolah" class="block text-sm font-medium text-gray-700 mb-1.5">School / University Name <span class="text-red-500">*</span></label>
                <input type="text" id="sekolah" name="institution" placeholder="Example: Bandung Institute of Technology" value="{{ old('institution', $education?->institution) }}" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('institution') border-red-500 focus:ring-red-500 @enderror">
                @error('institution')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-1.5">Education Level <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select id="tingkat" name="degree" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none @error('degree') border-red-500 focus:ring-red-500 @enderror">
                        <option value="">Select Level</option>
                        <option value="SMA" @selected(old('degree', $education?->degree) === 'SMA')>SMA/SMK</option>
                        <option value="D3" @selected(old('degree', $education?->degree) === 'D3')>D3</option>
                        <option value="S1" @selected(old('degree', $education?->degree) === 'S1')>S1</option>
                        <option value="S2" @selected(old('degree', $education?->degree) === 'S2')>S2</option>
                        <option value="S3" @selected(old('degree', $education?->degree) === 'S3')>S3</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                @error('degree')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Jurusan & Nomor Ijazah -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-1.5">Major / Field of Study</label>
                <input type="text" id="jurusan" name="major" placeholder="Example: Mechanical Engineering" value="{{ old('major', $education?->major) }}" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('major') border-red-500 focus:ring-red-500 @enderror">
                @error('major')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="no-ijazah" class="block text-sm font-medium text-gray-700 mb-1.5">Diploma / Certificate Number</label>
                <input type="text" id="no-ijazah" name="certificate_number" placeholder="Example: 12345/UN6.1/2022" value="{{ old('certificate_number', $education?->certificate_number) }}" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('certificate_number') border-red-500 focus:ring-red-500 @enderror">
                @error('certificate_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- IPK / Nilai -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="ipk" class="block text-sm font-medium text-gray-700 mb-1.5">GPA / Average Grade</label>
                <input type="text" id="ipk" name="gpa" placeholder="Example: 3.75" value="{{ old('gpa', $education?->gpa) }}" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('gpa') border-red-500 focus:ring-red-500 @enderror">
                @error('gpa')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div></div>
        </div>

        <!-- Tanggal Mulai & Selesai -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="start_year" class="block text-sm font-medium text-gray-700 mb-1.5">Start Year <span class="text-red-500">*</span></label>
                <input type="number" id="start_year" name="start_year" min="1950" max="{{ date('Y') + 1 }}" placeholder="Example: 2018" value="{{ old('start_year', $education?->start_year) }}" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('start_year') border-red-500 focus:ring-red-500 @enderror">
                @error('start_year')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="end_year" class="block text-sm font-medium text-gray-700 mb-1.5">End Year <span class="text-gray-400 font-normal">(Leave blank if still ongoing)</span></label>
                <input type="number" id="end_year" name="end_year" min="1950" max="{{ date('Y') + 1 }}" placeholder="Example: 2022" value="{{ old('end_year', $education?->end_year) }}" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('end_year') border-red-500 focus:ring-red-500 @enderror">
                @error('end_year')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Upload Ijazah & SKHU -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload Diploma Photo</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-5 text-center hover:border-green-400 transition-colors cursor-pointer" id="drop-ijazah">
                    <div id="placeholder-ijazah" class="{{ $education?->diploma_file ? 'hidden' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300 mx-auto mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        <p class="text-xs text-gray-500">Drag file or click to upload</p>
                        <p class="text-xs text-gray-400">PDF, JPG, PNG (Max. 2MB)</p>
                    </div>
                    <div id="preview-ijazah" class="{{ $education?->diploma_file ? '' : 'hidden' }}">
                        <p class="text-sm text-green-700 font-medium truncate" id="name-ijazah">
                            @if ($education?->diploma_file)
                                {{ basename($education->diploma_file) }}
                            @endif
                        </p>
                        @if ($education?->diploma_file)
                            <a href="{{ asset('storage/' . $education->diploma_file) }}" target="_blank" class="text-xs text-green-600 font-semibold block mt-1 hover:underline" onclick="event.stopPropagation()">View Current Diploma</a>
                        @endif
                        <button type="button" class="remove-file text-xs text-red-500 mt-1" data-target="ijazah">Delete</button>
                    </div>
                    <input type="file" id="file-ijazah" name="diploma_file" accept="image/jpeg,image/png,application/pdf" class="hidden">
                </div>
                @error('diploma_file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload SKHU Photo <span class="text-gray-400 font-normal">(Optional)</span></label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-5 text-center hover:border-green-400 transition-colors cursor-pointer" id="drop-skhu">
                    <div id="placeholder-skhu" class="{{ $education?->skhu_file ? 'hidden' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300 mx-auto mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        <p class="text-xs text-gray-500">Drag file or click to upload</p>
                        <p class="text-xs text-gray-400">PDF, JPG, PNG (Max. 2MB)</p>
                    </div>
                    <div id="preview-skhu" class="{{ $education?->skhu_file ? '' : 'hidden' }}">
                        <p class="text-sm text-green-700 font-medium truncate" id="name-skhu">
                            @if ($education?->skhu_file)
                                {{ basename($education->skhu_file) }}
                            @endif
                        </p>
                        @if ($education?->skhu_file)
                            <a href="{{ asset('storage/' . $education->skhu_file) }}" target="_blank" class="text-xs text-green-600 font-semibold block mt-1 hover:underline" onclick="event.stopPropagation()">View Current SKHU</a>
                        @endif
                        <button type="button" class="remove-file text-xs text-red-500 mt-1" data-target="skhu">Delete</button>
                    </div>
                    <input type="file" id="file-skhu" name="skhu_file" accept="image/jpeg,image/png,application/pdf" class="hidden">
                </div>
                @error('skhu_file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 pt-4 justify-end">
            <a href="/pelamar/pendidikan" class="border border-gray-300 text-gray-700 font-semibold px-8 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-8 py-2.5 rounded-lg text-sm transition-colors">
                {{ $education ? 'Save Changes' : 'Add Education' }}
            </button>
        </div>

    </div>
</form>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // File upload handlers for both zones
    ['ijazah', 'skhu'].forEach(type => {
        const drop = document.getElementById('drop-' + type);
        const input = document.getElementById('file-' + type);
        const placeholder = document.getElementById('placeholder-' + type);
        const preview = document.getElementById('preview-' + type);
        const nameEl = document.getElementById('name-' + type);

        drop.addEventListener('click', () => input.click());
        drop.addEventListener('dragover', (e) => { e.preventDefault(); drop.classList.add('border-green-500', 'bg-green-50'); });
        drop.addEventListener('dragleave', () => drop.classList.remove('border-green-500', 'bg-green-50'));
        drop.addEventListener('drop', (e) => {
            e.preventDefault(); drop.classList.remove('border-green-500', 'bg-green-50');
            if (e.dataTransfer.files.length) { input.files = e.dataTransfer.files; showFile(e.dataTransfer.files[0]); }
        });
        input.addEventListener('change', (e) => { if (e.target.files[0]) showFile(e.target.files[0]); });

        function showFile(file) {
            if (file.size > 2 * 1024 * 1024) { alert('File exceeds 2MB limit.'); return; }
            nameEl.textContent = file.name;
            placeholder.classList.add('hidden');
            preview.classList.remove('hidden');
        }
    });

    // Remove file buttons
    document.querySelectorAll('.remove-file').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const type = btn.dataset.target;
            document.getElementById('file-' + type).value = '';
            document.getElementById('preview-' + type).classList.add('hidden');
            document.getElementById('placeholder-' + type).classList.remove('hidden');
        });
    });
});
</script>
@endsection