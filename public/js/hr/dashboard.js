/**
 * HR Dashboard JS
 */
document.addEventListener('DOMContentLoaded', function () {

    const MAX_HEIGHT = 140; // px — bar tertinggi

    const chartData = {
        monthly: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'],
            values: [55, 72, 65, 88, 78, 100],
            activeIndex: 5
        },
        weekly: {
            labels: ['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB'],
            values: [40, 60, 85, 55, 70, 45],
            activeIndex: 2
        }
    };

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

    bars.forEach((bar, i) => {
        bar.style.cursor = 'pointer';
        bar.addEventListener('mouseenter', () => {
            const d = chartData[currentMode];
            tooltip.textContent = d.labels[i] + ': ' + d.values[i] + ' pelamar';
            tooltip.classList.remove('hidden');
        });
        bar.addEventListener('mousemove', e => {
            tooltip.style.left = (e.clientX + 12) + 'px';
            tooltip.style.top  = (e.clientY - 34) + 'px';
        });
        bar.addEventListener('mouseleave', () => tooltip.classList.add('hidden'));
    });

    // ===== STATUS LOWONGAN: dots menu =====
    const lowonganDropdown = document.createElement('div');
    lowonganDropdown.id = 'lowongan-dd';
    lowonganDropdown.className = 'fixed bg-white border border-gray-200 rounded-xl shadow-lg z-50 w-40 py-1.5 hidden';
    lowonganDropdown.innerHTML = `
        <button class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Lihat Detail
        </button>
        <button class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
            Edit Lowongan
        </button>`;
    document.body.appendChild(lowonganDropdown);

    document.querySelectorAll('tbody button').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const rect = this.getBoundingClientRect();
            lowonganDropdown.style.top   = (rect.bottom + window.scrollY + 4) + 'px';
            lowonganDropdown.style.right = (window.innerWidth - rect.right) + 'px';
            lowonganDropdown.classList.toggle('hidden');
        });
    });

    document.addEventListener('click', () => lowonganDropdown.classList.add('hidden'));
    lowonganDropdown.addEventListener('click', e => e.stopPropagation());
});