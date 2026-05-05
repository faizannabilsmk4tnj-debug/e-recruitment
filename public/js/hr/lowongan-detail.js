/**
 * HR Lowongan Detail JS
 * Chart mulai dari hari loker dibuka, Weekly bisa di-klik untuk drill-down ke Daily.
 */
document.addEventListener('DOMContentLoaded', function () {

    // ===== POSTED DATE (hari pertama loker dibuka) =====
    // Demo: Oct 12, 2023 = Kamis
    const POSTED_DATE = new Date('2023-10-12');
    const DAYS_ID    = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
    const MONTHS_ID  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    // ===== DUMMY DATA =====
    // Data per minggu (4 minggu sejak dibuka), masing-masing 7 hari.
    // Index 0 = hari pertama (hari loker dibuka)
    const weeklyDailyData = [
        [3, 8, 14, 10, 18, 15, 12],   // Week 1
        [20, 28, 22, 35, 30, 18, 15],  // Week 2
        [25, 32, 40, 38, 30, 22, 18],  // Week 3
        [15, 20, 25, 18, 12, 8, 5]     // Week 4
    ];

    // ===== DOM =====
    const svg        = document.getElementById('trend-chart');
    const pathLine   = document.getElementById('chart-line');
    const pathArea   = document.getElementById('chart-area');
    const pointsG    = document.getElementById('chart-points');
    const btnDaily   = document.getElementById('btn-daily');
    const btnWeekly  = document.getElementById('btn-weekly');
    const subtitleEl = document.getElementById('chart-subtitle');
    const xLabels    = document.getElementById('x-labels');
    const chartTitle = document.querySelector('h2.font-bold.text-gray-900.text-lg');

    // Geometry
    const W = 600, H = 280;
    const padX = 30, padTop = 20, padBot = 40;
    const chartW = W - padX * 2;
    const chartH = H - padTop - padBot;

    // ===== HELPERS =====
    function formatDate(d) {
        return d.getDate() + ' ' + MONTHS_ID[d.getMonth()];
    }

    function getDailyLabels(startDate, count = 7) {
        const labels = [];
        for (let i = 0; i < count; i++) {
            const d = new Date(startDate);
            d.setDate(d.getDate() + i);
            labels.push({
                short: DAYS_ID[d.getDay()],
                full:  DAYS_ID[d.getDay()] + ', ' + formatDate(d)
            });
        }
        return labels;
    }

    function dataToPoints(values) {
        const rawMax = Math.max(...values);
        let max;
        if (rawMax <= 30)       max = Math.ceil(rawMax / 5)  * 5;
        else if (rawMax <= 100) max = Math.ceil(rawMax / 10) * 10;
        else                    max = Math.ceil(rawMax / 25) * 25;

        const pts = values.map((v, i) => ({
            x: padX + (i * (chartW / (values.length - 1))),
            y: padTop + chartH - (v / max) * chartH,
            value: v
        }));
        return { pts, max };
    }

    function buildSmoothPath(pts) {
        if (pts.length < 2) return '';
        let d = `M ${pts[0].x} ${pts[0].y}`;
        for (let i = 0; i < pts.length - 1; i++) {
            const p0 = pts[i - 1] || pts[i];
            const p1 = pts[i];
            const p2 = pts[i + 1];
            const p3 = pts[i + 2] || p2;

            const cp1x = p1.x + (p2.x - p0.x) / 6;
            const cp1y = p1.y + (p2.y - p0.y) / 6;
            const cp2x = p2.x - (p3.x - p1.x) / 6;
            const cp2y = p2.y - (p3.y - p1.y) / 6;

            d += ` C ${cp1x} ${cp1y}, ${cp2x} ${cp2y}, ${p2.x} ${p2.y}`;
        }
        return d;
    }

    // Tooltip
    const tooltip = document.createElement('div');
    tooltip.className = 'fixed z-50 bg-green-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-lg pointer-events-none hidden';
    document.body.appendChild(tooltip);

    // ===== RENDER =====
    function render(points, labels, max, opts = {}) {
        // Line + area
        const linePath  = buildSmoothPath(points);
        const baselineY = padTop + chartH;
        const areaPath  = linePath + ` L ${points[points.length-1].x} ${baselineY} L ${points[0].x} ${baselineY} Z`;
        pathLine.setAttribute('d', linePath);
        pathArea.setAttribute('d', areaPath);

        // Y-axis
        document.getElementById('y-max').textContent     = max;
        document.getElementById('y-mid-top').textContent = Math.round(max * 0.75);
        document.getElementById('y-mid').textContent     = Math.round(max * 0.5);
        document.getElementById('y-mid-bot').textContent = Math.round(max * 0.25);

        // Points
        pointsG.innerHTML = '';
        points.forEach((p, i) => {
            const halo = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            halo.setAttribute('cx', p.x);
            halo.setAttribute('cy', p.y);
            halo.setAttribute('r', '10');
            halo.setAttribute('fill', '#166534');
            halo.setAttribute('fill-opacity', '0.12');
            pointsG.appendChild(halo);

            const dot = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            dot.setAttribute('cx', p.x);
            dot.setAttribute('cy', p.y);
            dot.setAttribute('r', '5');
            dot.setAttribute('fill', '#166534');
            dot.setAttribute('stroke', '#ffffff');
            dot.setAttribute('stroke-width', '2.5');
            dot.style.cursor = opts.clickable ? 'pointer' : 'default';
            dot.style.transition = 'r 0.2s';

            const labelFull = labels[i].full || labels[i];
            const value     = p.value;

            dot.addEventListener('mouseenter', function () {
                dot.setAttribute('r', '7');
                const extra = opts.clickable ? '<div class="text-[10px] text-green-400 mt-1">Klik untuk detail harian →</div>' : '';
                tooltip.innerHTML = `<div class="text-[10px] text-green-300 uppercase tracking-wider mb-0.5">${labelFull}</div><div class="text-sm font-bold">${value} pelamar</div>${extra}`;
                tooltip.classList.remove('hidden');
            });
            dot.addEventListener('mousemove', e => {
                tooltip.style.left = (e.clientX + 12) + 'px';
                tooltip.style.top  = (e.clientY - 50) + 'px';
            });
            dot.addEventListener('mouseleave', () => {
                dot.setAttribute('r', '5');
                tooltip.classList.add('hidden');
            });

            // Weekly drill-down: klik titik → daily view minggu itu
            if (opts.clickable) {
                dot.addEventListener('click', () => {
                    tooltip.classList.add('hidden');
                    showDaily(i); // i = index minggu (0 = Week 1)
                });
                halo.style.cursor = 'pointer';
                halo.addEventListener('click', () => {
                    tooltip.classList.add('hidden');
                    showDaily(i);
                });
            }

            pointsG.appendChild(dot);
        });

        // X-axis
        xLabels.innerHTML = labels.map(l => {
            const text = typeof l === 'string' ? l : l.short;
            return `<span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">${text}</span>`;
        }).join('');
    }

    // ===== DAILY VIEW =====
    // weekIndex: 0 = minggu ke-1 (sejak dibuka), default minggu pertama
    function showDaily(weekIndex = 0) {
        const values = weeklyDailyData[weekIndex];
        const { pts, max } = dataToPoints(values);

        // Start date untuk minggu ini
        const startDate = new Date(POSTED_DATE);
        startDate.setDate(startDate.getDate() + (weekIndex * 7));
        const labels = getDailyLabels(startDate, 7);

        chartTitle.textContent = weekIndex === 0
            ? 'Pelamar Harian'
            : 'Pelamar Harian — Minggu ' + (weekIndex + 1);

        const endDate = new Date(startDate);
        endDate.setDate(endDate.getDate() + 6);
        subtitleEl.innerHTML = weekIndex === 0
            ? 'Sejak loker dibuka (' + formatDate(POSTED_DATE) + ' – ' + formatDate(endDate) + ')'
            : formatDate(startDate) + ' – ' + formatDate(endDate) + ' · <button id="btn-back-weekly" class="text-green-700 hover:text-green-900 font-semibold transition-colors">← Kembali ke Weekly</button>';

        render(pts, labels, max);

        // Active button state
        activeBtn(btnDaily, btnWeekly);

        // Bind back button (if exists)
        const btnBack = document.getElementById('btn-back-weekly');
        if (btnBack) btnBack.addEventListener('click', showWeekly);
    }

    // ===== WEEKLY VIEW =====
    function showWeekly() {
        // Sum per minggu
        const totals = weeklyDailyData.map(week => week.reduce((a, b) => a + b, 0));
        const { pts, max } = dataToPoints(totals);

        // Labels: Minggu 1..N + tanggal rentang
        const labels = totals.map((_, i) => {
            const start = new Date(POSTED_DATE);
            start.setDate(start.getDate() + (i * 7));
            const end = new Date(start);
            end.setDate(end.getDate() + 6);
            return {
                short: 'W' + (i + 1),
                full:  'Minggu ' + (i + 1) + ' (' + formatDate(start) + ' – ' + formatDate(end) + ')'
            };
        });

        chartTitle.textContent = 'Pelamar Mingguan';
        subtitleEl.textContent = 'Total pelamar per minggu · Klik titik untuk melihat detail harian';

        render(pts, labels, max, { clickable: true });

        activeBtn(btnWeekly, btnDaily);
    }

    function activeBtn(on, off) {
        on.classList.add('bg-white', 'text-gray-800', 'shadow-sm');
        on.classList.remove('text-gray-500');
        off.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
        off.classList.add('text-gray-500');
    }

    // ===== EVENT HANDLERS =====
    btnDaily?.addEventListener('click',  () => showDaily(0));
    btnWeekly?.addEventListener('click', () => showWeekly());

    // Initial render: daily minggu pertama
    showDaily(0);
});