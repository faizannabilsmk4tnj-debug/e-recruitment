@extends('layouts.hr')

@section('title', 'Recruitment Reports')
@section('page-title', 'Recruitment Reports')
@section('nav-laporan', 'text-green-800 border-green-800')

@section('content')
<div class="px-6 py-8 max-w-7xl mx-auto">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-1">Recruitment Analytics</h2>
            <p class="text-gray-500 font-medium text-sm">Reporting Period: January 1, 2026 - June 30, 2026</p>
        </div>
        <button id="btn-export" class="bg-[#15803d] hover:bg-[#166534] text-white font-semibold py-2.5 px-5 rounded-lg flex items-center gap-2 transition-colors shadow-sm text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Full Report
        </button>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" style="border-bottom: 4px solid #22c55e;">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">TOTAL APPLICANTS</h3>
                <div class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
            </div>
            <div class="text-3xl font-black text-[#15803d] mb-2">{{ number_format($sourcedCount) }}</div>
            <div class="flex items-center gap-1.5 text-xs font-bold">
                @if($applicantMoM >= 0)
                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    <span class="text-green-600">+{{ $applicantMoM }}%</span>
                @else
                    <svg class="w-3 h-3 text-red-600 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    <span class="text-red-600">{{ $applicantMoM }}%</span>
                @endif
                <span class="text-gray-400 font-medium">vs last month</span>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" style="border-bottom: 4px solid #d1d5db;">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">OFFER ACCEPTANCE</h3>
                <div class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            </div>
            <div class="text-3xl font-black text-[#15803d] mb-2">{{ number_format($offerAcceptanceRate, 1) }}%</div>
            <div class="flex items-center gap-1.5 text-xs font-bold">
                <span class="text-gray-400">— Stable</span>
                <span class="text-gray-400 font-medium">performance</span>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" style="border-bottom: 4px solid #22c55e;">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">QUALIFIED RATIO</h3>
                <div class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg></div>
            </div>
            <div class="text-3xl font-black text-[#15803d] mb-2">{{ $qualifiedRatio }}%</div>
            <div class="flex items-center gap-1.5 text-xs font-bold">
                <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span class="text-green-600">Profile quality</span>
                <span class="text-gray-400 font-medium">ratio</span>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="flex flex-col lg:flex-row gap-6 mb-6">

        {{-- Bar Chart --}}
        <div class="w-full lg:w-2/3 bg-white rounded-xl p-6 sm:p-8 border border-gray-100 shadow-sm flex flex-col">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-lg font-bold text-[#15803d]">Monthly Application Trends</h3>
                    <p class="text-xs text-gray-400 mt-1">Click on a month bar to see details</p>
                </div>
                <div class="flex items-center gap-4 text-xs font-bold text-gray-500">
                    <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full" style="background:#15803d;"></div>External</div>
                    <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full" style="background:#bfe3d0;"></div>Referral</div>
                </div>
            </div>
            <div style="height:240px; display:flex; align-items:flex-end; width:100%; gap:0;">
                @php
                    $maxMonthlyTotal = collect($monthlyData)->max('total') ?: 1;
                @endphp
                @foreach($monthlyData as $month => $mdata)
                    @php
                        $totalHeight = max(5, ($mdata['total'] / $maxMonthlyTotal) * 100);
                        $externalPct = $mdata['total'] > 0 ? ($mdata['external'] / $mdata['total']) * 100 : 70;
                        $referralPct = 100 - $externalPct;
                    @endphp
                    <div data-month="{{ $month }}" style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;height:100%;padding:0 4px;transition:opacity 0.2s;">
                        <div style="height:{{ $totalHeight }}%;display:flex;flex-direction:column;justify-content:flex-end;">
                            <div style="width:100%;height:{{ $referralPct }}%;background:#bfe3d0;"></div>
                            <div style="width:100%;height:{{ $externalPct }}%;background:#15803d;"></div>
                        </div>
                        <div style="text-align:center;font-size:10px;font-weight:700;color:#111;margin-top:12px;">{{ $month }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Hiring Funnel --}}
        <div class="w-full lg:w-1/3 bg-gray-50 rounded-xl p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-[#15803d]">Hiring Funnel</h3>
                <p class="text-xs text-gray-400 mt-1">Click on each stage for details</p>
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;flex:1;justify-content:center;">
                <div data-funnel="sourced" style="display:flex;align-items:center;transition:opacity 0.2s;">
                    <div style="flex:1;">
                        <div data-funnel-label style="width:100%;background:#15803d;color:white;font-size:13px;font-weight:500;padding:10px 0;text-align:center;">Sourced ({{ number_format($funnelData['sourced']['count']) }})</div>
                    </div>
                    <div style="font-size:11px;font-weight:700;color:#111;width:44px;text-align:right;flex-shrink:0;">{{ $funnelData['sourced']['pct'] }}</div>
                </div>
                <div data-funnel="screened" style="display:flex;align-items:center;transition:opacity 0.2s;">
                    @php
                        $widthScreened = max(35, floatval(str_replace('%', '', $funnelData['screened']['pct'])));
                    @endphp
                    <div style="flex:1;">
                        <div data-funnel-label style="width:{{ $widthScreened }}%;background:#166534;color:white;font-size:13px;font-weight:500;padding:10px 0;text-align:center;">Screened ({{ number_format($funnelData['screened']['count']) }})</div>
                    </div>
                    <div style="font-size:11px;font-weight:700;color:#111;width:44px;text-align:right;flex-shrink:0;">{{ $funnelData['screened']['pct'] }}</div>
                </div>
                <div data-funnel="interviewed" style="display:flex;align-items:center;transition:opacity 0.2s;">
                    @php
                        $widthInterviewed = max(30, floatval(str_replace('%', '', $funnelData['interviewed']['pct'])));
                    @endphp
                    <div style="flex:1;">
                        <div data-funnel-label style="width:{{ $widthInterviewed }}%;background:#5b9c74;color:white;font-size:13px;font-weight:500;padding:10px 0;text-align:center;">Interviewed ({{ number_format($funnelData['interviewed']['count']) }})</div>
                    </div>
                    <div style="font-size:11px;font-weight:700;color:#111;width:44px;text-align:right;flex-shrink:0;">{{ $funnelData['interviewed']['pct'] }}</div>
                </div>
                <div data-funnel="offermade" style="display:flex;align-items:center;transition:opacity 0.2s;">
                    @php
                        $widthOffer = max(25, floatval(str_replace('%', '', $funnelData['offermade']['pct'])));
                    @endphp
                    <div style="flex:1;">
                        <div data-funnel-label style="width:{{ $widthOffer }}%;background:#8cbe9f;color:white;font-size:13px;font-weight:500;padding:10px 0;text-align:center;">Offer Made ({{ number_format($funnelData['offermade']['count']) }})</div>
                    </div>
                    <div style="font-size:11px;font-weight:700;color:#111;width:44px;text-align:right;flex-shrink:0;">{{ $funnelData['offermade']['pct'] }}</div>
                </div>
                <div data-funnel="hired" style="display:flex;align-items:center;transition:opacity 0.2s;">
                    @php
                        $widthHired = max(20, floatval(str_replace('%', '', $funnelData['hired']['pct'])));
                    @endphp
                    <div style="flex:1;">
                        <div data-funnel-label style="width:{{ $widthHired }}%;background:#4ade80;color:white;font-size:13px;font-weight:500;padding:10px 0;text-align:center;">Hired ({{ number_format($funnelData['hired']['count']) }})</div>
                    </div>
                    <div style="font-size:11px;font-weight:700;color:#111;width:44px;text-align:right;flex-shrink:0;">{{ $funnelData['hired']['pct'] }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom --}}
    <div class="flex flex-col lg:flex-row gap-6 mb-12">

        {{-- Applicant Sources --}}
        <div class="w-full lg:w-1/2 bg-white rounded-xl p-6 sm:p-8 border border-gray-100 shadow-sm flex flex-col">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-[#15803d]">Applicant Sources</h3>
                <p class="text-xs text-gray-400 mt-1">Click on a source to see details</p>
            </div>
            <div style="display:flex;align-items:center;gap:32px;">
                <div style="width:160px;height:160px;background:#eaf6ef;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;">
                    <div style="font-size:36px;font-weight:900;color:#15803d;line-height:1;">
                        @if($sourcedCount >= 1000)
                            {{ round($sourcedCount / 1000, 1) }}K+
                        @else
                            {{ $sourcedCount }}
                        @endif
                    </div>
                    <div style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.1em;margin-top:4px;">LEADS</div>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:20px;">
                    <div data-source="linkedin" style="display:flex;align-items:flex-start;gap:12px;transition:opacity 0.2s;">
                        <div class="source-icon" style="width:16px;height:16px;background:#15803d;border-radius:2px;margin-top:2px;flex-shrink:0;transition:transform 0.2s;"></div>
                        <div>
                            <div style="font-size:14px;font-weight:700;color:#111;">{{ $sourceData['linkedin']['label'] }}</div>
                            <div style="font-size:11px;color:#6b7280;margin-top:2px;">{{ $sourceData['linkedin']['pct'] }} ({{ number_format($sourceData['linkedin']['count']) }} candidates)</div>
                        </div>
                    </div>
                    <div data-source="jobportal" style="display:flex;align-items:flex-start;gap:12px;transition:opacity 0.2s;">
                        <div class="source-icon" style="width:16px;height:16px;background:#166534;border-radius:2px;margin-top:2px;flex-shrink:0;transition:transform 0.2s;"></div>
                        <div>
                            <div style="font-size:14px;font-weight:700;color:#111;">{{ $sourceData['jobportal']['label'] }}</div>
                            <div style="font-size:11px;color:#6b7280;margin-top:2px;">{{ $sourceData['jobportal']['pct'] }} ({{ number_format($sourceData['jobportal']['count']) }} candidates)</div>
                        </div>
                    </div>
                    <div data-source="website" style="display:flex;align-items:flex-start;gap:12px;transition:opacity 0.2s;">
                        <div class="source-icon" style="width:16px;height:16px;background:#bfe3d0;border-radius:2px;margin-top:2px;flex-shrink:0;transition:transform 0.2s;"></div>
                        <div>
                            <div style="font-size:14px;font-weight:700;color:#111;">{{ $sourceData['website']['label'] }}</div>
                            <div style="font-size:11px;color:#6b7280;margin-top:2px;">{{ $sourceData['website']['pct'] }} ({{ number_format($sourceData['website']['count']) }} candidates)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Departmental Efficiency --}}
        <div class="w-full lg:w-1/2 bg-white rounded-xl p-6 sm:p-8 border border-gray-100 shadow-sm flex flex-col">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-[#15803d]">Departmental Efficiency</h3>
                <p class="text-xs text-gray-400 mt-1">Click on a department row for details</p>
            </div>
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:2px solid #f3f4f6;">
                        <th style="padding-bottom:14px;font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;text-align:left;">Department</th>
                        <th style="padding-bottom:14px;font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;text-align:center;">Open Roles</th>
                        <th style="padding-bottom:14px;font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;text-align:center;">Avg. Days</th>
                        <th style="padding-bottom:14px;font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;text-align:right;">Efficiency</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deptData as $key => $d)
                        <tr data-dept="{{ $key }}" style="border-bottom:1px solid #f9fafb;transition:background 0.15s;">
                            <td style="padding:14px 0;font-size:14px;font-weight:700;color:#15803d;">{{ $d['name'] }}</td>
                            <td style="padding:14px 0;font-size:14px;font-weight:600;color:#374151;text-align:center;">{{ $d['roles'] }}</td>
                            <td style="padding:14px 0;font-size:14px;font-weight:600;color:#374151;text-align:center;">{{ $d['days'] }}</td>
                            <td style="padding:14px 0;text-align:right;">
                                <span style="background:{{ $d['bg'] }};color:{{ $d['color'] }};font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;padding:3px 8px;border-radius:4px;">{{ $d['status'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Job Postings Detailed Analytics (Stored Procedure) --}}
    <div class="bg-white rounded-xl p-6 sm:p-8 border border-gray-100 shadow-sm mb-12">
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-[#15803d]">Vacancy Detailed Performance</h3>
                <p class="text-xs text-gray-400 mt-1">Generated dynamically using database stored procedure <code>sp_laporan_rekrutmen()</code></p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Job Title</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Max Applicants</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Passing Grade</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Age Limit</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Total Applicants</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Funnel (W/S/I/R/A)</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Avg Score</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jobReports as $report)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $report->job_title }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($report->job_status === 'open')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Open
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Closed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-gray-700">{{ $report->quota ?: '—' }}</td>
                            <td class="px-6 py-4 text-center font-semibold text-gray-700">{{ $report->passing_grade ?: '—' }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                @if($report->age_min || $report->age_max)
                                    {{ $report->age_min ?: 0 }} - {{ $report->age_max ?: '∞' }}
                                @else
                                    Any
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-[#15803d]">{{ $report->total_pelamar }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center gap-1">
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded text-xs" title="Awaiting Review">{{ $report->menunggu }}</span>
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-xs" title="Shortlisted">{{ $report->shortlisted }}</span>
                                    <span class="px-2 py-0.5 bg-amber-100 text-amber-700 rounded text-xs" title="Interview">{{ $report->interview }}</span>
                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs" title="Rejected">{{ $report->ditolak }}</span>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs" title="Accepted">{{ $report->diterima }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-900">
                                @if($report->rata_rata_skor_interview)
                                    {{ $report->rata_rata_skor_interview }} <span class="text-xs text-gray-400 font-normal">({{ $report->skor_terendah }}-{{ $report->skor_tertinggi }})</span>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-400 font-medium">No job report data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script>
    // Inject dynamic data for JS charts script
    window.recruitmentReportsData = {
        sourcedCount: {{ $sourcedCount }},
        applicantMoM: {{ $applicantMoM }},
        offerAcceptanceRate: {{ $offerAcceptanceRate }},
        qualifiedRatio: {{ $qualifiedRatio }},
        monthlyData: @json($monthlyData),
        funnelData: @json($funnelData),
        sourceData: @json($sourceData),
        deptData: @json($deptData)
    };
</script>
<script src="/js/laporan-charts.js"></script>
@endsection
