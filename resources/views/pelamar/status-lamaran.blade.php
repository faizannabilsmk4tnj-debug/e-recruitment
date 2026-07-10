@extends('layouts.pelamar')

@section('title', 'Application Status')
@section('nav-status', 'active')

@section('content')

<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Application History & Tracking</h1>
    <p class="text-gray-500 mt-1">Track the development of your job application status in real-time.</p>
</div>

<!-- Search + Filters -->
<div class="flex items-center gap-3 mb-6">
    <div class="relative flex-1 max-w-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </div>
        <input type="text" id="search-input" placeholder="Search position or department..." class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
    </div>
    <div class="flex gap-2">
        <button class="filter-btn active bg-green-800 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors" data-filter="all">All</button>
        <button class="filter-btn bg-white text-gray-600 border border-gray-300 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors" data-filter="submitted">Submitted</button>
        <button class="filter-btn bg-white text-gray-600 border border-gray-300 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors" data-filter="shortlisted">Shortlisted</button>
        <button class="filter-btn bg-white text-gray-600 border border-gray-300 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors" data-filter="interview">Interview</button>
        <button class="filter-btn bg-white text-gray-600 border border-gray-300 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors" data-filter="accepted">Accepted</button>
        <button class="filter-btn bg-white text-gray-600 border border-gray-300 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors" data-filter="rejected">Rejected</button>
        <button class="filter-btn bg-white text-gray-600 border border-gray-300 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors" data-filter="withdrawn">Withdrawn</button>
    </div>
</div>

