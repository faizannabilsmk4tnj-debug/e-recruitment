/**
 * HR Dashboard JS
 */
document.addEventListener('DOMContentLoaded', function () {

    const MAX_HEIGHT = 140; // px — bar tertinggi

    const chartData = window.dbChartData || {
        monthly: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'],
            values: [55, 72, 65, 88, 78, 100],
            activeIndex: 5
        },
        weekly: {
            labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
            values: [40, 60, 85, 55, 70, 45],
            activeIndex: 2
        },
        month_weeks: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', '', ''],
            values: [0, 0, 0, 0, 0, 0],
            activeIndex: -1
        }
    };
    if (!chartData.month_weeks) {
        chartData.month_weeks = {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', '', ''],
            values: [0, 0, 0, 0, 0, 0],
            activeIndex: -1
        };
    }

    let currentMode = 'monthly';
    const container = document.getElementById('chart-bars-container');
    const btnMonthly = document.getElementById('btn-monthly');
    const btnWeekly  = document.getElementById('btn-weekly');

    // Navigation elements
    const chartNav = document.getElementById('chart-nav');
    const btnChartPrev = document.getElementById('btn-chart-prev');
    const btnChartNext = document.getElementById('btn-chart-next');
    const chartSubDesc = document.getElementById('chart-sub-desc');

    // Offset state for calendar semester pages (Page 1: 0 for Jan-Jun, Page 2: 6 for Jul-Dec)
    // Default to the current month's semester
    let monthlyWindowStart = new Date().getMonth() < 6 ? 0 : 6;

    // ===== BAR TOOLTIP =====
    const tooltip = document.createElement('div');
    tooltip.className = 'fixed z-50 bg-green-900 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-lg pointer-events-none hidden';
    document.body.appendChild(tooltip);

    // ===== MODAL DETAIL CHART =====
    const chartModal = document.getElementById('chart-modal');
    const btnCloseChartModal = document.getElementById('btn-close-chart-modal');
    const chartModalTitle = document.getElementById('chart-modal-title');
    const chartModalTotal = document.getElementById('chart-modal-total');

    if (btnCloseChartModal) {
        btnCloseChartModal.addEventListener('click', () => chartModal.classList.add('hidden'));
        chartModal.addEventListener('click', (e) => {
            if(e.target === chartModal) chartModal.classList.add('hidden');
        });
    }

    const currentMonthStr = new Date().toLocaleString('en-US', { month: 'short' }).toUpperCase();
    const currentDayStr = new Date().toLocaleString('en-US', { weekday: 'short' }).toUpperCase();

    // ===== CHART UPDATE =====
    function updateChart(mode) {
        if (!container) return;
        container.innerHTML = '';

        const data   = chartData[mode];
        
        let valuesToRender = [];
        let labelsToRender = [];
        let activeIdxToRender = -1;

        if (mode === 'monthly') {
            // Show navigation arrows
            if (chartNav) chartNav.classList.remove('hidden');

            // Slide window of 6 months
            const start = monthlyWindowStart;
            const end = start + 6;
            valuesToRender = data.values.slice(start, end);
            labelsToRender = data.labels.slice(start, end);
            activeIdxToRender = data.activeIndex >= start && data.activeIndex < end 
                ? data.activeIndex - start 
                : -1;

            // Update disabled status of buttons
            if (btnChartPrev) btnChartPrev.disabled = (start === 0);
            if (btnChartNext) btnChartNext.disabled = (end >= data.values.length);

            // Update sub-desc dynamically
            if (chartSubDesc && labelsToRender.length > 0) {
                chartSubDesc.textContent = `Applicant activity from ${labelsToRender[0]} to ${labelsToRender[labelsToRender.length - 1]}`;
            }
        } else {
            // Hide navigation arrows
            if (chartNav) chartNav.classList.add('hidden');

            valuesToRender = data.values;
            labelsToRender = data.labels;
            activeIdxToRender = data.activeIndex;

            if (chartSubDesc) {
                if (mode === 'weekly') {
                    chartSubDesc.textContent = "Applicant activity in the last 7 days";
                } else if (mode === 'month_weeks') {
                    chartSubDesc.textContent = "Weekly breakdown for selected month";
                }
            }
        }

        const maxVal = Math.max(...valuesToRender) || 1;

        valuesToRender.forEach((val, i) => {
            const labelStr = labelsToRender[i];
            const height = Math.round((val / maxVal) * MAX_HEIGHT);

            const isCurrent = (mode === 'monthly' && labelStr === currentMonthStr) ||
                              (mode === 'weekly' && labelStr === currentDayStr) ||
                              (i === activeIdxToRender);

            const barColor = isCurrent ? 'bg-green-800' : 'bg-green-200';
            const textColor = isCurrent ? 'text-green-800 font-semibold' : 'text-gray-400 font-semibold';

            const barWrapper = document.createElement('div');
            barWrapper.className = 'flex-1 flex flex-col items-center gap-2 h-full justify-end';

            const bar = document.createElement('div');
            bar.className = `w-full rounded-t-lg ${barColor} chart-bar transition-all duration-500`;
            bar.style.height = height + 'px';
            bar.style.cursor = 'pointer';
            
            if (mode === 'weekly' && data.dates && data.dates[i]) {
                bar.setAttribute('data-date', data.dates[i]);
            }

            const label = document.createElement('span');
            label.className = `text-[10px] ${textColor} chart-label`;
            label.textContent = labelStr;

            barWrapper.appendChild(bar);
            barWrapper.appendChild(label);
            container.appendChild(barWrapper);

            // Add Event Listeners for Tooltip
            bar.addEventListener('mouseenter', () => {
                const dateStr = bar.getAttribute('data-date');
                const displayLabel = dateStr ? `${labelStr} (${dateStr})` : labelStr;
                tooltip.textContent = displayLabel + ': ' + val + ' applicants';
                tooltip.classList.remove('hidden');
            });
            bar.addEventListener('mousemove', e => {
                tooltip.style.left = (e.clientX + 12) + 'px';
                tooltip.style.top  = (e.clientY - 34) + 'px';
            });
            bar.addEventListener('mouseleave', () => tooltip.classList.add('hidden'));

            // Click action
            bar.addEventListener('click', () => {
                if (mode === 'monthly') {
                    // Drill-down to month_weeks view
                    const monthTotal = val;
                    chartData.month_weeks.values = [
                        Math.round(monthTotal * 0.25),
                        Math.round(monthTotal * 0.3),
                        Math.round(monthTotal * 0.25),
                        monthTotal - Math.round(monthTotal * 0.25)*2 - Math.round(monthTotal * 0.3),
                        0, 0
                    ];
                    updateChart('month_weeks');
                    btnMonthly?.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
                    btnMonthly?.classList.add('text-gray-500');
                    btnWeekly?.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
                    btnWeekly?.classList.add('text-gray-500');
                } else if (mode === 'month_weeks') {
                    if (!labelStr || val === 0) return;
                    showMonthWeeksModal(labelStr, val);
                } else if (mode === 'weekly') {
                    if (!labelStr || val === 0) return;
                    const dateVal = bar.getAttribute('data-date') || '';
                    showWeeklyModal(labelStr, val, dateVal);
                }
            });
        });

        currentMode = mode;
    }

    // Attach click events to nav arrows (Semester pagination: Jan-Jun vs Jul-Dec)
    btnChartPrev?.addEventListener('click', () => {
        if (currentMode === 'monthly') {
            monthlyWindowStart = 0; // Go to Jan-Jun page
            updateChart('monthly');
        }
    });

    btnChartNext?.addEventListener('click', () => {
        if (currentMode === 'monthly') {
            monthlyWindowStart = 6; // Go to Jul-Dec page
            updateChart('monthly');
        }
    });

    function showMonthWeeksModal(labelStr, total) {
        if (!chartModalTitle) return;
        chartModalTitle.textContent = labelStr;
        
        const v1 = Math.round(total * 0.2);
        const v2 = Math.round(total * 0.15);
        const v3 = Math.round(total * 0.2);
        const v4 = Math.round(total * 0.15);
        const v5 = Math.round(total * 0.15);
        const v6 = Math.round(total * 0.1);
        const v7 = total - v1 - v2 - v3 - v4 - v5 - v6;
        
        const dailyHtml = `
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Incoming Applicants</span>
                <span class="text-lg font-bold text-green-700">${total} ${total === 1 ? 'Applicant' : 'Applicants'}</span>
            </div>
            <div class="space-y-2.5 border-t border-gray-200 pt-4 mt-1">
                <div class="flex justify-between items-center text-sm text-gray-600"><span>Monday</span><span class="font-semibold text-gray-800">${v1}</span></div>
                <div class="flex justify-between items-center text-sm text-gray-600"><span>Tuesday</span><span class="font-semibold text-gray-800">${v2}</span></div>
                <div class="flex justify-between items-center text-sm text-gray-600"><span>Wednesday</span><span class="font-semibold text-gray-800">${v3}</span></div>
                <div class="flex justify-between items-center text-sm text-gray-600"><span>Thursday</span><span class="font-semibold text-gray-800">${v4}</span></div>
                <div class="flex justify-between items-center text-sm text-gray-600"><span>Friday</span><span class="font-semibold text-gray-800">${v5}</span></div>
                <div class="flex justify-between items-center text-sm text-gray-600"><span>Saturday</span><span class="font-semibold text-gray-800">${v6}</span></div>
                <div class="flex justify-between items-center text-sm text-gray-600"><span>Sunday</span><span class="font-semibold text-gray-800">${v7}</span></div>
            </div>
        `;
        document.getElementById('chart-modal-desc').textContent = "Here is the daily applicant breakdown for this week.";
        document.getElementById('chart-modal-content').innerHTML = dailyHtml;
        chartModal.classList.remove('hidden');
    }

    function showWeeklyModal(labelStr, total, dateStr) {
        if (!chartModalTitle) return;
        chartModalTitle.textContent = "Day " + labelStr + (dateStr ? ` (${dateStr})` : '');

        // Guarantee that the sum of parts is mathematically equal to total
        const p1 = Math.round(total * 0.40); // Applied
        const p2 = Math.round(total * 0.25); // Shortlisted
        const p3 = Math.round(total * 0.15); // Interview
        const p4 = Math.round(total * 0.10); // Accepted
        const p5 = total - p1 - p2 - p3 - p4; // Rejected

        const dailyHtml = `
            <div class="flex justify-between items-center mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Incoming Applicants</span>
                <span class="text-lg font-bold text-green-700">${total} ${total === 1 ? 'Applicant' : 'Applicants'}</span>
            </div>
            <div class="space-y-2.5 border-t border-gray-200 pt-4 mt-1">
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-blue-500"></div><span>Applied</span></div>
                    <span class="font-semibold text-gray-800">${p1}</span>
                </div>
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-teal-500"></div><span>Shortlisted</span></div>
                    <span class="font-semibold text-gray-800">${p2}</span>
                </div>
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-purple-500"></div><span>Interview</span></div>
                    <span class="font-semibold text-gray-800">${p3}</span>
                </div>
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-emerald-500"></div><span>Accepted</span></div>
                    <span class="font-semibold text-gray-800">${p4}</span>
                </div>
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-red-500"></div><span>Rejected</span></div>
                    <span class="font-semibold text-gray-800">${p5}</span>
                </div>
            </div>
        `;
        document.getElementById('chart-modal-desc').textContent = "Here is the applicant status breakdown for that day.";
        document.getElementById('chart-modal-content').innerHTML = dailyHtml;
        chartModal.classList.remove('hidden');
    }

    function setActiveBtn(active, inactive) {
        active.classList.add('bg-white', 'text-gray-800', 'shadow-sm');
        active.classList.remove('text-gray-500');
        inactive.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
        inactive.classList.add('text-gray-500');
    }

    btnMonthly?.addEventListener('click', () => { updateChart('monthly'); setActiveBtn(btnMonthly, btnWeekly); });
    btnWeekly?.addEventListener('click',  () => { updateChart('weekly');  setActiveBtn(btnWeekly,  btnMonthly); });

    // Initial Render
    updateChart('monthly');

    // ===== STATUS LOWONGAN: dots menu =====
    const lowonganDropdown = document.createElement('div');
    lowonganDropdown.id = 'lowongan-dd';
    lowonganDropdown.className = 'absolute bg-white border border-gray-200 rounded-xl shadow-lg z-50 w-40 py-1.5 hidden';
    lowonganDropdown.style.minWidth = '160px';
    lowonganDropdown.innerHTML = `
        <button class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            View Details
        </button>
        <button class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit Vacancy
        </button>`;

    document.querySelectorAll('tbody button').forEach(btn => {
        btn.closest('td').style.position = 'relative';

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const parent = this.closest('td');
            const isCurrentlyHere = lowonganDropdown.parentNode === parent;
            
            parent.appendChild(lowonganDropdown);
            lowonganDropdown.style.top   = '100%';
            lowonganDropdown.style.right = '0';
            lowonganDropdown.style.left  = 'auto';
            
            if (isCurrentlyHere) {
                lowonganDropdown.classList.toggle('hidden');
            } else {
                lowonganDropdown.classList.remove('hidden');
            }
        });
    });

    document.addEventListener('click', () => lowonganDropdown.classList.add('hidden'));
    lowonganDropdown.addEventListener('click', e => e.stopPropagation());

    // ===== JADWAL WAWANCARA =====
    const hasWawancara = window.dbChartData && window.dbChartData.wawancara && Object.keys(window.dbChartData.wawancara).length > 0;
    const wawancaraData = hasWawancara ? window.dbChartData.wawancara : {
        '2026-04-30': [
            { time: '09:00', name: 'Budi Santoso', role: 'Technical Lead - R&D', location: 'Google Meet', isOnline: true, statusClass: 'border-green-700' },
            { time: '11:30', name: 'Siska Wijaya', role: 'Finance Supervisor', location: 'Ruang Meeting A2', isOnline: false, statusClass: 'border-gray-300' },
            { time: '14:00', name: 'Ahmad Fauzi', role: 'Maintenance Staff', location: 'Workshop Utama', isOnline: false, statusClass: 'border-gray-300' }
        ],
        '2026-05-01': [
            { time: '10:00', name: 'Dewi Lestari', role: 'HR Staff', location: 'Zoom', isOnline: true, statusClass: 'border-yellow-500' },
            { time: '13:00', name: 'Andi Saputra', role: 'IT Support', location: 'Google Meet', isOnline: true, statusClass: 'border-gray-300' }
        ],
        '2026-05-05': [
            { time: '08:30', name: 'Diana Putri', role: 'Data Analyst', location: 'Google Meet', isOnline: true, statusClass: 'border-green-700' }
        ],
        '2026-05-12': [
            { time: '09:00', name: 'Rina Melati', role: 'Marketing Manager', location: 'Ruang Meeting B1', isOnline: false, statusClass: 'border-blue-500' },
            { time: '14:00', name: 'Joko Anwar', role: 'Sales Executive', location: 'Zoom', isOnline: true, statusClass: 'border-gray-300' }
        ]
    };

    const wawancaraDateSelect = document.getElementById('wawancara-date');
    const wawancaraList = document.getElementById('wawancara-list');
    const wawancaraEmpty = document.getElementById('wawancara-empty');
    const wawancaraCount = document.getElementById('wawancara-count');

    function renderWawancara(dateKey) {
        if (!wawancaraList) return;
        
        const data = wawancaraData[dateKey] || [];
        wawancaraList.innerHTML = '';
        
        if (data.length === 0) {
            wawancaraList.classList.add('hidden');
            wawancaraEmpty.classList.remove('hidden');
            wawancaraCount.textContent = '0 Sessions';
            wawancaraCount.className = 'text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-full';
        } else {
            wawancaraList.classList.remove('hidden');
            wawancaraEmpty.classList.add('hidden');
            wawancaraCount.textContent = data.length === 1 ? '1 Session' : data.length + ' Sessions';
            wawancaraCount.className = 'text-xs font-bold text-green-700 bg-green-50 px-2 py-1 rounded-full';
            
            const visibleData = data.slice(0, 3);
            
            visibleData.forEach(item => {
                const iconHtml = item.isOnline 
                    ? `<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="14" x="3" y="5" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>`
                    : `<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>`;
                    
                const card = document.createElement('a');
                card.href = '/hr/wawancara/daftar?date=' + dateKey;
                card.className = 'flex gap-4 items-start group hover:bg-gray-50 p-2 -mx-2 rounded-xl transition-colors cursor-pointer';
                card.innerHTML = `
                    <div class="text-center shrink-0 w-12 pt-2">
                        <p class="text-sm font-bold text-gray-900 leading-none">${item.time}</p>
                    </div>
                    <div class="flex-1 bg-gray-50 group-hover:bg-white group-hover:shadow-sm rounded-xl p-3 border-l-4 ${item.statusClass} transition-all">
                        <p class="font-bold text-sm text-gray-900">${item.name}</p>
                        <p class="text-xs text-gray-500 mt-0.5">${item.role}</p>
                        <div class="flex items-center gap-1 mt-2 text-xs text-gray-400">
                            ${iconHtml}
                            ${item.location}
                        </div>
                    </div>
                `;
                wawancaraList.appendChild(card);
            });
            
            // Add "Lihat Semua" button
            const btnAll = document.createElement('a');
            btnAll.href = '/hr/wawancara/daftar?date=' + dateKey;
            btnAll.className = 'block w-full text-center text-sm font-semibold text-green-700 hover:text-green-800 bg-green-50 hover:bg-green-100 py-2.5 rounded-xl transition-colors mt-2';
            btnAll.textContent = data.length > 3 ? `View All (${data.length} Sessions)` : 'Manage All Schedules';
            wawancaraList.appendChild(btnAll);
        }
    }

    // ===== CARD TOGGLES =====
    const btnAppToday   = document.getElementById('btn-applicants-today');
    const btnAppOverall = document.getElementById('btn-applicants-overall');
    const lblApplicants = document.getElementById('label-applicants');
    const valApplicants = document.getElementById('value-applicants');
    const changeApplicants = document.getElementById('change-applicants');
    const infoApplicantsTooltip = document.getElementById('info-applicants-tooltip');

    function renderApplicantsChange(mode) {
        if (!changeApplicants) return;
        const added = parseInt(changeApplicants.getAttribute(`data-${mode}-added`)) || 0;
        const removed = parseInt(changeApplicants.getAttribute(`data-${mode}-removed`)) || 0;
        let html = '';
        if (added > 0) html += `<span class="text-green-600">+${added}</span>`;
        if (removed > 0) html += `<span class="text-red-500">-${removed}</span>`;
        changeApplicants.innerHTML = html;

        if (infoApplicantsTooltip) {
            if (mode === 'today') {
                infoApplicantsTooltip.innerHTML = '<p class="text-green-400 mb-1">+ : applied today</p><p class="text-red-400">- : withdrawn today</p>';
            } else {
                infoApplicantsTooltip.innerHTML = '<p class="text-green-400 mb-1">+ : total applied</p><p class="text-red-400">- : total withdrawn</p>';
            }
        }
    }

    if (btnAppToday && btnAppOverall && lblApplicants && valApplicants) {
        btnAppToday.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            valApplicants.textContent = valApplicants.getAttribute('data-today');
            lblApplicants.textContent = "Total Applicants Today";
            renderApplicantsChange('today');
            
            btnAppToday.classList.add('bg-white', 'text-gray-800', 'shadow-sm');
            btnAppToday.classList.remove('text-gray-500');
            btnAppOverall.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
            btnAppOverall.classList.add('text-gray-500');
        });

        btnAppOverall.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            valApplicants.textContent = valApplicants.getAttribute('data-overall');
            lblApplicants.textContent = "Total Applicants Overall";
            renderApplicantsChange('overall');
            
            btnAppOverall.classList.add('bg-white', 'text-gray-800', 'shadow-sm');
            btnAppOverall.classList.remove('text-gray-500');
            btnAppToday.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
            btnAppToday.classList.add('text-gray-500');
        });
    }

    const btnIntWeek    = document.getElementById('btn-interviews-week');
    const btnIntOverall = document.getElementById('btn-interviews-overall');
    const lblInterviews = document.getElementById('label-interviews');
    const valInterviews = document.getElementById('value-interviews');
    const changeInterviews = document.getElementById('change-interviews');
    const infoInterviewsTooltip = document.getElementById('info-interviews-tooltip');

    function renderInterviewsChange(mode) {
        if (!changeInterviews) return;
        const added = parseInt(changeInterviews.getAttribute(`data-${mode}-added`)) || 0;
        const removed = parseInt(changeInterviews.getAttribute(`data-${mode}-removed`)) || 0;
        let html = '';
        if (added > 0) html += `<span class="text-green-600">+${added}</span>`;
        if (removed > 0) html += `<span class="text-red-500">-${removed}</span>`;
        changeInterviews.innerHTML = html;

        if (infoInterviewsTooltip) {
            if (mode === 'week') {
                infoInterviewsTooltip.innerHTML = '<p class="text-green-400 mb-1">+ : scheduled this week</p><p class="text-red-400">- : cancelled this week</p>';
            } else {
                infoInterviewsTooltip.innerHTML = '<p class="text-green-400 mb-1">+ : total scheduled</p><p class="text-red-400">- : total cancelled</p>';
            }
        }
    }

    if (btnIntWeek && btnIntOverall && lblInterviews && valInterviews) {
        btnIntWeek.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            valInterviews.textContent = valInterviews.getAttribute('data-week');
            lblInterviews.textContent = "Interviews This Week";
            renderInterviewsChange('week');
            
            btnIntWeek.classList.add('bg-white', 'text-gray-800', 'shadow-sm');
            btnIntWeek.classList.remove('text-gray-500');
            btnIntOverall.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
            btnIntOverall.classList.add('text-gray-500');
        });

        btnIntOverall.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            valInterviews.textContent = valInterviews.getAttribute('data-overall');
            lblInterviews.textContent = "Total Scheduled Interviews";
            renderInterviewsChange('overall');
            
            btnIntOverall.classList.add('bg-white', 'text-gray-800', 'shadow-sm');
            btnIntOverall.classList.remove('text-gray-500');
            btnIntWeek.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
            btnIntWeek.classList.add('text-gray-500');
        });
    }

    // Initial render for changes
    renderApplicantsChange('today');
    renderInterviewsChange('week');

    // Click/Hover logic for the new custom styled tooltips
    document.querySelectorAll('.relative.inline-block').forEach(wrapper => {
        const btn = wrapper.querySelector('.info-btn');
        const tooltip = wrapper.querySelector('.info-tooltip');
        if (btn && tooltip) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                // Close any other open info tooltips first
                document.querySelectorAll('.info-tooltip').forEach(t => {
                    if (t !== tooltip) t.classList.add('hidden');
                });
                tooltip.classList.toggle('hidden');
            });

            wrapper.addEventListener('mouseleave', () => {
                tooltip.classList.add('hidden');
            });
        }
    });

    if (wawancaraDateSelect) {
        wawancaraDateSelect.addEventListener('change', (e) => {
            renderWawancara(e.target.value);
        });
        // Initial render
        renderWawancara(wawancaraDateSelect.value);
    }

});