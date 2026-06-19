@extends('layouts.hr')

@section('title', 'Applicant Detail')
@section('page-title', 'Applicant Detail')
@section('nav-pelamar', 'text-green-800 border-green-800')

@php
    $empty = 'Belum diisi';
    $statusLabels = [
        'applied' => 'Submitted',
        'reviewed' => 'Reviewed',
        'shortlisted' => 'Shortlisted',
        'interview' => 'Interview',
        'offered' => 'Accepted',
        'rejected' => 'Rejected',
        'withdrawn' => 'Withdrawn',
    ];
    $statusClasses = [
        'applied' => 'bg-gray-100 text-gray-700 border-gray-200',
        'reviewed' => 'bg-purple-50 text-purple-700 border-purple-200',
        'shortlisted' => 'bg-amber-50 text-amber-700 border-amber-200',
        'interview' => 'bg-blue-50 text-blue-700 border-blue-200',
        'offered' => 'bg-green-50 text-green-700 border-green-200',
        'rejected' => 'bg-red-50 text-red-700 border-red-200',
        'withdrawn' => 'bg-gray-100 text-gray-500 border-gray-200',
    ];
    $latestRole = $workExperiences->first()?->position ?? $user->job_title ?? 'Applicant';
    $cityLine = collect([optional($profile)->city, optional($profile)->province])->filter()->implode(', ');
    $ktpSameAsDom = optional($profile)->ktp_address
        && optional($profile)->ktp_address === optional($profile)->dom_address
        && optional($profile)->ktp_city === optional($profile)->dom_city
        && optional($profile)->ktp_province === optional($profile)->dom_province;
@endphp