<!-- Main Grid -->
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    <!-- LEFT: Table (3/5) -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-3">Position Name</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-3">Date Applied</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-3">Status</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="lamaran-tbody">
                    @forelse($applications as $app)
                        @php
                            $jobTitle = $app->jobPosting->title ?? 'N/A';
                            $deptName = $app->jobPosting->category->name ?? 'General';
                            $dateStr = $app->created_at->format('d M Y');
                            
                            // Map DB status to filter status
                            $filterStatus = $app->status === 'applied' ? 'submitted' : $app->status;

                            // Badge classes
                            $badgeClasses = [
                                'applied' => 'bg-gray-100 text-gray-600',
                                'shortlisted' => 'bg-amber-50 text-amber-700 border border-amber-100',
                                'interview' => 'bg-blue-50 text-blue-700 border border-blue-100',
                                'accepted' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                'rejected' => 'bg-red-50 text-red-700 border border-red-100',
                                'withdrawn' => 'bg-gray-200 text-gray-800'
                            ];
                            $badgeClass = $badgeClasses[$app->status] ?? 'bg-gray-100 text-gray-600';
                            
                            $statusLabels = [
                                'applied' => 'SUBMITTED',
                                'shortlisted' => 'SHORTLISTED',
                                'interview' => 'INTERVIEW',
                                'accepted' => 'ACCEPTED',
                                'rejected' => 'REJECTED',
                                'withdrawn' => 'WITHDRAWN'
                            ];
                            $statusLabel = $statusLabels[$app->status] ?? strtoupper($app->status);
                        @endphp
                        <tr class="border-b border-gray-50 hover:bg-green-50/20 transition-colors cursor-pointer lamaran-row" 
                            data-id="{{ $app->id }}" 
                            data-status="{{ $filterStatus }}">
                            <td class="px-5 py-4">
                                <p class="font-bold text-sm text-gray-900 group-hover:text-green-800 transition-colors">{{ $jobTitle }}</p>
                                <p class="text-xs text-gray-400">{{ $deptName }}</p>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600 font-medium">{{ $dateStr }}</td>
                            <td class="px-5 py-4">
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full {{ $badgeClass }}">{{ $statusLabel }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <button class="btn-detail text-sm font-semibold text-green-700 hover:text-green-800 transition-colors" data-id="{{ $app->id }}">Detail ›</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-sm text-gray-500 font-medium bg-white">
                                You have not submitted any job applications yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- RIGHT: Timeline Panel (2/5) -->
    <div class="lg:col-span-2">
        <!-- Empty state -->
        <div class="bg-white rounded-xl border border-gray-200 p-8 text-center shadow-sm" id="timeline-empty">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/></svg>
            <p class="text-sm font-medium text-gray-400">Click "Detail" on an application to see the status timeline.</p>
        </div>

        @foreach($applications as $app)
            @php
                $latestInterview = $app->interviews->first();
                
                // Fetch timeline log dates
                $submittedDate = $app->created_at;
                
                $reviewedLog = DB::table('application_status_logs')
                    ->where('application_id', $app->id)
                    ->whereIn('new_status', ['shortlisted'])
                    ->orderBy('created_at', 'desc')
                    ->first();
                $reviewedDate = $reviewedLog ? \Carbon\Carbon::parse($reviewedLog->created_at) : null;
                
                $interviewLog = DB::table('application_status_logs')
                    ->where('application_id', $app->id)
                    ->where('new_status', 'interview')
                    ->orderBy('created_at', 'desc')
                    ->first();
                $interviewLogDate = $interviewLog ? \Carbon\Carbon::parse($interviewLog->created_at) : null;

                $finalLog = DB::table('application_status_logs')
                    ->where('application_id', $app->id)
                    ->whereIn('new_status', ['accepted', 'rejected', 'withdrawn'])
                    ->orderBy('created_at', 'desc')
                    ->first();
                $finalDate = $finalLog ? \Carbon\Carbon::parse($finalLog->created_at) : null;
            @endphp
            <!-- Timeline Panel for Application ID {{ $app->id }} -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 hidden timeline-panel shadow-sm" id="timeline-{{ $app->id }}">
                <div class="flex items-center gap-2 mb-5 pb-4 border-b border-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/></svg>
                    <h3 class="font-extrabold text-gray-950">Timeline Status</h3>
                </div>

                <!-- Timeline Items -->
                <div class="relative pl-6 space-y-6">
                    <div class="absolute left-[7px] top-2 bottom-8 w-0.5 bg-gray-200"></div>

                    @php
                        $isWithdrawn = $app->status === 'withdrawn';
                        $isDeclinedByApplicant = $latestInterview && $latestInterview->status === 'cancelled' && !empty($latestInterview->notes) && (str_contains($latestInterview->notes, '[Wawancara Ditolak oleh Pelamar]') || str_contains($latestInterview->notes, '[Interview Declined by Applicant]'));
                        
                        $declineReason = 'No reason provided';
                        if ($isDeclinedByApplicant && !empty($latestInterview->notes)) {
                            $parts = explode('Reason:', $latestInterview->notes);
                            if (!isset($parts[1])) {
                                $parts = explode('Alasan:', $latestInterview->notes);
                            }
                            if (isset($parts[1])) {
                                $reasonPart = explode('---', $parts[1])[0];
                                $declineReason = trim($reasonPart);
                            }
                        }
                    @endphp

                    @if($isWithdrawn)
                        <!-- ==================== FLOW: WITHDRAWN ==================== -->
                        <!-- Step 1: Submitted ✓ -->
                        <div class="relative">
                            <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                            <p class="font-bold text-sm text-gray-900">Application Submitted</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $submittedDate->format('d M Y, H:i') }} WIB</p>
                            <p class="text-xs text-gray-500 mt-1 font-medium">Documents successfully uploaded and verified by the system.</p>
                        </div>

                        <!-- Step 2: Shortlisted (Only if they actually got shortlisted before withdrawing) -->
                        @if($reviewedLog)
                            <div class="relative">
                                <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                                <p class="font-bold text-sm text-gray-900">Shortlisted</p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $reviewedDate ? $reviewedDate->format('d M Y, H:i') : '' }} WIB
                                </p>
                                <p class="text-xs text-gray-500 mt-1 font-medium">
                                    {{ $reviewedLog->reason ?? 'Your application has been shortlisted by the recruitment team.' }}
                                </p>
                            </div>
                        @endif

                        <!-- Step 3: Application Withdrawn -->
                        <div class="relative">
                            <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-500 rounded-full border-2 border-white ring-4 ring-gray-100"></div>
                            <p class="font-bold text-sm text-gray-600">Application Withdrawn</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $finalDate ? $finalDate->format('d M Y, H:i') : '' }} WIB
                            </p>
                            <p class="text-xs text-gray-500 mt-1 font-medium bg-gray-50 border border-gray-100 rounded-lg p-3">
                                You have withdrawn this application from the recruitment portal.
                            </p>
                        </div>

                    @elseif($isDeclinedByApplicant)
                        <!-- ==================== FLOW: DECLINED INTERVIEW ==================== -->
                        <!-- Step 1: Submitted ✓ -->
                        <div class="relative">
                            <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                            <p class="font-bold text-sm text-gray-900">Application Submitted</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $submittedDate->format('d M Y, H:i') }} WIB</p>
                            <p class="text-xs text-gray-500 mt-1 font-medium">Documents successfully uploaded and verified by the system.</p>
                        </div>

                        <!-- Step 2: Shortlisted ✓ -->
                        <div class="relative">
                            <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                            <p class="font-bold text-sm text-gray-900">Shortlisted</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $reviewedDate ? $reviewedDate->format('d M Y, H:i') : '' }} WIB
                            </p>
                            <p class="text-xs text-gray-500 mt-1 font-medium">
                                {{ $reviewedLog->reason ?? 'Your application has been shortlisted by the recruitment team.' }}
                            </p>
                        </div>

                        <!-- Step 3: Interview Declined (Eliminated) -->
                        <div class="relative">
                            <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-red-500 rounded-full border-2 border-white ring-4 ring-red-100"></div>
                            <p class="font-bold text-sm text-red-700">Interview Declined (Eliminated)</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $latestInterview->updated_at ? $latestInterview->updated_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') : '' }} WIB
                            </p>
                            <div class="mt-2 bg-red-50/50 border border-red-100 rounded-xl p-3.5 space-y-2">
                                <p class="text-xs font-bold text-red-800">You declined the interview invitation</p>
                                <p class="text-[11px] text-red-600/80 leading-relaxed">
                                    <strong>Reason:</strong> {{ $declineReason }}
                                </p>
                                <p class="text-[11px] text-red-700 font-semibold leading-relaxed">
                                    As a result, your application has been automatically eliminated from PT Ecogreen Oleochemicals recruitment process.
                                </p>
                            </div>
                        </div>

                    @else
                        <!-- ==================== FLOW: STANDARD FLOW ==================== -->
                        <!-- Step 1: Submitted ✓ (Always Completed) -->
                        <div class="relative">
                            <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                            <p class="font-bold text-sm text-gray-900">Application Submitted</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $submittedDate->format('d M Y, H:i') }} WIB</p>
                            <p class="text-xs text-gray-500 mt-1 font-medium">Documents successfully uploaded and verified by the system.</p>
                        </div>

                        <!-- Step 2: Shortlisted -->
                        @if(in_array($app->status, ['applied']))
                            <!-- Pending state -->
                            <div class="relative">
                                <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-300 rounded-full border-2 border-white"></div>
                                <p class="font-bold text-sm text-gray-500">Shortlisted</p>
                                <p class="text-xs text-gray-400 mt-0.5 italic">Awaiting shortlist selection by HR.</p>
                            </div>
                        @else
                            <!-- Completed state -->
                            <div class="relative">
                                <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                                <p class="font-bold text-sm text-gray-900">Shortlisted</p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $reviewedDate ? $reviewedDate->format('d M Y, H:i') : $submittedDate->addDay()->format('d M Y, H:i') }} WIB
                                </p>
                                <p class="text-xs text-gray-500 mt-1 font-medium">
                                    {{ $reviewedLog->reason ?? 'Your application has been shortlisted by the recruitment team.' }}
                                </p>
                            </div>
                        @endif

                        <!-- Step 3: Interview -->
                        @if(($app->status === 'interview' || $latestInterview) && !in_array($app->status, ['accepted', 'rejected', 'withdrawn']))
                            <!-- Active/Scheduled state -->
                            <div class="relative">
                                @if($latestInterview && $latestInterview->status === 'completed')
                                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                                    <p class="font-bold text-sm text-gray-900">Interview Session</p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $latestInterview->scheduled_at->format('d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1 font-medium">Interview session has been completed.</p>
                                @else
                                    <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-blue-500 rounded-full border-2 border-white ring-4 ring-blue-100 animate-pulse"></div>
                                    <p class="font-bold text-sm text-blue-800">Interview Session</p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $interviewLogDate ? $interviewLogDate->format('d M Y') : $submittedDate->addDays(2)->format('d M Y') }}
                                    </p>

                                    @if($latestInterview)
                                        <!-- Interview Detail Card -->
                                        <div class="mt-3 bg-gray-50 border border-gray-100 rounded-xl p-4 space-y-2.5 shadow-sm">
                                            <div class="flex items-center gap-2.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                                <span class="text-xs font-bold text-gray-700">
                                                    {{ $latestInterview->scheduled_at->format('d M Y • H:i') }} WIB ({{ $latestInterview->duration_minutes }} Min)
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                                <div>
                                                    <span class="text-xs font-bold text-gray-700 block">
                                                        {{ $latestInterview->interview_type === 'online' ? 'Google Meet / Online Link' : 'Office Location' }}
                                                    </span>
                                                    @if($latestInterview->interview_type === 'online')
                                                        <a href="{{ $latestInterview->location_or_link ?? '#' }}" target="_blank" class="text-xs text-green-700 hover:text-green-800 font-semibold underline truncate max-w-[200px] block">
                                                            {{ $latestInterview->location_or_link ?? 'Click to join meeting' }}
                                                        </a>
                                                    @else
                                                        <span class="text-xs text-gray-600 font-medium block">
                                                            {{ $latestInterview->location_or_link ?? 'PT Ecogreen Head Office, Kabil, Batam' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @php
                                                // Clean notes: strip old-format reschedule prefix if present
                                                $cleanNotes = $latestInterview->notes;
                                                if ($cleanNotes && (str_contains($cleanNotes, '[Permintaan Reschedule oleh Pelamar]') || str_contains($cleanNotes, '[Reschedule Request by Applicant]') || str_contains($cleanNotes, 'Permintaan Reschedule'))) {
                                                    // Handle both literal \n and real newlines
                                                    $normalized = str_replace(['\\n', '\n'], "\n", $cleanNotes);
                                                    if (str_contains($normalized, 'Catatan HR Sebelumnya:') || str_contains($normalized, 'Previous HR Notes:')) {
                                                        $sep = str_contains($normalized, 'Previous HR Notes:') ? 'Previous HR Notes:' : 'Catatan HR Sebelumnya:';
                                                        $cleanNotes = trim(substr($normalized, strpos($normalized, $sep) + strlen($sep)));
                                                    } elseif (preg_match('/---+/', $normalized)) {
                                                        // Fallback: grab everything after the dashed separator
                                                        $parts = preg_split('/---+/', $normalized);
                                                        $cleanNotes = isset($parts[1]) ? trim($parts[1]) : null;
                                                    } else {
                                                        $cleanNotes = null;
                                                    }
                                                }
                                            @endphp
                                            @if($cleanNotes)
                                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-xs text-gray-700">
                                                    <strong class="text-gray-800">HR Notes:</strong> {{ $cleanNotes }}
                                                </div>
                                            @endif
                                            
                                             <!-- Confirmation Badge/Button Container -->
                                             <div class="pt-1 confirmation-container" data-interview-id="{{ $latestInterview->id }}">
                                                 @if($latestInterview->status === 'cancelled')
                                                     <div class="flex flex-col gap-1 items-center justify-center py-2.5 px-3 bg-red-50 border border-red-200 text-red-800 text-xs font-bold rounded-lg shadow-sm">
                                                         <div class="flex items-center gap-1.5">
                                                             <svg class="w-4 h-4 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                                             Interview Declined / Cancelled
                                                         </div>
                                                     </div>
                                                 @elseif($latestInterview->status === 'rescheduled')
                                                     <div class="flex flex-col gap-1 items-center justify-center py-2.5 px-3 bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold rounded-lg shadow-sm">
                                                         <div class="flex items-center gap-1.5">
                                                             <svg class="w-4 h-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                                                             Reschedule Requested
                                                         </div>
                                                         <span class="text-[10px] text-amber-600 font-medium">Awaiting HR decision</span>
                                                     </div>
                                                 @elseif($latestInterview->reschedule_request_status === 'approved')
                                                     <div class="flex flex-col gap-1 items-center justify-center py-2.5 px-3 bg-green-50 border border-green-200 text-green-800 text-xs font-bold rounded-lg shadow-sm">
                                                         <div class="flex items-center gap-1.5">
                                                             <svg class="w-4 h-4 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                                             Reschedule Approved ✓
                                                         </div>
                                                         <span class="text-[10px] text-green-600 font-medium">New schedule has been confirmed by HR</span>
                                                     </div>
                                                 @elseif($latestInterview->reschedule_request_status === 'declined')
                                                     <div class="flex flex-col gap-1 items-center justify-center py-2.5 px-3 bg-red-50 border border-red-200 text-red-800 text-xs font-bold rounded-lg shadow-sm">
                                                         <div class="flex items-center gap-1.5">
                                                             <svg class="w-4 h-4 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                                             Reschedule Declined
                                                         </div>
                                                         <span class="text-[10px] text-red-600 font-medium">Please attend according to the original schedule</span>
                                                     </div>
                                                 @elseif($latestInterview->attendance_status === 'present')
                                                     <div class="flex flex-col gap-1 items-center justify-center py-2.5 px-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-lg shadow-sm">
                                                         <div class="flex items-center gap-1.5">
                                                             <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                                             Attendance Confirmed ✓
                                                         </div>
                                                         <span class="text-[10px] text-emerald-600 font-medium">
                                                             Arrived at: {{ $latestInterview->attendance_confirmed_at ? $latestInterview->attendance_confirmed_at->setTimezone('Asia/Jakarta')->format('H:i') : '' }} WIB
                                                         </span>
                                                         @if($latestInterview->attendance_photo)
                                                             <a href="{{ $latestInterview->attendance_photo }}" target="_blank" class="mt-1 text-[10px] text-green-700 hover:text-green-800 underline font-semibold flex items-center gap-1">
                                                                 <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                                                 View Selfie Photo
                                                             </a>
                                                         @endif
                                                     </div>
                                                 @else
                                                     <div class="space-y-2">
                                                         <button class="btn-konfirmasi w-full bg-green-800 hover:bg-green-900 text-white font-bold py-2 rounded-lg text-xs transition-colors flex items-center justify-center gap-1.5 shadow-sm"
                                                                 onclick="triggerHadirConfirmation(
                                                                     {{ $latestInterview->id }},
                                                                     '{{ $latestInterview->scheduled_at->format('d F Y \a\t H:i') }} WIB',
                                                                     '{{ $latestInterview->interview_type }}',
                                                                     '{{ addslashes($latestInterview->location_or_link) }}',
                                                                     '{{ addslashes($app->jobPosting->title ?? 'Position') }}'
                                                                 )">
                                                             Confirm Attendance
                                                         </button>
                                                         <div class="grid grid-cols-2 gap-2">
                                                             <button class="w-full bg-white hover:bg-amber-50 text-amber-800 border border-amber-200 font-bold py-2 rounded-lg text-xs transition-colors flex items-center justify-center gap-1 shadow-sm"
                                                                     onclick="triggerRescheduleModal(
                                                                          {{ $latestInterview->id }}, 
                                                                          '{{ addslashes($app->jobPosting->title ?? 'Position') }}',
                                                                          '{{ $latestInterview->interview_type }}'
                                                                      )">
                                                                 Reschedule
                                                             </button>
                                                             <button class="w-full bg-white hover:bg-red-50 text-red-800 border border-red-200 font-bold py-2 rounded-lg text-xs transition-colors flex items-center justify-center gap-1 shadow-sm"
                                                                     onclick="triggerDeclineModal({{ $latestInterview->id }}, '{{ addslashes($app->jobPosting->title ?? 'Position') }}')">
                                                                 Decline
                                                             </button>
                                                         </div>
                                                     </div>
                                                 @endif
                                             </div>
                                         </div>
                                     @else
                                         <p class="text-xs text-gray-500 mt-1 font-medium">Selected for interview stage. Scheduled details will be released shortly.</p>
                                     @endif
                                 @endif
                             </div>
                         @elseif(in_array($app->status, ['accepted', 'rejected', 'withdrawn']))
                             <!-- Done/Not needed state -->
                             <div class="relative">
                                 <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                                 <p class="font-bold text-sm text-gray-900">Interview Session</p>
                                 @if($latestInterview)
                                     <p class="text-xs text-gray-400 mt-0.5">
                                         {{ $latestInterview->scheduled_at->format('d M Y') }}
                                     </p>
                                     <p class="text-xs text-gray-500 mt-1 font-medium">Interview session has been completed.</p>
                                 @else
                                     <p class="text-xs text-gray-500 mt-0.5 font-medium">Stage passed or completed.</p>
                                 @endif
                             </div>
                         @else
                             <!-- Pending state -->
                             <div class="relative">
                                 <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-300 rounded-full border-2 border-white"></div>
                                 <p class="font-bold text-sm text-gray-400">Interview Session</p>
                                 <p class="text-xs text-gray-400 mt-0.5 italic">Awaiting shortlist approval.</p>
                             </div>
                         @endif

                         <!-- Step 3.5: Interview Under Review -->
                         @if($latestInterview && $latestInterview->status === 'completed' && in_array($app->status, ['interview']))
                             <div class="relative">
                                 <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-indigo-500 rounded-full border-2 border-white ring-4 ring-indigo-100 animate-pulse"></div>
                                 <p class="font-bold text-sm text-indigo-800">Interview Under Review</p>
                                 <p class="text-xs text-gray-400 mt-0.5">
                                     {{ $latestInterview->updated_at ? $latestInterview->updated_at->format('d M Y') : '' }}
                                 </p>
                                 <div class="mt-2 bg-indigo-50/50 border border-indigo-100 rounded-xl p-3.5">
                                     <div class="flex items-start gap-2.5">
                                         <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                 <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                             </svg>
                                         </div>
                                         <div>
                                             <p class="text-xs font-bold text-indigo-800">Your interview session has been completed</p>
                                             <p class="text-[11px] text-indigo-600/80 mt-1 leading-relaxed">
                                                 The HR team is currently evaluating your interview results. The final decision will be updated here and via notification shortly.
                                             </p>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         @elseif($latestInterview && $latestInterview->status === 'completed' && in_array($app->status, ['accepted', 'rejected']))
                             <div class="relative">
                                 <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                                 <p class="font-bold text-sm text-gray-900">Interview Under Review</p>
                                 <p class="text-xs text-gray-500 mt-0.5 font-medium">Interview evaluation completed.</p>
                             </div>
                         @elseif($app->status === 'interview' || in_array($app->status, ['shortlisted', 'applied']))
                             {{-- Not reached this stage yet --}}
                         @else
                             <div class="relative">
                                 <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-green-800 rounded-full border-2 border-white"></div>
                                 <p class="font-bold text-sm text-gray-900">Interview Under Review</p>
                                 <p class="text-xs text-gray-500 mt-0.5 font-medium">Interview evaluation completed.</p>
                             </div>
                         @endif

                         <!-- Step 4: Final Decision -->
                         @if($app->status === 'accepted')
                             <!-- Accepted state -->
                             <div class="relative">
                                 <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-white ring-4 ring-emerald-100"></div>
                                 <p class="font-bold text-sm text-emerald-800">Congratulations! You are Accepted</p>
                                 <p class="text-xs text-gray-400 mt-0.5">
                                     {{ $finalDate ? $finalDate->format('d M Y, H:i') : '' }}
                                 </p>
                                 <p class="text-xs text-gray-600 mt-1 bg-emerald-50/50 border border-emerald-100 rounded-lg p-3 font-semibold">
                                     {{ $app->hr_notes ?? 'Welcome to PT Ecogreen Oleochemicals. Our HR team will contact you shortly for onboarding details.' }}
                                 </p>
                             </div>
                         @elseif($app->status === 'rejected')
                             <!-- Rejected state -->
                             <div class="relative">
                                 <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-red-500 rounded-full border-2 border-white ring-4 ring-red-100"></div>
                                 <p class="font-bold text-sm text-red-700">Application Unsuccessful</p>
                                 <p class="text-xs text-gray-400 mt-0.5">
                                     {{ $finalDate ? $finalDate->format('d M Y, H:i') : '' }}
                                 </p>
                                 <p class="text-xs text-gray-600 mt-1 bg-red-50/50 border border-red-100 rounded-lg p-3 font-semibold">
                                     {{ $app->hr_notes ?? 'Thank you for your interest. Unfortunately, we have decided to proceed with other candidates at this time.' }}
                                 </p>
                             </div>
                         @elseif($app->status === 'withdrawn')
                             <!-- Withdrawn state -->
                             <div class="relative">
                                 <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-500 rounded-full border-2 border-white"></div>
                                 <p class="font-bold text-sm text-gray-600">Application Withdrawn</p>
                                 <p class="text-xs text-gray-400 mt-0.5">
                                     {{ $finalDate ? $finalDate->format('d M Y, H:i') : '' }}
                                 </p>
                                 <p class="text-xs text-gray-500 mt-1 font-medium">You have withdrawn this application from the portal.</p>
                             </div>
                         @else
                             <!-- Pending state -->
                             <div class="relative">
                                 <div class="absolute -left-6 top-0.5 w-3.5 h-3.5 bg-gray-300 rounded-full border-2 border-white"></div>
                                 <p class="font-bold text-sm text-gray-400">Final Decision</p>
                                 <p class="text-xs text-gray-400 mt-0.5 italic">Awaiting interview and final review.</p>
                             </div>
                         @endif
                     @endif
                 </div>

                 <!-- Action Buttons -->
                 @if(!in_array($app->status, ['accepted', 'rejected', 'withdrawn']))
                     <div class="mt-8 space-y-2.5">
                         @if($app->status === 'applied')
                             <button onclick="openWithdrawModal({{ $app->id }})" class="btn-tarik-trigger w-full border border-red-300 text-red-600 font-bold py-2.5 rounded-lg text-sm hover:bg-red-50 transition-colors shadow-sm">
                                 Withdraw Application
                             </button>
                             <p class="text-xs text-gray-400 text-center mt-2">Withdrawal of application is permanent.</p>
                         @else
                             <button disabled class="w-full border border-gray-200 text-gray-400 font-bold py-2.5 rounded-lg text-sm cursor-not-allowed bg-gray-50">
                                 Withdraw Application
                             </button>
                             <p class="text-xs text-gray-400 text-center">Application cannot be withdrawn after the shortlist stage.</p>
                         @endif
                     </div>
                 @endif
             </div>
         @endforeach
     </div>

 </div>

