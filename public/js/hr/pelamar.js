/**
 * HR Pelamar List JS — Enhanced
 */
document.addEventListener('DOMContentLoaded', function () {

    const state = {
        focus:  'all',
        search: '',
        dept:   '',
        sort:   'pelamar-desc',
    };

    const container         = document.getElementById('lowongan-container');
    const cards             = () => Array.from(document.querySelectorAll('.lowongan-card'));
    const emptyResult       = document.getElementById('empty-result');
    const activeFilterBar   = document.getElementById('active-filter-bar');
    const activeFilterPills = document.getElementById('active-filter-pills');
    const visibleLowEl      = document.getElementById('visible-lowongan-count');
    const visibleAppEl      = document.getElementById('visible-applicant-count');

    // Per-card status tab state
    const statusTabState = new WeakMap();

    // ===== MAIN APPLY =====
    function apply() {
        let visibleLowCount = 0;
        let visibleAppCount = 0;

        cards().forEach(card => {
            const title    = card.dataset.title;
            const dept     = card.dataset.department;
            const rows     = card.querySelectorAll('.applicant-row');
            const emptyRow = card.querySelector('.applicant-empty');
            const statusTab = statusTabState.get(card) || 'all';

            const deptMatch  = !state.dept   || dept === state.dept;
            const titleMatch = !state.search || title.includes(state.search);

            let matchedRows = 0;
            rows.forEach(row => {
                const name   = row.dataset.name;
                const email  = row.dataset.email;
                const status = row.dataset.status;

                const searchMatch = !state.search || titleMatch || name.includes(state.search) || email.includes(state.search);

                let focusMatch = true;
                if (state.focus === 'review')    focusMatch = (status === 'terkirim' || status === 'shortlisted');
                if (state.focus === 'interview') focusMatch = (status === 'interview');
                if (state.focus === 'decision')  focusMatch = (status === 'shortlisted');

                const statusTabMatch = (statusTab === 'all') || (status === statusTab);

                const show = searchMatch && focusMatch && statusTabMatch;
                row.style.display = show ? '' : 'none';

                if (show) matchedRows++;
                highlightSearch(row, state.search);
            });

            const countEl = card.querySelector('.filter-count');
            if (countEl) countEl.textContent = matchedRows;

            if (emptyRow) {
                if (matchedRows === 0 && card.classList.contains('is-expanded')) {
                    emptyRow.classList.remove('hidden');
                } else {
                    emptyRow.classList.add('hidden');
                }
            }

            const noActiveFilter = state.focus === 'all' && !state.search && !state.dept;
            const showCard = deptMatch && (
                matchedRows > 0 ||
                noActiveFilter ||
                (titleMatch && state.focus === 'all')
            );

            if (showCard) {
                card.style.display = '';
                visibleLowCount++;
                visibleAppCount += matchedRows;

                if (state.search && matchedRows > 0 && !titleMatch) {
                    expandCard(card);
                }
            } else {
                card.style.display = 'none';
            }
        });

        visibleLowEl.textContent = visibleLowCount;
        visibleAppEl.textContent = visibleAppCount;

        if (visibleLowCount === 0) emptyResult.classList.remove('hidden');
        else emptyResult.classList.add('hidden');

        updateActiveFilters();
        sortCards();
    }

    // ===== HIGHLIGHT SEARCH =====
    function highlightSearch(row, query) {
        const nameEl  = row.querySelector('.applicant-name');
        const emailEl = row.querySelector('.applicant-email');
        if (!nameEl || !emailEl) return;

        const originalName  = nameEl.textContent;
        const originalEmail = emailEl.textContent;

        if (!query) {
            nameEl.innerHTML  = originalName;
            emailEl.innerHTML = originalEmail;
            return;
        }

        const regex = new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'ig');
        nameEl.innerHTML  = originalName.replace(regex,  '<mark class="bg-yellow-200 text-gray-900 px-0.5 rounded">$1</mark>');
        emailEl.innerHTML = originalEmail.replace(regex, '<mark class="bg-yellow-200 text-gray-900 px-0.5 rounded">$1</mark>');
    }

    // ===== SORT CARDS =====
    function sortCards() {
        const list = cards().filter(c => c.style.display !== 'none');
        const mode = state.sort;

        list.sort((a, b) => {
            if (mode === 'pelamar-desc') return parseInt(b.dataset.total) - parseInt(a.dataset.total);
            if (mode === 'urgency') {
                const ua = parseInt(a.dataset.deadlineDays) - (parseInt(a.dataset.unreviewed) / 20);
                const ub = parseInt(b.dataset.deadlineDays) - (parseInt(b.dataset.unreviewed) / 20);
                return ua - ub;
            }
            if (mode === 'newest') return parseInt(a.dataset.daysSince) - parseInt(b.dataset.daysSince);
            if (mode === 'alpha')  return a.dataset.title.localeCompare(b.dataset.title);
            return 0;
        });

        list.forEach(c => container.appendChild(c));
        container.appendChild(emptyResult);
    }

    // ===== ACTIVE FILTER PILLS =====
    function updateActiveFilters() {
        const pills = [];

        if (state.focus !== 'all') {
            const labels = {
                review:    'Perlu Review',
                interview: 'Sedang Interview',
                decision:  'Butuh Keputusan',
            };
            pills.push({ label: labels[state.focus], type: 'focus' });
        }

        if (state.search) pills.push({ label: 'Cari: "' + state.search + '"', type: 'search' });
        if (state.dept)   pills.push({ label: 'Dept: ' + state.dept, type: 'dept' });

        if (pills.length === 0) {
            activeFilterBar.classList.add('hidden');
            activeFilterPills.innerHTML = '';
            return;
        }

        activeFilterBar.classList.remove('hidden');
        activeFilterPills.innerHTML = pills.map(p =>
            '<span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full">'
            + p.label
            + '<button class="hover:text-red-600 transition-colors" data-remove="' + p.type + '">'
            + '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>'
            + '</button></span>'
        ).join('');

        activeFilterPills.querySelectorAll('button[data-remove]').forEach(btn => {
            btn.addEventListener('click', () => {
                const type = btn.dataset.remove;
                if (type === 'focus')  { state.focus = 'all'; updateQuickFilterUI(); }
                if (type === 'search') { state.search = ''; document.getElementById('global-search').value = ''; }
                if (type === 'dept')   { state.dept = '';   document.getElementById('filter-dept').value = ''; }
                apply();
            });
        });
    }

    // ===== QUICK FILTER =====
    function updateQuickFilterUI() {
        document.querySelectorAll('.quick-filter').forEach(btn => {
            const isActive = btn.dataset.focus === state.focus;
            if (isActive) {
                btn.classList.add('active-quick', 'bg-green-800', 'text-white');
                btn.classList.remove('bg-gray-50', 'border', 'border-gray-200', 'text-gray-600');
            } else {
                btn.classList.remove('active-quick', 'bg-green-800', 'text-white');
                btn.classList.add('bg-gray-50', 'border', 'border-gray-200', 'text-gray-600');
            }
        });
    }

    document.querySelectorAll('.quick-filter').forEach(btn => {
        btn.addEventListener('click', function () {
            state.focus = this.dataset.focus;
            updateQuickFilterUI();
            if (state.focus !== 'all') {
                cards().forEach(c => expandCard(c));
            }
            apply();
        });
    });

    // ===== SEARCH / DEPT / SORT =====
    document.getElementById('global-search').addEventListener('input', function () {
        state.search = this.value.toLowerCase().trim();
        apply();
    });

    document.getElementById('filter-dept').addEventListener('change', function () {
        state.dept = this.value;
        apply();
    });

    document.getElementById('sort-lowongan').addEventListener('change', function () {
        state.sort = this.value;
        apply();
    });

    document.getElementById('btn-clear-filters').addEventListener('click', () => {
        state.focus  = 'all';
        state.search = '';
        state.dept   = '';
        document.getElementById('global-search').value = '';
        document.getElementById('filter-dept').value   = '';
        updateQuickFilterUI();
        apply();
    });

    // ===== COLLAPSIBLE =====
    function expandCard(card) {
        card.classList.add('is-expanded');
        card.querySelector('.lowongan-body').classList.remove('hidden');
        card.querySelector('.lowongan-chevron').style.transform = 'rotate(90deg)';
    }
    function collapseCard(card) {
        card.classList.remove('is-expanded');
        card.querySelector('.lowongan-body').classList.add('hidden');
        card.querySelector('.lowongan-chevron').style.transform = 'rotate(0deg)';
    }

    document.querySelectorAll('.lowongan-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const card = this.closest('.lowongan-card');
            if (card.classList.contains('is-expanded')) collapseCard(card);
            else expandCard(card);
        });

        const card = btn.closest('.lowongan-card');
        if (card.classList.contains('is-expanded')) {
            btn.querySelector('.lowongan-chevron').style.transform = 'rotate(90deg)';
        }
    });

    document.getElementById('btn-expand-all').addEventListener('click', () => {
        cards().forEach(c => expandCard(c));
    });
    document.getElementById('btn-collapse-all').addEventListener('click', () => {
        cards().forEach(c => collapseCard(c));
    });

    // ===== STATUS TABS (per card) =====
    document.querySelectorAll('.lowongan-card').forEach(card => {
        statusTabState.set(card, 'all');

        const tabs    = card.querySelectorAll('.status-tab');
        const emptyEl = card.querySelector('.applicant-empty');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => {
                    t.classList.remove('active-tab', 'text-green-800', 'border-green-700');
                    t.classList.add('text-gray-500', 'border-transparent');
                });
                this.classList.add('active-tab', 'text-green-800', 'border-green-700');
                this.classList.remove('text-gray-500', 'border-transparent');

                statusTabState.set(card, this.dataset.status);
                apply();
            });
        });

        // SORT applicant rows
        const sortSelect = card.querySelector('.sort-select');
        const tbody      = card.querySelector('.applicant-tbody');
        if (sortSelect) {
            sortSelect.addEventListener('change', function () {
                const rowsArray = Array.from(card.querySelectorAll('.applicant-row'));
                const mode = this.value;
                rowsArray.sort((a, b) => {
                    if (mode === 'score-desc') return parseInt(b.dataset.score) - parseInt(a.dataset.score);
                    if (mode === 'score-asc')  return parseInt(a.dataset.score) - parseInt(b.dataset.score);
                    if (mode === 'name')       return a.dataset.name.localeCompare(b.dataset.name);
                    return parseInt(a.dataset.dateIdx) - parseInt(b.dataset.dateIdx);
                });
                rowsArray.forEach(r => tbody.appendChild(r));
                if (emptyEl) tbody.appendChild(emptyEl);
            });
        }
    });

    // ===== EXPORT CSV =====
    const btnExport = document.getElementById('btn-export');
    btnExport.addEventListener('click', function () {
        const spinnerSvg = '<svg class="w-4 h-4 animate-spin inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>';
        const checkSvg   = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
        const downloadSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>';

        this.innerHTML = spinnerSvg + ' Mengekspor...';
        setTimeout(() => {
            this.innerHTML = checkSvg + ' Berhasil';
            this.classList.add('text-green-700', 'border-green-300', 'bg-green-50');
            setTimeout(() => {
                this.innerHTML = downloadSvg + ' Export CSV';
                this.classList.remove('text-green-700', 'border-green-300', 'bg-green-50');
            }, 1500);
        }, 1200);
    });

    // Initial
    apply();
});