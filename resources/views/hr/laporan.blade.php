@extends('layouts.hr')

@section('title', 'Laporan Perekrutan')
@section('page-title', 'Laporan Perekrutan')
@section('nav-laporan', 'text-green-800 border-green-800')

@section('content')
<div class="px-6 py-8 max-w-7xl mx-auto">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-1">Recruitment Analytics</h2>
            <p class="text-gray-500 font-medium text-sm">Reporting Period: January 1, 2024 - June 30, 2024</p>
        </div>
        <button id="btn-export" class="bg-[#0f3c20] hover:bg-[#1b5e32] text-white font-semibold py-2.5 px-5 rounded-lg flex items-center gap-2 transition-colors shadow-sm text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Full Report
        </button>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" style="border-bottom: 4px solid #22c55e;">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">TOTAL APPLICANTS</h3>
                <div class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
            </div>
            <div class="text-3xl font-black text-[#0f3c20] mb-2">1,284</div>
            <div class="flex items-center gap-1.5 text-xs font-bold">
                <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span class="text-green-600">+12%</span>
                <span class="text-gray-400 font-medium">vs last month</span>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" style="border-bottom: 4px solid #22c55e;">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">TIME TO HIRE</h3>
                <div class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            </div>
            <div class="flex items-baseline gap-1 mb-2">
                <div class="text-3xl font-black text-[#0f3c20]">18</div>
                <div class="text-lg font-bold text-[#0f3c20]">Days</div>
            </div>
            <div class="flex items-center gap-1.5 text-xs font-bold">
                <svg class="w-3 h-3 text-green-600 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span class="text-green-600">-3 days</span>
                <span class="text-gray-400 font-medium">improvement</span>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" style="border-bottom: 4px solid #d1d5db;">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest">OFFER ACCEPTANCE</h3>
                <div class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            </div>
            <div class="text-3xl font-black text-[#0f3c20] mb-2">94.2%</div>
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
            <div class="text-3xl font-black text-[#0f3c20] mb-2">42%</div>
            <div class="flex items-center gap-1.5 text-xs font-bold">
                <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span class="text-green-600">+5%</span>
                <span class="text-gray-400 font-medium">profile quality</span>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="flex flex-col lg:flex-row gap-6 mb-6">

        {{-- Bar Chart --}}
        <div class="w-full lg:w-2/3 bg-white rounded-xl p-6 sm:p-8 border border-gray-100 shadow-sm flex flex-col">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-lg font-bold text-[#0f3c20]">Monthly Application Trends</h3>
                    <p class="text-xs text-gray-400 mt-1">Klik batang bulan untuk melihat detail</p>
                </div>
                <div class="flex items-center gap-4 text-xs font-bold text-gray-500">
                    <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full" style="background:#0f3c20;"></div>External</div>
                    <div class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full" style="background:#bfe3d0;"></div>Referral</div>
                </div>
            </div>
            <div style="height:240px; display:flex; align-items:flex-end; width:100%; gap:0;">
                <div data-month="JAN" style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;height:100%;padding:0 2px;transition:opacity 0.2s;">
                    <div style="height:60%;display:flex;flex-direction:column;justify-content:flex-end;">
                        <div style="width:100%;height:40%;background:#bfe3d0;"></div>
                        <div style="width:100%;height:60%;background:#0f3c20;"></div>
                    </div>
                    <div style="text-align:center;font-size:10px;font-weight:700;color:#111;margin-top:12px;">JAN</div>
                </div>
                <div data-month="FEB" style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;height:100%;padding:0 2px;transition:opacity 0.2s;">
                    <div style="height:45%;display:flex;flex-direction:column;justify-content:flex-end;">
                        <div style="width:100%;height:30%;background:#bfe3d0;"></div>
                        <div style="width:100%;height:70%;background:#0f3c20;"></div>
                    </div>
                    <div style="text-align:center;font-size:10px;font-weight:700;color:#111;margin-top:12px;">FEB</div>
                </div>
                <div data-month="MAR" style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;height:100%;padding:0 2px;transition:opacity 0.2s;">
                    <div style="height:35%;display:flex;flex-direction:column;justify-content:flex-end;">
                        <div style="width:100%;height:50%;background:#bfe3d0;"></div>
                        <div style="width:100%;height:50%;background:#0f3c20;"></div>
                    </div>
                    <div style="text-align:center;font-size:10px;font-weight:700;color:#111;margin-top:12px;">MAR</div>
                </div>
                <div data-month="APR" style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;height:100%;padding:0 2px;transition:opacity 0.2s;">
                    <div style="height:80%;display:flex;flex-direction:column;justify-content:flex-end;">
                        <div style="width:100%;height:25%;background:#bfe3d0;"></div>
                        <div style="width:100%;height:75%;background:#0f3c20;"></div>
                    </div>
                    <div style="text-align:center;font-size:10px;font-weight:700;color:#111;margin-top:12px;">APR</div>
                </div>
                <div data-month="MAY" style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;height:100%;padding:0 2px;transition:opacity 0.2s;">
                    <div style="height:55%;display:flex;flex-direction:column;justify-content:flex-end;">
                        <div style="width:100%;height:40%;background:#bfe3d0;"></div>
                        <div style="width:100%;height:60%;background:#0f3c20;"></div>
                    </div>
                    <div style="text-align:center;font-size:10px;font-weight:700;color:#111;margin-top:12px;">MAY</div>
                </div>
                <div data-month="JUN" style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;height:100%;padding:0 2px;transition:opacity 0.2s;">
                    <div style="height:65%;display:flex;flex-direction:column;justify-content:flex-end;">
                        <div style="width:100%;height:35%;background:#bfe3d0;"></div>
                        <div style="width:100%;height:65%;background:#0f3c20;"></div>
                    </div>
                    <div style="text-align:center;font-size:10px;font-weight:700;color:#111;margin-top:12px;">JUN</div>
                </div>
            </div>
        </div>

        {{-- Hiring Funnel --}}
        <div class="w-full lg:w-1/3 bg-gray-50 rounded-xl p-6 sm:p-8 border border-gray-100 flex flex-col">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-[#0f3c20]">Hiring Funnel</h3>
                <p class="text-xs text-gray-400 mt-1">Klik setiap tahap untuk detail</p>
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;flex:1;justify-content:center;">
                <div data-funnel="sourced" style="display:flex;align-items:center;transition:opacity 0.2s;">
                    <div style="flex:1;">
                        <div data-funnel-label style="width:100%;background:#0f3c20;color:white;font-size:13px;font-weight:500;padding:10px 0;text-align:center;">Sourced (1,284)</div>
                    </div>
                    <div style="font-size:11px;font-weight:700;color:#111;width:44px;text-align:right;flex-shrink:0;">100%</div>
                </div>
                <div data-funnel="screened" style="display:flex;align-items:center;transition:opacity 0.2s;">
                    <div style="flex:1;">
                        <div data-funnel-label style="width:80%;background:#1b5e32;color:white;font-size:13px;font-weight:500;padding:10px 0;text-align:center;">Screened (540)</div>
                    </div>
                    <div style="font-size:11px;font-weight:700;color:#111;width:44px;text-align:right;flex-shrink:0;">42%</div>
                </div>
                <div data-funnel="interviewed" style="display:flex;align-items:center;transition:opacity 0.2s;">
                    <div style="flex:1;">
                        <div data-funnel-label style="width:60%;background:#5b9c74;color:white;font-size:13px;font-weight:500;padding:10px 0;text-align:center;">Interviewed (124)</div>
                    </div>
                    <div style="font-size:11px;font-weight:700;color:#111;width:44px;text-align:right;flex-shrink:0;">9.6%</div>
                </div>
                <div data-funnel="offermade" style="display:flex;align-items:center;transition:opacity 0.2s;">
                    <div style="flex:1;">
                        <div data-funnel-label style="width:45%;background:#8cbe9f;color:white;font-size:13px;font-weight:500;padding:10px 0;text-align:center;">Offer Made (52)</div>
                    </div>
                    <div style="font-size:11px;font-weight:700;color:#111;width:44px;text-align:right;flex-shrink:0;">4%</div>
                </div>
                <div data-funnel="hired" style="display:flex;align-items:center;transition:opacity 0.2s;">
                    <div style="flex:1;">
                        <div data-funnel-label style="width:35%;background:#4ade80;color:white;font-size:13px;font-weight:500;padding:10px 0;text-align:center;">Hired (49)</div>
                    </div>
                    <div style="font-size:11px;font-weight:700;color:#111;width:44px;text-align:right;flex-shrink:0;">3.8%</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom --}}
    <div class="flex flex-col lg:flex-row gap-6 mb-12">

        {{-- Applicant Sources --}}
        <div class="w-full lg:w-1/2 bg-white rounded-xl p-6 sm:p-8 border border-gray-100 shadow-sm flex flex-col">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-[#0f3c20]">Applicant Sources</h3>
                <p class="text-xs text-gray-400 mt-1">Klik sumber untuk melihat detail</p>
            </div>
            <div style="display:flex;align-items:center;gap:32px;">
                <div style="width:160px;height:160px;background:#eaf6ef;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;">
                    <div style="font-size:36px;font-weight:900;color:#0f3c20;line-height:1;">1.2K+</div>
                    <div style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.1em;margin-top:4px;">LEADS</div>
                </div>
                <div style="flex:1;display:flex;flex-direction:column;gap:20px;">
                    <div data-source="linkedin" style="display:flex;align-items:flex-start;gap:12px;transition:opacity 0.2s;">
                        <div class="source-icon" style="width:16px;height:16px;background:#0f3c20;border-radius:2px;margin-top:2px;flex-shrink:0;transition:transform 0.2s;"></div>
                        <div>
                            <div style="font-size:14px;font-weight:700;color:#111;">LinkedIn</div>
                            <div style="font-size:11px;color:#6b7280;margin-top:2px;">55% (706 candidates)</div>
                        </div>
                    </div>
                    <div data-source="jobportal" style="display:flex;align-items:flex-start;gap:12px;transition:opacity 0.2s;">
                        <div class="source-icon" style="width:16px;height:16px;background:#1b5e32;border-radius:2px;margin-top:2px;flex-shrink:0;transition:transform 0.2s;"></div>
                        <div>
                            <div style="font-size:14px;font-weight:700;color:#111;">Job Portal</div>
                            <div style="font-size:11px;color:#6b7280;margin-top:2px;">25% (321 candidates)</div>
                        </div>
                    </div>
                    <div data-source="website" style="display:flex;align-items:flex-start;gap:12px;transition:opacity 0.2s;">
                        <div class="source-icon" style="width:16px;height:16px;background:#bfe3d0;border-radius:2px;margin-top:2px;flex-shrink:0;transition:transform 0.2s;"></div>
                        <div>
                            <div style="font-size:14px;font-weight:700;color:#111;">Website</div>
                            <div style="font-size:11px;color:#6b7280;margin-top:2px;">20% (257 candidates)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Departmental Efficiency --}}
        <div class="w-full lg:w-1/2 bg-white rounded-xl p-6 sm:p-8 border border-gray-100 shadow-sm flex flex-col">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-[#0f3c20]">Departmental Efficiency</h3>
                <p class="text-xs text-gray-400 mt-1">Klik baris departemen untuk detail</p>
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
                    <tr data-dept="manufacturing" style="border-bottom:1px solid #f9fafb;transition:background 0.15s;">
                        <td style="padding:14px 0;font-size:14px;font-weight:700;color:#0f3c20;">Manufacturing</td>
                        <td style="padding:14px 0;font-size:14px;font-weight:600;color:#374151;text-align:center;">12</td>
                        <td style="padding:14px 0;font-size:14px;font-weight:600;color:#374151;text-align:center;">22</td>
                        <td style="padding:14px 0;text-align:right;"><span style="background:#d1f4e0;color:#0f3c20;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;padding:3px 8px;border-radius:4px;">OPTIMAL</span></td>
                    </tr>
                    <tr data-dept="engineering" style="border-bottom:1px solid #f9fafb;transition:background 0.15s;">
                        <td style="padding:14px 0;font-size:14px;font-weight:700;color:#0f3c20;">Engineering</td>
                        <td style="padding:14px 0;font-size:14px;font-weight:600;color:#374151;text-align:center;">8</td>
                        <td style="padding:14px 0;font-size:14px;font-weight:600;color:#374151;text-align:center;">45</td>
                        <td style="padding:14px 0;text-align:right;"><span style="background:#fce8e8;color:#9b1c1c;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;padding:3px 8px;border-radius:4px;">CRITICAL</span></td>
                    </tr>
                    <tr data-dept="supplychain" style="border-bottom:1px solid #f9fafb;transition:background 0.15s;">
                        <td style="padding:14px 0;font-size:14px;font-weight:700;color:#0f3c20;">Supply Chain</td>
                        <td style="padding:14px 0;font-size:14px;font-weight:600;color:#374151;text-align:center;">15</td>
                        <td style="padding:14px 0;font-size:14px;font-weight:600;color:#374151;text-align:center;">14</td>
                        <td style="padding:14px 0;text-align:right;"><span style="background:#d1f4e0;color:#0f3c20;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;padding:3px 8px;border-radius:4px;">HIGH</span></td>
                    </tr>
                    <tr data-dept="rdlabor" style="transition:background 0.15s;">
                        <td style="padding:14px 0;font-size:14px;font-weight:700;color:#0f3c20;">R&D Labor</td>
                        <td style="padding:14px 0;font-size:14px;font-weight:600;color:#374151;text-align:center;">4</td>
                        <td style="padding:14px 0;font-size:14px;font-weight:600;color:#374151;text-align:center;">31</td>
                        <td style="padding:14px 0;text-align:right;"><span style="background:#f3f4f6;color:#374151;font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;padding:3px 8px;border-radius:4px;">AVERAGE</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script src="/js/laporan-charts.js"></script>
@endsection
