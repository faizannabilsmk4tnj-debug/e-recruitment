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
    const bars       = document.querySelectorAll('.chart-bar');
    const chartLabels = document.querySelectorAll('.chart-label');
    const btnMonthly = document.getElementById('btn-monthly');
    const btnWeekly  = document.getElementById('btn-weekly');

    // ===== CHART UPDATE =====
    function updateChart(mode) {
        const data   = chartData[mode];
        const maxVal = Math.max(...data.values);

        bars.forEach((bar, i) => {
            const height = Math.round((data.values[i] / maxVal) * MAX_HEIGHT);
            bar.style.height = height + 'px';

            if (i === data.activeIndex) {
                bar.classList.remove('bg-green-200');
                bar.classList.add('bg-green-800');
            } else {
                bar.classList.remove('bg-green-800');
                bar.classList.add('bg-green-200');
            }
        });

        chartLabels.forEach((lbl, i) => {
            lbl.textContent = data.labels[i];
            if (i === data.activeIndex) {
                lbl.classList.add('text-green-800');
                lbl.classList.remove('text-gray-400');
            } else {
                lbl.classList.remove('text-green-800');
                lbl.classList.add('text-gray-400');
            }
        });

        currentMode = mode;
    }

    function setActiveBtn(active, inactive) {
        active.classList.add('bg-white', 'text-gray-800', 'shadow-sm');
        active.classList.remove('text-gray-500');
        inactive.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
        inactive.classList.add('text-gray-500');
    }

    btnMonthly?.addEventListener('click', () => { updateChart('monthly'); setActiveBtn(btnMonthly, btnWeekly); });
    btnWeekly?.addEventListener('click',  () => { updateChart('weekly');  setActiveBtn(btnWeekly,  btnMonthly); });

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

    bars.forEach((bar, i) => {
        bar.style.cursor = 'pointer';
        bar.addEventListener('mouseenter', () => {
            const d = chartData[currentMode];
            if (!d.labels[i]) return;
            tooltip.textContent = d.labels[i] + ': ' + d.values[i] + ' applicants';
            tooltip.classList.remove('hidden');
        });
        bar.addEventListener('mousemove', e => {
            tooltip.style.left = (e.clientX + 12) + 'px';
            tooltip.style.top  = (e.clientY - 34) + 'px';
        });
        bar.addEventListener('mouseleave', () => tooltip.classList.add('hidden'));
        
        // Add click event for modal or drill-down
        bar.addEventListener('click', () => {
            const d = chartData[currentMode];
            
            if (currentMode === 'monthly') {
                // Drill-down to month_weeks view
                const monthTotal = d.values[i];
                chartData.month_weeks.values = [
                    Math.round(monthTotal * 0.25),
                    Math.round(monthTotal * 0.3),
                    Math.round(monthTotal * 0.25),
                    monthTotal - Math.round(monthTotal * 0.25)*2 - Math.round(monthTotal * 0.3),
                    0, 0
                ];
                updateChart('month_weeks');
                // We don't visually set btnWeekly active here because this is a special drill-down view,
                // but if we want to visually clear both buttons we could. Let's just remove active from monthly.
                btnMonthly.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
                btnMonthly.classList.add('text-gray-500');
                btnWeekly.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
                btnWeekly.classList.add('text-gray-500');
                
            } else if (currentMode === 'month_weeks') {
                if (!d.labels[i] || d.values[i] === 0) return;
                
                if (chartModalTitle) {
                    chartModalTitle.textContent = d.labels[i];
                    
                    const total = d.values[i];
                    const v1 = Math.round(total * 0.2);
                    const v2 = Math.round(total * 0.15);
                    const v3 = Math.round(total * 0.2);
                    const v4 = Math.round(total * 0.15);
                    const v5 = Math.round(total * 0.15);
                    const v6 = Math.round(total * 0.1);
                    const v7 = total - v1 - v2 - v3 - v4 - v5 - v6;
                    
                    const dailyHtml = `
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pelamar Masuk</span>
                            <span class="text-lg font-bold text-green-700">${total} Orang</span>
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
            } else if (currentMode === 'weekly') {
                if (!d.labels[i] || d.values[i] === 0) return;
                
                if (chartModalTitle) {
                    chartModalTitle.textContent = "Day " + d.labels[i];
                    
                    const total = d.values[i];
                    
                    const dailyHtml = `
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Incoming Applicants</span>
                            <span class="text-lg font-bold text-green-700">${total} People</span>
                        </div>
                        <div class="space-y-2.5 border-t border-gray-200 pt-4 mt-1">
                            <div class="flex justify-between items-center text-sm text-gray-600">
                                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-blue-500"></div><span>Document Screening Passed</span></div>
                                <span class="font-semibold text-gray-800">${Math.round(total * 0.45)}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm text-gray-600">
                                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-purple-500"></div><span>In Interview Process</span></div>
                                <span class="font-semibold text-gray-800">${Math.round(total * 0.30)}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm text-gray-600">
                                <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-red-500"></div><span>Rejected / Failed</span></div>
                                <span class="font-semibold text-gray-800">${Math.round(total * 0.25)}</span>
                            </div>
                        </div>
                    `;
                    document.getElementById('chart-modal-desc').textContent = "Here is the applicant status breakdown for that day.";
                    document.getElementById('chart-modal-content').innerHTML = dailyHtml;
                    chartModal.classList.remove('hidden');
                }
            }
        });
    });

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
        btn.closest('td').appendChild(lowonganDropdown);

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            this.closest('td').appendChild(lowonganDropdown);
            lowonganDropdown.style.top   = '100%';
            lowonganDropdown.style.right = '0';
            lowonganDropdown.style.left  = 'auto';
            lowonganDropdown.classList.toggle('hidden');
        });
    });

    document.addEventListener('click', () => lowonganDropdown.classList.add('hidden'));
    lowonganDropdown.addEventListener('click', e => e.stopPropagation());

    // ===== JADWAL WAWANCARA =====
    const wawancaraData = (window.dbChartData && window.dbChartData.wawancara) || {
        '2026-04-30': [
            { time: '09:00', ampm: 'AM', name: 'Budi Santoso', role: 'Technical Lead - R&D', location: 'Google Meet', isOnline: true, statusClass: 'border-green-700' },
            { time: '11:30', ampm: 'AM', name: 'Siska Wijaya', role: 'Finance Supervisor', location: 'Ruang Meeting A2', isOnline: false, statusClass: 'border-gray-300' },
            { time: '02:00', ampm: 'PM', name: 'Ahmad Fauzi', role: 'Maintenance Staff', location: 'Workshop Utama', isOnline: false, statusClass: 'border-gray-300' }
        ],
        '2026-05-01': [
            { time: '10:00', ampm: 'AM', name: 'Dewi Lestari', role: 'HR Staff', location: 'Zoom', isOnline: true, statusClass: 'border-yellow-500' },
            { time: '01:00', ampm: 'PM', name: 'Andi Saputra', role: 'IT Support', location: 'Google Meet', isOnline: true, statusClass: 'border-gray-300' }
        ],
        '2026-05-05': [
            { time: '08:30', ampm: 'AM', name: 'Diana Putri', role: 'Data Analyst', location: 'Google Meet', isOnline: true, statusClass: 'border-green-700' }
        ],
        '2026-05-12': [
            { time: '09:00', ampm: 'AM', name: 'Rina Melati', role: 'Marketing Manager', location: 'Ruang Meeting B1', isOnline: false, statusClass: 'border-blue-500' },
            { time: '14:00', ampm: 'PM', name: 'Joko Anwar', role: 'Sales Executive', location: 'Zoom', isOnline: true, statusClass: 'border-gray-300' }
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
            wawancaraCount.textContent = data.length + ' Sessions';
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
                    <div class="text-center shrink-0 w-12 pt-1">
                        <p class="text-sm font-bold text-gray-900 leading-none">${item.time}</p>
                        <p class="text-[10px] text-gray-400 font-medium">${item.ampm}</p>
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

    if (wawancaraDateSelect) {
        wawancaraDateSelect.addEventListener('change', (e) => {
            renderWawancara(e.target.value);
        });
        // Initial render
        renderWawancara(wawancaraDateSelect.value);
    }
});