@section('content')
<div class="px-8 py-8 max-w-7xl mx-auto">
    <div class="mb-6 flex items-center text-sm text-gray-500 gap-2">
        <a href="/hr/pelamar" class="hover:text-green-800 transition-colors">Applicants</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">{{ $user->name }}</span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col lg:flex-row items-start gap-6">
        <img src="{{ optional($profile)->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=14532d&color=fff&size=128' }}"
             alt="{{ $user->name }}" class="w-28 h-28 rounded-xl object-cover shadow-sm">

        <div class="flex-1 pt-1">
            <div class="flex flex-wrap items-center gap-3">
                <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                <span id="current-status-badge" class="text-[11px] font-bold px-3 py-1 rounded-full border uppercase {{ $statusClasses[$application->status] ?? $statusClasses['applied'] }}">
                    {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
                </span>
            </div>
            <div class="text-gray-600 mt-1 mb-4 font-medium">{{ $latestRole }} for {{ optional($application->job)->title ?? $empty }}</div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-900">Email:</span> {{ $user->email }}
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-900">Phone:</span> {{ $user->phone ?? optional($profile)->phone ?? $empty }}
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-900">Location:</span> {{ $cityLine ?: $empty }}
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-900">Applied:</span> {{ optional($application->created_at)->format('d M Y H:i') ?? $empty }}
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2 w-full lg:w-auto">
            <a href="/hr/pelamar/{{ $application->id }}/cv-preview" target="_blank"
               class="inline-flex justify-center items-center gap-2 border border-green-200 bg-green-50 text-green-800 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-green-100 transition">
                Open CV
            </a>
            <button type="button" id="btn-open-interview"
                    class="inline-flex justify-center items-center gap-2 bg-green-800 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-green-900 transition">
                Schedule Interview
            </button>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NIK</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->nik ?? $empty }}</div></div>
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Full Name</div><div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div></div>
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Gender</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->gender ? ucfirst($profile->gender) : $empty }}</div></div>
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Marital Status</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->marital_status ? ucfirst($profile->marital_status) : $empty }}</div></div>
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Birth</div><div class="text-sm font-semibold text-gray-900">{{ collect([optional($profile)->birth_place, optional(optional($profile)->birth_date)->format('d M Y')])->filter()->implode(', ') ?: $empty }}</div></div>
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Age</div><div class="text-sm font-semibold text-gray-900">{{ $age }}</div></div>
                    <div class="md:col-span-2"><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Bio</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->bio ?? $empty }}</div></div>
                </div>
            </section>

            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Education</h3>
                @forelse($educations as $education)
                    <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <div class="font-bold text-gray-900">{{ $education->degree ?? $empty }}{{ $education->major ? ' - ' . $education->major : '' }}</div>
                                <div class="text-sm text-gray-600">{{ $education->institution ?? $empty }}</div>
                            </div>
                            <div class="text-sm text-gray-500">{{ $education->start_year ?? '?' }} - {{ $education->end_year ?? '?' }}</div>
                        </div>
                        <div class="text-sm text-gray-500 mt-2">GPA: {{ $education->gpa ?? optional($profile)->gpa ?? $empty }}</div>
                    </div>
                @empty
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                        <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Latest Education</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->latest_education ? strtoupper($profile->latest_education) : $empty }}</div></div>
                        <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">School / University</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->school_name ?? $empty }}</div></div>
                        <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Graduation</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->education_completed_at ?? $empty }}</div></div>
                        <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">GPA</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->gpa ?? $empty }}</div></div>
                    </div>
                @endforelse
            </section>

            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Address Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="bg-green-50/40 border border-green-100 rounded-xl p-5">
                        <h4 class="text-sm font-bold text-green-900 tracking-wider mb-4">ID Card Address</h4>
                        <div class="space-y-3 text-sm">
                            <div><span class="font-semibold text-gray-900">Province:</span> {{ optional($profile)->ktp_province ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">City:</span> {{ optional($profile)->ktp_city ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">District:</span> {{ optional($profile)->ktp_district ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">Sub-district:</span> {{ optional($profile)->ktp_subdistrict ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">Address:</span> {{ optional($profile)->ktp_address ?? optional($profile)->address ?? $empty }}</div>
                        </div>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-5">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <h4 class="text-sm font-bold text-green-900 tracking-wider">Domicile Address</h4>
                            @if($ktpSameAsDom)
                                <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Same as ID</span>
                            @endif
                        </div>
                        <div class="space-y-3 text-sm">
                            <div><span class="font-semibold text-gray-900">Province:</span> {{ optional($profile)->dom_province ?? optional($profile)->province ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">City:</span> {{ optional($profile)->dom_city ?? optional($profile)->city ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">District:</span> {{ optional($profile)->dom_district ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">Sub-district:</span> {{ optional($profile)->dom_subdistrict ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">Address:</span> {{ optional($profile)->dom_address ?? optional($profile)->address ?? $empty }}</div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Experience & Skills</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Work Experience</h4>
                        @forelse($workExperiences as $work)
                            <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                                <div class="font-bold text-gray-900">{{ $work->position ?? $empty }}</div>
                                <div class="text-sm text-gray-600">{{ $work->company_name ?? $empty }} | {{ optional($work->start_date)->format('M Y') ?? '?' }} - {{ $work->is_current ? 'Sekarang' : (optional($work->end_date)->format('M Y') ?? '?') }}</div>
                                @if($work->description)<p class="text-sm text-gray-500 mt-2">{{ $work->description }}</p>@endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada pengalaman kerja.</p>
                        @endforelse
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Organization Experience</h4>
                        @forelse($organizationExperiences as $org)
                            <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                                <div class="font-bold text-gray-900">{{ $org->position ?? $empty }}</div>
                                <div class="text-sm text-gray-600">{{ $org->organization_name ?? $empty }} | {{ optional($org->start_date)->format('M Y') ?? '?' }} - {{ optional($org->end_date)->format('M Y') ?? 'Sekarang' }}</div>
                                @if($org->description)<p class="text-sm text-gray-500 mt-2">{{ $org->description }}</p>@endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada pengalaman organisasi.</p>
                        @endforelse
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Skills</h4>
                        <div class="flex flex-wrap gap-2">
                            @forelse($skills as $skill)
                                <span class="text-xs font-semibold text-green-800 bg-green-50 border border-green-200 px-3 py-1 rounded-full">{{ $skill->skill_name }}</span>
                            @empty
                                <span class="text-sm text-gray-400">Belum ada skill.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">CV Preview</h3>
                    <a href="/hr/pelamar/{{ $application->id }}/cv-preview" target="_blank" class="text-sm text-green-800 font-bold hover:underline">Open full CV</a>
                </div>
                <div class="bg-gray-100 rounded-xl p-4 overflow-hidden">
                    <iframe src="/hr/pelamar/{{ $application->id }}/cv-preview" title="CV {{ $user->name }}" class="w-full h-[720px] bg-white rounded border border-gray-200"></iframe>
                </div>
            </section>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Update Status</h3>
                <form id="form-ubah-status" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Status</label>
                        <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            @foreach($statusLabels as $value => $label)
                                <option value="{{ $value }}" @selected($application->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Reason / Note</label>
                        <textarea name="reason" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Catatan perubahan status...">{{ $application->hr_notes }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-green-800 hover:bg-green-900 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">Save Status</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Internal Note</h3>
                <form id="form-add-note" class="space-y-4">
                    @csrf
                    <textarea name="note" rows="3" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Tulis catatan HR..."></textarea>
                    <button type="submit" class="w-full border border-green-200 bg-green-50 text-green-800 text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-green-100 transition">Add Note</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Activity Log</h3>
                <div id="activity-log" class="space-y-4 max-h-[420px] overflow-y-auto pr-1">
                    @forelse($statusLogs as $log)
                        <div class="border-l-2 border-green-700 pl-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-xs font-bold text-gray-900">{{ $log->changer_name }}</div>
                                <div class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}</div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">{{ $statusLabels[$log->old_status] ?? $log->old_status }} -> {{ $statusLabels[$log->new_status] ?? $log->new_status }}</div>
                            @if($log->reason)<div class="text-sm text-gray-700 mt-2 bg-gray-50 rounded-lg p-3">{{ $log->reason }}</div>@endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Belum ada aktivitas.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-green-900 rounded-xl p-6 relative overflow-hidden shadow-md">
                <h3 class="text-[11px] font-bold text-green-300 uppercase tracking-wider mb-4">Next Event</h3>
                @if($nextInterview)
                    <div class="flex items-start gap-4">
                        <div class="bg-white/10 rounded-lg p-2.5 text-center min-w-[60px] border border-white/20">
                            <div class="text-2xl font-black text-white leading-none">{{ $nextInterview->scheduled_at->format('d') }}</div>
                            <div class="text-[10px] font-bold text-green-200 mt-1 uppercase tracking-wider">{{ $nextInterview->scheduled_at->format('M') }}</div>
                        </div>
                        <div class="pt-0.5">
                            <div class="text-white font-bold text-base mb-1">{{ ucfirst($nextInterview->interview_type) }} Interview</div>
                            <div class="text-green-200 text-sm">{{ $nextInterview->scheduled_at->format('H:i') }} | {{ $nextInterview->duration_minutes }} minutes</div>
                            <div class="text-green-100 text-xs mt-2">{{ $nextInterview->location_or_link ?: $empty }}</div>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-green-100">Belum ada jadwal interview berikutnya.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="modal-jadwal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" id="modal-jadwal-backdrop"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-xl bg-white shadow-2xl flex flex-col">
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
            <div>
                <h2 class="text-2xl font-extrabold text-green-900">Schedule Interview</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $user->name }}</p>
            </div>
            <button type="button" id="btn-close-modal" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-interview" class="flex-1 flex flex-col">
            @csrf
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-5">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Candidate</label>
                    <input type="text" value="{{ $user->name }}" readonly class="w-full px-4 py-2 border border-gray-200 bg-gray-50 rounded-lg text-sm text-gray-700 font-semibold focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Date & Time</label>
                        <input name="scheduled_at" type="datetime-local" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Duration</label>
                        <select name="duration_minutes" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            <option value="30">30 Minutes</option>
                            <option value="60" selected>60 Minutes</option>
                            <option value="90">90 Minutes</option>
                            <option value="120">120 Minutes</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Interview Type</label>
                    <select name="interview_type" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                        <option value="phone">Phone</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Location / Meeting Link</label>
                    <input name="location_or_link" type="text" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="https://meet.google.com/...">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Catatan interview..."></textarea>
                </div>
            </div>
            <div class="border-t border-gray-100 px-8 py-4 flex items-center justify-between bg-white">
                <button type="button" id="btn-cancel-modal" class="text-sm font-semibold text-gray-600 hover:text-gray-900 px-4 py-2 transition-colors">Cancel</button>
                <button type="submit" class="bg-green-800 hover:bg-green-900 text-white text-sm font-semibold px-6 py-2.5 rounded-lg shadow-md transition">Schedule Session</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const statusLabels = @json($statusLabels);
    const statusClasses = @json($statusClasses);
    const applicationId = {{ $application->id }};

    function showToast(message, type = 'success') {
        const oldToast = document.getElementById('custom-toast');
        if (oldToast) oldToast.remove();

        const toast = document.createElement('div');
        toast.id = 'custom-toast';
        toast.className = 'fixed top-6 left-1/2 -translate-x-1/2 z-[200] px-5 py-3 rounded-xl shadow-2xl text-sm font-semibold transition-all';
        toast.classList.add(type === 'success' ? 'bg-green-900' : 'bg-red-700', 'text-white');
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    async function submitJson(url, payload) {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(payload),
        });

        const data = await response.json().catch(() => ({}));
        if (!response.ok) {
            const message = data.message || Object.values(data.errors || {}).flat()[0] || 'Request failed.';
            throw new Error(message);
        }
        return data;
    }

    document.getElementById('form-ubah-status').addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        try {
            const data = await submitJson(`/hr/pelamar/${applicationId}/status`, {
                status: formData.get('status'),
                reason: formData.get('reason'),
            });

            const badge = document.getElementById('current-status-badge');
            badge.textContent = statusLabels[data.status] || data.status;
            badge.className = 'text-[11px] font-bold px-3 py-1 rounded-full border uppercase ' + (statusClasses[data.status] || statusClasses.applied);
            showToast(data.message || 'Status berhasil diperbarui.');
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    document.getElementById('form-add-note').addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        try {
            const data = await submitJson(`/hr/pelamar/${applicationId}/note`, {
                note: formData.get('note'),
            });
            this.reset();
            showToast(data.message || 'Catatan berhasil disimpan.');
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    const modal = document.getElementById('modal-jadwal');
    const openModal = () => modal.classList.remove('hidden');
    const closeModal = () => modal.classList.add('hidden');

    document.getElementById('btn-open-interview').addEventListener('click', openModal);
    document.getElementById('btn-close-modal').addEventListener('click', closeModal);
    document.getElementById('btn-cancel-modal').addEventListener('click', closeModal);
    document.getElementById('modal-jadwal-backdrop').addEventListener('click', closeModal);

    document.getElementById('form-interview').addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        try {
            const data = await submitJson(`/hr/pelamar/${applicationId}/interview`, {
                scheduled_at: formData.get('scheduled_at'),
                duration_minutes: formData.get('duration_minutes'),
                interview_type: formData.get('interview_type'),
                location_or_link: formData.get('location_or_link'),
                notes: formData.get('notes'),
            });
            closeModal();
            showToast(data.message || 'Interview berhasil dijadwalkan.');
            setTimeout(() => window.location.reload(), 900);
        } catch (error) {
            showToast(error.message, 'error');
        }
    });
});
</script>
@endsection