<!-- ========== MODAL: Tarik Lamaran ========== -->
<div id="modal-tarik" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-8 text-center relative shadow-2xl border border-gray-100">
        <button onclick="closeWithdrawModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" x2="12" y1="8" y2="12"/>
                <line x1="12" x2="12.01" y1="16" y2="16"/>
            </svg>
        </div>
        <h2 class="text-xl font-extrabold text-gray-900 mb-2">Withdraw Application?</h2>
        <p class="text-sm text-gray-500 mb-2 font-medium">Are you sure you want to withdraw this application?</p>
        <div class="bg-red-50 rounded-lg p-3 mb-6 border border-red-100">
            <p class="text-xs text-red-600 font-bold leading-relaxed">This action is PERMANENT and cannot be undone. You will not be able to reapply for the same position.</p>
        </div>
        <input type="hidden" id="withdraw-application-id">
        <div class="space-y-2.5">
            <button id="btn-confirm-tarik" onclick="submitWithdraw()" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-lg text-sm transition-colors shadow-md">
                Yes, Withdraw Application
            </button>
            <button onclick="closeWithdrawModal()" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- ========== MODAL: Konfirmasi Kehadiran ========== -->
<div id="modal-hadir" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 overflow-hidden relative shadow-2xl border border-gray-100">
        <button onclick="closeHadirModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>

        <!-- Header -->
        <div class="bg-green-800 px-6 py-5 text-white">
            <p class="text-xs uppercase tracking-widest text-green-300 font-bold mb-1">Interview Invitation</p>
            <h2 class="text-lg font-extrabold" id="hadir-job-title">Process Engineer — PT Ecogreen</h2>
        </div>

        <!-- Content: default state -->
        <div id="hadir-form" class="p-6">
            <div class="space-y-4 mb-6">
                <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Date & Time</p>
                        <p class="text-sm font-bold text-gray-900" id="hadir-datetime">20 October 2023 • 13:00 WIB</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3 border border-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider" id="hadir-location-label">Location</p>
                        <p class="text-sm font-bold text-gray-900" id="hadir-location-value">Ecogreen Head Office, Kabil, Batam</p>
                    </div>
                </div>
            </div>

            <div class="bg-amber-50 border border-amber-100 rounded-lg p-3.5 mb-6">
                <p class="text-xs text-amber-800 font-semibold flex items-start gap-2 leading-relaxed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    Please prepare and stand by 10-15 minutes prior to the scheduled time. Ensure a stable connection for online interviews.
                </p>
            </div>
 
            <!-- Photo Capture field (only visible for offline interviews) -->
            <div id="hadir-photo-section" class="hidden mb-6">
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Take a Selfie at the Location</label>
                
                <!-- Live Camera View -->
                <div class="relative overflow-hidden rounded-xl bg-gray-900 border border-gray-200 aspect-video flex items-center justify-center shadow-inner" id="camera-container">
                    <video id="camera-stream" autoplay playsinline muted class="w-full h-full object-cover hidden"></video>
                    <img id="preview-img" src="#" alt="Selfie Preview" class="w-full h-full object-cover hidden">
                    
                    <!-- Loading / Info Screen -->
                    <div id="camera-placeholder" class="text-center p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mx-auto mb-2 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        <p class="text-xs font-semibold text-gray-400" id="camera-status-text">Initializing Camera...</p>
                    </div>
                </div>

                <!-- Camera Controls -->
                <div class="flex gap-2 mt-3" id="camera-controls">
                    <button type="button" id="btn-capture-photo" onclick="captureSelfie()" class="flex-1 bg-green-700 hover:bg-green-800 text-white font-bold py-2.5 px-4 rounded-lg text-xs transition-colors flex items-center justify-center gap-1.5 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        Take Photo
                    </button>
                    <button type="button" id="btn-retake-photo" onclick="startCamera()" class="flex-1 border border-gray-300 text-gray-700 font-semibold py-2.5 px-4 rounded-lg text-xs hover:bg-gray-50 transition-colors hidden justify-center items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                        Retake Photo
                    </button>
                </div>

                <!-- Fallback input (capture="user" forces camera on mobile) -->
                <input type="file" id="attendance_photo" accept="image/*" capture="user" class="hidden" onchange="previewFallbackPhoto(this)">
                <canvas id="camera-canvas" class="hidden"></canvas>
            </div>

            <input type="hidden" id="hadir-interview-id">
            <div class="space-y-2.5">
                <button id="btn-confirm-hadir" onclick="submitHadirConfirmation()" class="w-full bg-green-800 hover:bg-green-900 text-white font-bold py-3 rounded-lg text-sm transition-colors flex items-center justify-center gap-2 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    Confirm Attendance
                </button>
                <button onclick="closeHadirModal()" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Maybe Later
                </button>
            </div>
        </div>

        <!-- Content: success state -->
        <div id="hadir-success" class="p-8 text-center hidden">
            <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Attendance Confirmed!</h3>
            <p class="text-sm text-gray-500 mb-1 font-medium">We have recorded your confirmation.</p>
            <p class="text-sm text-gray-500 mb-6 font-medium">See you at the interview session!</p>
            <button onclick="closeHadirModal()" class="w-full bg-green-800 hover:bg-green-700 text-white font-bold py-2.5 rounded-lg text-sm transition-colors shadow-md">
                Close
            </button>
        </div>
    </div>
</div>

<!-- ========== MODAL: Reschedule Interview ========== -->
<div id="modal-reschedule" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 overflow-hidden relative shadow-2xl border border-gray-100">
        <button onclick="closeRescheduleModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>

        <!-- Header -->
        <div class="bg-amber-600 px-6 py-5 text-white">
            <p class="text-xs uppercase tracking-widest text-amber-200 font-bold mb-1">Request Schedule Change</p>
            <h2 class="text-lg font-extrabold" id="reschedule-job-title">Reschedule Interview</h2>
        </div>

        <div class="p-6 space-y-4">
            <input type="hidden" id="reschedule-interview-id">
            
            <!-- Current interview details block -->
            <div class="bg-amber-50/70 border border-amber-200 rounded-xl p-3 text-xs text-amber-900 space-y-1">
                <div class="flex items-center gap-1.5 font-bold mb-0.5">
                    <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 111.086 1.086L12.5 12.5l.04.02a.75.75 0 11-1.086-1.086l.046-.02a.75.75 0 00-.25-.164zM12 21.75c-5.385 0-9.75-4.365-9.75-9.75S6.615 2.25 12 2.25s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75z"/></svg>
                    Current Interview Type:
                </div>
                <div class="flex items-center gap-2 pl-5.5">
                    <span id="reschedule-current-type" class="uppercase font-bold text-gray-800">Online</span>
                </div>
            </div>
            
            <div>
                <label for="reschedule-reason" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Reschedule Reason <span class="text-red-500">*</span></label>
                <textarea id="reschedule-reason" rows="2" placeholder="State your reason for requesting a schedule change (e.g., schedule conflict, sick, etc.)" 
                          class="w-full bg-gray-50 rounded-lg p-3 text-xs text-gray-700 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="reschedule-date" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">New Date <span class="text-red-500">*</span></label>
                    <input type="date" id="reschedule-date" required 
                           class="w-full bg-gray-50 rounded-lg p-3 text-xs text-gray-700 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Time (24h) <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-1.5">
                        <select id="reschedule-hour" class="w-full bg-gray-50 rounded-lg p-2.5 text-xs text-gray-700 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-white text-center">
                            <option value="">Hour</option>
                            @for($i = 8; $i <= 18; $i++)
                                @php $h = sprintf('%02d', $i); @endphp
                                <option value="{{ $h }}">{{ $h }}</option>
                            @endfor
                        </select>
                        <span class="text-gray-400 font-bold">:</span>
                        <select id="reschedule-minute" class="w-full bg-gray-50 rounded-lg p-2.5 text-xs text-gray-700 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-white text-center">
                            <option value="">Min</option>
                            @for($i = 0; $i < 60; $i += 10)
                                @php $m = sprintf('%02d', $i); @endphp
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label for="reschedule-proposed-type" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Proposed New Type <span class="text-red-500">*</span></label>
                <select id="reschedule-proposed-type" required
                        class="w-full bg-gray-50 rounded-lg p-3 text-xs text-gray-700 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-white">
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                </select>
            </div>

            <!-- Duration input -->
            <input type="hidden" id="reschedule-duration" value="60">

            {{-- Booked slots timeline container --}}
            <div id="reschedule_booked_timeline" class="hidden text-xs bg-amber-50 border border-amber-200 rounded-xl p-3 text-amber-900 space-y-1">
                <p class="font-bold flex items-center gap-1.5 text-[11px]">
                    <svg class="w-3.5 h-3.5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Booked Schedules Today:
                </p>
                <ul class="list-disc list-inside space-y-0.5 text-[10px]" id="reschedule_booked_slots_list">
                </ul>
            </div>

            <div class="pt-2 space-y-2">
                <button id="btn-submit-reschedule" onclick="submitReschedule()" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 rounded-lg text-sm transition-colors flex items-center justify-center gap-2 shadow-md">
                    Submit Reschedule
                </button>
                <button onclick="closeRescheduleModal()" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Back
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========== MODAL: Decline Interview ========== -->
<div id="modal-decline" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 overflow-hidden relative shadow-2xl border border-gray-100">
        <button onclick="closeDeclineModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>

        <!-- Header -->
        <div class="bg-red-600 px-6 py-5 text-white">
            <p class="text-xs uppercase tracking-widest text-red-200 font-bold mb-1">Decline Interview Invitation</p>
            <h2 class="text-lg font-extrabold" id="decline-job-title">Decline Interview</h2>
        </div>

        <div class="p-6 space-y-4">
            <input type="hidden" id="decline-interview-id">
            
            <div class="bg-red-50 rounded-lg p-3 border border-red-100">
                <p class="text-xs text-red-600 font-bold leading-relaxed">Warning: By declining this interview invitation, your job application will be automatically declared failed (eliminated) from the selection process. This action is permanent.</p>
            </div>

            <div>
                <label for="decline-reason" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Reason for Declining <span class="text-red-500">*</span></label>
                <textarea id="decline-reason" rows="3" placeholder="State your reason for declining this interview invitation" 
                          class="w-full bg-gray-50 rounded-lg p-3 text-xs text-gray-700 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"></textarea>
            </div>

            <div class="pt-2 space-y-2">
                <button id="btn-submit-decline" onclick="submitDecline()" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg text-sm transition-colors flex items-center justify-center gap-2 shadow-md">
                    Yes, Decline Invitation
                </button>
                <button onclick="closeDeclineModal()" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Back
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    // Refresh display of confirmation badges (handled via server state)
    function refreshConfirmationStates() {}

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
                if (filter === 'all' || row.dataset.status === filter) {
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

            document.querySelectorAll('.lamaran-row').forEach(r => r.classList.remove('bg-green-50/40'));
            row.classList.add('bg-green-50/40');

            document.getElementById('timeline-empty').classList.add('hidden');
            document.querySelectorAll('.timeline-panel').forEach(p => p.classList.add('hidden'));
            const panel = document.getElementById('timeline-' + id);
            if (panel) panel.classList.remove('hidden');
        });
    });

    // ===== TARIK LAMARAN MODAL HANDLERS =====
    window.openWithdrawModal = function(applicationId) {
        document.getElementById('withdraw-application-id').value = applicationId;
        document.getElementById('modal-tarik').classList.remove('hidden');
        event.stopPropagation();
    };

    window.closeWithdrawModal = function() {
        document.getElementById('modal-tarik').classList.add('hidden');
    };

    // Click outside to close modal
    document.getElementById('modal-tarik').addEventListener('click', function (e) {
        if (e.target === this) closeWithdrawModal();
    });

    window.submitWithdraw = async function() {
        const btn = document.getElementById('btn-confirm-tarik');
        const id = document.getElementById('withdraw-application-id').value;
        
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';
        
        try {
            const response = await fetch(`/pelamar/status-lamaran/${id}/withdraw`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                }
            });
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Withdrawal failed.');
            
            closeWithdrawModal();
            alert(data.message || 'Application withdrawn successfully.');
            window.location.reload();
        } catch(err) {
            alert(err.message);
            btn.disabled = false;
            btn.textContent = 'Yes, Withdraw Application';
        }
    };

    // ===== KONFIRMASI KEHADIRAN MODAL HANDLERS =====
    let cameraStream = null;
    let capturedBlob = null;

    window.startCamera = async function() {
        const video = document.getElementById('camera-stream');
        const placeholder = document.getElementById('camera-placeholder');
        const statusText = document.getElementById('camera-status-text');
        const previewImg = document.getElementById('preview-img');
        const retakeBtn = document.getElementById('btn-retake-photo');
        const fillBtn = document.getElementById('btn-capture-photo');
        const fallbackInput = document.getElementById('attendance_photo');

        // Reset UI state
        previewImg.classList.add('hidden');
        video.classList.add('hidden');
        placeholder.classList.remove('hidden');
        statusText.textContent = 'Accessing Camera...';
        retakeBtn.classList.add('hidden');
        retakeBtn.classList.remove('flex');
        fillBtn.classList.remove('hidden');
        fillBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg> Take Photo';
        fillBtn.disabled = true;

        // Stop any existing stream
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }

        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'user' },
                audio: false
            });
            video.srcObject = cameraStream;
            video.classList.remove('hidden');
            placeholder.classList.add('hidden');
            fillBtn.disabled = false;
            
            // Rebind click event for desktop WebRTC
            fillBtn.onclick = function() {
                captureSelfie();
            };
        } catch (err) {
            console.error("Camera access failed:", err);
            statusText.innerHTML = 'Failed to access live camera.<br><span class="text-[10px] text-amber-600">Click the button below to capture directly using your device\'s default camera.</span>';
            
            // Rebind button to trigger capture="user" file selector
            fillBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg> Capture Photo';
            fillBtn.disabled = false;
            fillBtn.onclick = function() {
                fallbackInput.click();
            };
        }
    };

    window.captureSelfie = function() {
        const video = document.getElementById('camera-stream');
        const canvas = document.getElementById('camera-canvas');
        const previewImg = document.getElementById('preview-img');
        const fillBtn = document.getElementById('btn-capture-photo');
        const retakeBtn = document.getElementById('btn-retake-photo');

        if (!video || !canvas || !cameraStream) return;

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(function(blob) {
            capturedBlob = blob;
            const url = URL.createObjectURL(blob);
            previewImg.src = url;
            previewImg.classList.remove('hidden');
            video.classList.add('hidden');

            // Turn off camera stream
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }

            fillBtn.classList.add('hidden');
            retakeBtn.classList.remove('hidden');
            retakeBtn.classList.add('flex');
        }, 'image/jpeg', 0.9);
    };

    window.previewFallbackPhoto = function(input) {
        const file = input.files[0];
        if (file) {
            capturedBlob = file;
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('preview-img');
                const video = document.getElementById('camera-stream');
                const placeholder = document.getElementById('camera-placeholder');
                const fillBtn = document.getElementById('btn-capture-photo');
                const retakeBtn = document.getElementById('btn-retake-photo');

                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                video.classList.add('hidden');
                placeholder.classList.add('hidden');

                fillBtn.classList.add('hidden');
                retakeBtn.classList.remove('hidden');
                retakeBtn.classList.add('flex');
            }
            reader.readAsDataURL(file);
        }
    };

    window.triggerHadirConfirmation = function(interviewId, formattedDatetime, interviewType, locationOrLink, jobTitle) {
        document.getElementById('hadir-interview-id').value = interviewId;
        document.getElementById('hadir-job-title').textContent = `${jobTitle} — PT Ecogreen`;
        
        // Format Date
        document.getElementById('hadir-datetime').textContent = formattedDatetime;
        
        // Format Location
        const locVal = document.getElementById('hadir-location-value');
        const locLabel = document.getElementById('hadir-location-label');
        if (interviewType === 'online') {
            locLabel.textContent = 'Meeting Link';
            locVal.innerHTML = `<a href="${locationOrLink || '#'}" target="_blank" class="text-green-700 hover:text-green-800 underline">${locationOrLink || 'Join Meet'}</a>`;
        } else {
            locLabel.textContent = 'Office Location';
            locVal.textContent = locationOrLink || 'PT Ecogreen Head Office, Batam';
        }

        // Toggle Photo section for offline interviews
        if (interviewType === 'offline') {
            document.getElementById('hadir-photo-section').classList.remove('hidden');
            capturedBlob = null;
            startCamera();
        } else {
            document.getElementById('hadir-photo-section').classList.add('hidden');
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }
        }

        document.getElementById('hadir-form').classList.remove('hidden');
        document.getElementById('hadir-success').classList.add('hidden');
        document.getElementById('modal-hadir').classList.remove('hidden');
        if (typeof event !== 'undefined') {
            event.stopPropagation();
        }
    };

    window.closeHadirModal = function() {
        document.getElementById('modal-hadir').classList.add('hidden');
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
        if (!document.getElementById('hadir-success').classList.contains('hidden')) {
            window.location.reload();
        }
    };

    document.getElementById('modal-hadir').addEventListener('click', function (e) {
        if (e.target === this) closeHadirModal();
    });

    window.submitHadirConfirmation = async function() {
        const btn = document.getElementById('btn-confirm-hadir');
        const interviewId = document.getElementById('hadir-interview-id').value;
        const isOffline = !document.getElementById('hadir-photo-section').classList.contains('hidden');

        if (isOffline && !capturedBlob) {
            alert('Please take a selfie photo first.');
            return;
        }
        
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';
        
        const formData = new FormData();
        if (isOffline && capturedBlob) {
            const filename = capturedBlob.name || 'selfie.jpg';
            formData.append('attendance_photo', capturedBlob, filename);
        }
        
        try {
            const response = await fetch(`/pelamar/status-lamaran/interview/${interviewId}/confirm`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });
            
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Failed to confirm attendance.');
            
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }

            document.getElementById('hadir-form').classList.add('hidden');
            document.getElementById('hadir-success').classList.remove('hidden');
        } catch(err) {
            alert(err.message);
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Confirm Attendance';
        }
    };

    // ===== RESCHEDULE MODAL HANDLERS =====
    function timeToMinutes(timeStr) {
        const parts = timeStr.split(':');
        return parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
    }

    async function fetchRescheduleBookedSlots() {
        const dateInput = document.getElementById('reschedule-date');
        const hourSelect = document.getElementById('reschedule-hour');
        const minuteSelect = document.getElementById('reschedule-minute');
        const durationSelect = document.getElementById('reschedule-duration');
        const timelineDiv = document.getElementById('reschedule_booked_timeline');
        const listUl = document.getElementById('reschedule_booked_slots_list');

        const dateVal = dateInput.value;
        if (!dateVal) {
            timelineDiv.classList.add('hidden');
            return;
        }

        try {
            const response = await fetch(`/pelamar/status-lamaran/interview/booked-slots?date=${dateVal}`);
            const data = await response.json();
            if (!data.success) return;

            const slots = data.slots || [];

            // Render Timeline list
            listUl.innerHTML = '';
            if (slots.length > 0) {
                slots.forEach(s => {
                    const li = document.createElement('li');
                    li.className = 'font-semibold text-[11px] text-amber-900 list-disc';
                    li.textContent = `${s.start} - ${s.end} : Scheduled Interview`;
                    listUl.appendChild(li);
                });
                timelineDiv.classList.remove('hidden');
            } else {
                timelineDiv.classList.add('hidden');
            }

            // Cache slots on the hourSelect dataset
            hourSelect.dataset.slots = JSON.stringify(slots);

            // Trigger updates on Hour and Minute options
            updateRescheduleOptionsAvailability(hourSelect, minuteSelect, durationSelect, slots);

        } catch (e) {
            console.error(e);
        }
    }

    function updateRescheduleOptionsAvailability(hourSelect, minuteSelect, durationSelect, slots) {
        const selectedHour = hourSelect.value;
        const duration = parseInt(durationSelect.value, 10);

        // 1. Update Hour Options
        Array.from(hourSelect.options).forEach(opt => {
            if (!opt.value) return;
            const hVal = parseInt(opt.value, 10);
            const hStart = hVal * 60;
            const hEnd = hStart + 60;

            const isBooked = slots.some(s => {
                const start = timeToMinutes(s.start);
                const end = timeToMinutes(s.end);
                return hStart < end && hEnd > start;
            });

            if (isBooked) {
                opt.disabled = true;
                opt.style.cursor = 'not-allowed';
                if (!opt.textContent.includes('(Booked)')) {
                    opt.textContent = `${opt.value} (Booked)`;
                }
            } else {
                opt.disabled = false;
                opt.style.cursor = 'default';
                opt.textContent = opt.value;
            }
        });

        // 2. Update Minute Options based on currently selected Hour
        if (selectedHour !== '') {
            const hVal = parseInt(selectedHour, 10);
            Array.from(minuteSelect.options).forEach(opt => {
                if (!opt.value) return;
                const mVal = parseInt(opt.value, 10);
                const timeMin = hVal * 60 + mVal;

                const isBooked = slots.some(s => {
                    const start = timeToMinutes(s.start);
                    const end = timeToMinutes(s.end);
                    return timeMin >= start && timeMin < end;
                });

                if (isBooked) {
                    opt.disabled = true;
                    opt.style.cursor = 'not-allowed';
                    if (!opt.textContent.includes('(Booked)')) {
                        opt.textContent = `${opt.value} (Booked)`;
                    }
                } else {
                    opt.disabled = false;
                    opt.style.cursor = 'default';
                    opt.textContent = opt.value;
                }
            });
        }

        // 3. Overall validation warning
        validateRescheduleSelectedTime(hourSelect, minuteSelect, durationSelect, slots);
    }

    function validateRescheduleSelectedTime(hourSelect, minuteSelect, durationSelect, slots) {
        const hVal = hourSelect.value;
        const mVal = minuteSelect.value;
        const duration = parseInt(durationSelect.value, 10);
        const submitBtn = document.getElementById('btn-submit-reschedule');

        if (!hVal || !mVal) return;

        // Past date-time check
        const dateInput = document.getElementById('reschedule-date');
        const dateVal = dateInput.value;
        const todayStr = new Date().toISOString().split('T')[0];

        // Remove existing warning
        const oldWarning = document.getElementById('reschedule-time-conflict-warning');
        if (oldWarning) oldWarning.remove();

        if (dateVal === todayStr) {
            const now = new Date();
            const currentHour = now.getHours();
            const currentMinute = now.getMinutes();
            const selHour = parseInt(hVal, 10);
            const selMin = parseInt(mVal, 10);

            if (selHour < currentHour || (selHour === currentHour && selMin <= currentMinute)) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

                const warning = document.createElement('div');
                warning.id = 'reschedule-time-conflict-warning';
                warning.className = 'text-xs text-red-600 font-bold bg-red-50 border border-red-200 rounded-xl p-3.5 mt-3';
                warning.innerHTML = `⚠️ The time you selected is in the past. Please choose another time.`;
                hourSelect.closest('.grid').after(warning);
                return;
            }
        }

        const selStart = parseInt(hVal, 10) * 60 + parseInt(mVal, 10);
        const selEnd = selStart + duration;

        let booking = null;
        const isConflict = slots.some(s => {
            const start = timeToMinutes(s.start);
            const end = timeToMinutes(s.end);
            return selStart < end && selEnd > start && (booking = s, true);
        });

        if (isConflict) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            const warning = document.createElement('div');
            warning.id = 'reschedule-time-conflict-warning';
            warning.className = 'text-xs text-red-600 font-bold bg-red-55 border border-red-200 rounded-xl p-3.5 mt-3';
            warning.innerHTML = `⚠️ The selected time conflicts with another interview schedule at <strong>${booking.start} - ${booking.end}</strong>. Please choose another time.`;
            hourSelect.closest('.grid').after(warning);
        } else {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    // Set min date and event listeners on DOM load
    const rDateInput = document.getElementById('reschedule-date');
    if (rDateInput) {
        const today = new Date().toISOString().split('T')[0];
        rDateInput.setAttribute('min', today);
        rDateInput.addEventListener('change', fetchRescheduleBookedSlots);
    }

    const rHourSelect = document.getElementById('reschedule-hour');
    if (rHourSelect) {
        rHourSelect.addEventListener('change', () => {
            const hourSelect = document.getElementById('reschedule-hour');
            const minuteSelect = document.getElementById('reschedule-minute');
            const durationSelect = document.getElementById('reschedule-duration');
            const slots = JSON.parse(hourSelect.dataset.slots || '[]');
            updateRescheduleOptionsAvailability(hourSelect, minuteSelect, durationSelect, slots);
        });
    }

    const rMinSelect = document.getElementById('reschedule-minute');
    if (rMinSelect) {
        rMinSelect.addEventListener('change', () => {
            const hourSelect = document.getElementById('reschedule-hour');
            const minuteSelect = document.getElementById('reschedule-minute');
            const durationSelect = document.getElementById('reschedule-duration');
            const slots = JSON.parse(hourSelect.dataset.slots || '[]');
            updateRescheduleOptionsAvailability(hourSelect, minuteSelect, durationSelect, slots);
        });
    }

    window.triggerRescheduleModal = function(interviewId, jobTitle, interviewType) {
        document.getElementById('reschedule-interview-id').value = interviewId;
        document.getElementById('reschedule-job-title').textContent = 'Reschedule: ' + jobTitle;
        document.getElementById('reschedule-reason').value = '';
        
        // Show current interview details
        const typeEl = document.getElementById('reschedule-current-type');
        if (typeEl) {
            typeEl.textContent = interviewType || 'online';
        }
        
        const propTypeSelect = document.getElementById('reschedule-proposed-type');
        if (propTypeSelect) {
            propTypeSelect.value = (interviewType === 'offline') ? 'offline' : 'online';
        }

        const dateInput = document.getElementById('reschedule-date');
        if (dateInput) {
            dateInput.value = '';
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        }
        
        const hourSelect = document.getElementById('reschedule-hour');
        if (hourSelect) {
            hourSelect.value = '';
            hourSelect.dataset.slots = '[]';
            Array.from(hourSelect.options).forEach(opt => {
                if (opt.value) {
                    opt.disabled = false;
                    opt.textContent = opt.value;
                }
            });
        }
        
        const minuteSelect = document.getElementById('reschedule-minute');
        if (minuteSelect) {
            minuteSelect.value = '';
            Array.from(minuteSelect.options).forEach(opt => {
                if (opt.value) {
                    opt.disabled = false;
                    opt.textContent = opt.value;
                }
            });
        }
        
        const timelineDiv = document.getElementById('reschedule_booked_timeline');
        if (timelineDiv) timelineDiv.classList.add('hidden');

        const oldWarning = document.getElementById('reschedule-time-conflict-warning');
        if (oldWarning) oldWarning.remove();

        const btn = document.getElementById('btn-submit-reschedule');
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');

        document.getElementById('modal-reschedule').classList.remove('hidden');
        if (typeof event !== 'undefined') {
            event.stopPropagation();
        }
    };

    window.closeRescheduleModal = function() {
        document.getElementById('modal-reschedule').classList.add('hidden');
    };

    document.getElementById('modal-reschedule').addEventListener('click', function(e) {
        if (e.target === this) closeRescheduleModal();
    });

    window.submitReschedule = async function() {
        const btn = document.getElementById('btn-submit-reschedule');
        const interviewId = document.getElementById('reschedule-interview-id').value;
        const reason = document.getElementById('reschedule-reason').value.trim();
        
        const dateVal = document.getElementById('reschedule-date').value;
        const hourVal = document.getElementById('reschedule-hour').value;
        const minVal = document.getElementById('reschedule-minute').value;
        const propTypeVal = document.getElementById('reschedule-proposed-type').value;

        if (!reason) {
            alert('Please fill in the reschedule reason.');
            document.getElementById('reschedule-reason').focus();
            return;
        }

        if (!dateVal || !hourVal || !minVal) {
            alert('Please specify the proposed new date & time completely.');
            return;
        }

        // Format to US readable datetime string
        const parts = dateVal.split('-');
        const dateObj = new Date(parts[0], parts[1] - 1, parts[2]);
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const formattedDate = dateObj.toLocaleDateString('en-US', options);
        const proposedDate = `${formattedDate} at ${hourVal}:${minVal} WIB (${propTypeVal.toUpperCase()})`;

        btn.disabled = true;
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

        try {
            // Build ISO datetime string for proposed date
            const proposedIso = `${dateVal}T${hourVal}:${minVal}:00`;

            const response = await fetch(`/pelamar/status-lamaran/interview/${interviewId}/reschedule`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    reschedule_reason: reason,
                    proposed_date: proposedIso,
                    proposed_type: propTypeVal,
                })
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Failed to submit reschedule request.');

            closeRescheduleModal();
            alert(data.message || 'Reschedule request submitted successfully.');
            window.location.reload();
        } catch (err) {
            alert(err.message);
            btn.disabled = false;
            btn.innerHTML = originalContent;
        }
    };

    // ===== DECLINE MODAL HANDLERS =====
    window.triggerDeclineModal = function(interviewId, jobTitle) {
        document.getElementById('decline-interview-id').value = interviewId;
        document.getElementById('decline-job-title').textContent = 'Decline: ' + jobTitle;
        document.getElementById('decline-reason').value = '';
        document.getElementById('modal-decline').classList.remove('hidden');
        if (typeof event !== 'undefined') {
            event.stopPropagation();
        }
    };

    window.closeDeclineModal = function() {
        document.getElementById('modal-decline').classList.add('hidden');
    };

    document.getElementById('modal-decline').addEventListener('click', function(e) {
        if (e.target === this) closeDeclineModal();
    });

    window.submitDecline = async function() {
        const btn = document.getElementById('btn-submit-decline');
        const interviewId = document.getElementById('decline-interview-id').value;
        const reason = document.getElementById('decline-reason').value.trim();

        if (!reason) {
            alert('Please fill in the reason for declining.');
            document.getElementById('decline-reason').focus();
            return;
        }

        btn.disabled = true;
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

        try {
            const response = await fetch(`/pelamar/status-lamaran/interview/${interviewId}/decline`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    decline_reason: reason
                })
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Failed to decline interview.');

            closeDeclineModal();
            alert(data.message || 'Interview invitation declined successfully.');
            window.location.reload();
        } catch (err) {
            alert(err.message);
            btn.disabled = false;
            btn.innerHTML = originalContent;
        }
    };

});
</script>
@endsection