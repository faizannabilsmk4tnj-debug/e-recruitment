/**
 * HR Pelamar List JS — Enhanced
 */
document.addEventListener('DOMContentLoaded', function () {

    const state = {
        focus: 'all',
        search: '',
        dept: '',
        sort: 'pelamar-desc',
        showArchived: false,
    };

    // Restore global state from sessionStorage
    const savedState = sessionStorage.getItem('pelamar_global_state');
    if (savedState) {
        try {
            const parsed = JSON.parse(savedState);
            Object.assign(state, parsed);
        } catch (e) {
            console.error('Failed to parse persisted state', e);
        }
    }

    // Sync restored state to DOM input elements
    const searchInput = document.getElementById('global-search');
    if (searchInput) searchInput.value = state.search;
    const deptSelect = document.getElementById('filter-category');
    if (deptSelect) deptSelect.value = state.dept;
    const sortSelect = document.getElementById('sort-lowongan');
    if (sortSelect) sortSelect.value = state.sort;
    if (typeof updateQuickFilterUI === 'function') {
        updateQuickFilterUI();
    }
    // Note: updateQuickFilterUI will be called once again after full init via initStatCardUI()

    const btnToggleArchived = document.getElementById('btn-toggle-archived');
    if (btnToggleArchived) {
        btnToggleArchived.dataset.active = state.showArchived ? 'true' : 'false';
        const dot = document.getElementById('archived-dot');
        if (state.showArchived) {
            btnToggleArchived.classList.remove('bg-white', 'border-gray-200', 'text-gray-600');
            btnToggleArchived.classList.add('bg-purple-50', 'border-purple-300', 'text-purple-800');
            if (dot) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-purple-600');
            }
        } else {
            btnToggleArchived.classList.add('bg-white', 'border-gray-200', 'text-gray-600');
            btnToggleArchived.classList.remove('bg-purple-50', 'border-purple-300', 'text-purple-800');
            if (dot) {
                dot.classList.add('bg-gray-300');
                dot.classList.remove('bg-purple-600');
            }
        }
    }

    const container = document.getElementById('lowongan-container');
    const cards = () => Array.from(document.querySelectorAll('.lowongan-card'));
    const emptyResult = document.getElementById('empty-result');
    const activeFilterBar = document.getElementById('active-filter-bar');
    const activeFilterPills = document.getElementById('active-filter-pills');
    const visibleLowEl = document.getElementById('visible-lowongan-count');
    const visibleAppEl = document.getElementById('visible-applicant-count');

    // Per-card status tab state
    const statusTabState = new WeakMap();
    const dismissedBadgeState = new WeakMap();

    const getDismissedBadgeStorageKey = card => `pelamar-dismissed-badges-${card.dataset.lowonganId || 'unknown'}`;

    // ===== MAIN APPLY =====
    function apply() {
        // Save global state to sessionStorage
        sessionStorage.setItem('pelamar_global_state', JSON.stringify(state));

        let visibleLowCount = 0;
        let visibleAppCount = 0;

        cards().forEach(card => {
            syncDismissedBadges(card);
            const title = card.dataset.title;
            const dept = card.dataset.department;
            const rows = card.querySelectorAll('.applicant-row');
            const emptyRow = card.querySelector('.applicant-empty');
            const statusTab = statusTabState.get(card) || 'all';

            const deptMatch = !state.dept || dept === state.dept;
            const titleMatch = !state.search || title.includes(state.search);

            let matchedRows = 0;
            rows.forEach(row => {
                const name = row.dataset.name;
                const email = row.dataset.email;
                const status = row.dataset.status;

                const searchMatch = !state.search || titleMatch || name.includes(state.search) || email.includes(state.search);

                let focusMatch = true;
                if (state.focus === 'review' || state.focus === 'submitted') focusMatch = (status === 'submitted');
                if (state.focus === 'interview') focusMatch = (status === 'interview');
                if (state.focus === 'decision' || state.focus === 'shortlisted') focusMatch = (status === 'shortlisted');
                if (state.focus === 'accepted') focusMatch = (status === 'accepted');
                if (state.focus === 'rejected') focusMatch = (status === 'rejected');

                // Per-card tab filter only applies when no global focus filter is active.
                // If a global focus is set (any status filter), the tab is bypassed.
                const nonAllFocus = ['review','submitted','interview','decision','shortlisted','accepted','rejected'];
                const statusTabMatch = nonAllFocus.includes(state.focus) || (statusTab === 'all') || (status === statusTab);

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

            const isArchived = card.dataset.archived === 'true';
            const noActiveFilter = state.focus === 'all' && !state.search && !state.dept;
            const showCard = (!isArchived || state.showArchived) && deptMatch && (
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
        const nameEl = row.querySelector('.applicant-name');
        const emailEl = row.querySelector('.applicant-email');
        if (!nameEl || !emailEl) return;

        const originalName = nameEl.textContent;
        const originalEmail = emailEl.textContent;

        if (!query) {
            nameEl.innerHTML = originalName;
            emailEl.innerHTML = originalEmail;
            return;
        }

        const regex = new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'ig');
        nameEl.innerHTML = originalName.replace(regex, '<mark class="bg-yellow-200 text-gray-900 px-0.5 rounded">$1</mark>');
        emailEl.innerHTML = originalEmail.replace(regex, '<mark class="bg-yellow-200 text-gray-900 px-0.5 rounded">$1</mark>');
    }

    // ===== SORT CARDS =====
    function sortCards() {
        const list = cards();
        const mode = state.sort;

        function getUrgencyScore(card) {
            const status = card.dataset.status;
            const isArchived = card.dataset.archived === 'true';
            
            // Lowongan yang diarsipkan, diisi (filled), atau ditutup (closed) memiliki urgensi terendah
            if (isArchived || status === 'filled' || status === 'closed') {
                return 999999;
            }

            const unreviewed = parseInt(card.dataset.unreviewed) || 0;
            const quota = parseInt(card.dataset.quota) || 0;
            const accepted = parseInt(card.dataset.accepted) || 0;

            // Jika kuota sudah penuh, tidak mendesak
            if (quota > 0 && accepted >= quota) {
                return 999999;
            }

            // Hitung sisa hari aktual jika ada deadline
            let baseDeadlineDays = parseFloat(card.dataset.deadlineDays);
            const hasActualDeadline = !isNaN(baseDeadlineDays) && baseDeadlineDays !== 30;

            // Hitung sisa hari virtual berdasarkan kuota (Opsi A: makin sedikit sisa kuota, makin mendesak)
            let virtualDeadlineDays = Infinity;
            if (quota > 0) {
                const remainingSlots = quota - accepted;
                virtualDeadlineDays = 30 * (remainingSlots / quota);
            }

            let finalDeadlineDays;
            if (hasActualDeadline) {
                // Ambil sisa hari terkecil (paling mendesak) antara deadline aktual vs kuota
                finalDeadlineDays = Math.min(baseDeadlineDays, virtualDeadlineDays);
            } else if (quota > 0) {
                finalDeadlineDays = virtualDeadlineDays;
            } else {
                finalDeadlineDays = 30;
            }

            // Jika batas waktu sudah lewat, posisinya di bawah lowongan aktif biasa
            if (finalDeadlineDays < 0) {
                return 888888;
            }

            return finalDeadlineDays - (unreviewed / 20);
        }

        list.sort((a, b) => {
            const archivedA = a.dataset.archived === 'true';
            const archivedB = b.dataset.archived === 'true';
            if (archivedA !== archivedB) {
                return archivedA ? 1 : -1;
            }

            if (mode === 'pelamar-desc') return parseInt(b.dataset.total) - parseInt(a.dataset.total);
            if (mode === 'urgency') {
                return getUrgencyScore(a) - getUrgencyScore(b);
            }
            if (mode === 'newest') return parseInt(a.dataset.daysSince) - parseInt(b.dataset.daysSince);
            if (mode === 'alpha') return a.dataset.title.localeCompare(b.dataset.title);
            return 0;
        });

        // Check if the current order in the DOM matches the sorted list
        const currentChildren = Array.from(container.children).filter(el => el.classList.contains('lowongan-card'));
        let orderChanged = currentChildren.length !== list.length;
        if (!orderChanged) {
            for (let i = 0; i < list.length; i++) {
                if (currentChildren[i] !== list[i]) {
                    orderChanged = true;
                    break;
                }
            }
        }

        if (orderChanged) {
            const scrollPos = window.scrollY;
            list.forEach(c => container.appendChild(c));
            container.appendChild(emptyResult);
            window.scrollTo(0, scrollPos);
        }
    }

    // ===== ACTIVE FILTER PILLS =====
    function updateActiveFilters() {
        const pills = [];

        if (state.focus !== 'all') {
            const labels = {
                review: 'Needs Review',
                interview: 'Interviewing',
                decision: 'Needs Decision',
            };
            pills.push({ label: labels[state.focus], type: 'focus' });
        }

        if (state.search) pills.push({ label: 'Search: "' + state.search + '"', type: 'search' });
        if (state.dept) pills.push({ label: 'Category: ' + state.dept, type: 'dept' });
        if (state.showArchived) pills.push({ label: 'Showing Archived', type: 'archived' });

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
                if (type === 'focus') { state.focus = 'all'; updateQuickFilterUI(); }
                if (type === 'search') { state.search = ''; document.getElementById('global-search').value = ''; }
                if (type === 'dept') { state.dept = ''; document.getElementById('filter-category').value = ''; }
                if (type === 'archived') {
                    state.showArchived = false;
                    const toggleBtn = document.getElementById('btn-toggle-archived');
                    if (toggleBtn) {
                        toggleBtn.dataset.active = 'false';
                        toggleBtn.classList.add('bg-white', 'border-gray-200', 'text-gray-600');
                        toggleBtn.classList.remove('bg-purple-50', 'border-purple-300', 'text-purple-800');
                        const dot = document.getElementById('archived-dot');
                        if (dot) {
                            dot.classList.add('bg-gray-300');
                            dot.classList.remove('bg-purple-600');
                        }
                    }
                }
                apply();
            });
        });
    }

    // ===== QUICK FILTER + STAT CARD FILTER =====
    // Map stat card focus values to their matching quick-filter pill focus values
    const statCardToPillMap = {
        'all': 'all',
        'submitted': 'review',
        'shortlisted': 'decision',
        'interview': 'interview',
        'accepted': 'accepted',
        'rejected': 'rejected',
    };

    function updateQuickFilterUI() {
        // Sync quick-filter pills
        document.querySelectorAll('.quick-filter').forEach(btn => {
            // A pill is active if its focus matches state.focus OR the mapped alias matches
            const isActive = btn.dataset.focus === state.focus
                || (state.focus === 'submitted' && btn.dataset.focus === 'review')
                || (state.focus === 'shortlisted' && btn.dataset.focus === 'decision');
            if (isActive) {
                btn.classList.add('active-quick', 'bg-green-800', 'text-white');
                btn.classList.remove('bg-gray-50', 'border', 'border-gray-200', 'text-gray-600');
            } else {
                btn.classList.remove('active-quick', 'bg-green-800', 'text-white');
                btn.classList.add('bg-gray-50', 'border', 'border-gray-200', 'text-gray-600');
            }
        });

        // Sync stat cards
        document.querySelectorAll('.stat-card-filter').forEach(card => {
            const cardFocus = card.dataset.focus;
            // Card is active if it directly matches or if its alias maps to the current focus
            const isActive = cardFocus === state.focus
                || (cardFocus === 'all' && state.focus === 'all')
                || (cardFocus === 'submitted' && (state.focus === 'submitted' || state.focus === 'review'))
                || (cardFocus === 'shortlisted' && (state.focus === 'shortlisted' || state.focus === 'decision'))
                || (cardFocus === 'interview' && state.focus === 'interview')
                || (cardFocus === 'accepted' && state.focus === 'accepted')
                || (cardFocus === 'rejected' && state.focus === 'rejected');

            if (isActive) {
                card.classList.add('ring-2', 'ring-offset-1', 'scale-[1.02]', 'shadow-lg');
                card.classList.remove('shadow-sm');
            } else {
                card.classList.remove('ring-2', 'ring-offset-1', 'scale-[1.02]', 'shadow-lg');
                card.classList.add('shadow-sm');
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

    // Stat card click → trigger the same focus filter
    document.querySelectorAll('.stat-card-filter').forEach(card => {
        card.addEventListener('click', function () {
            state.focus = this.dataset.focus;
            updateQuickFilterUI();
            if (state.focus !== 'all') {
                cards().forEach(c => expandCard(c));
            }
            apply();
            // Smooth scroll down to the list
            const container = document.getElementById('lowongan-container');
            if (container) container.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    // ===== SEARCH / DEPT / SORT =====
    document.getElementById('global-search').addEventListener('input', function () {
        state.search = this.value.toLowerCase().trim();
        apply();
    });

    document.getElementById('filter-category').addEventListener('change', function () {
        state.dept = this.value;
        apply();
    });

    document.getElementById('sort-lowongan').addEventListener('change', function () {
        state.sort = this.value;
        apply();
    });

    const toggleBtn = document.getElementById('btn-toggle-archived');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            state.showArchived = !state.showArchived;
            this.dataset.active = state.showArchived ? 'true' : 'false';
            const dot = document.getElementById('archived-dot');
            if (state.showArchived) {
                this.classList.remove('bg-white', 'border-gray-200', 'text-gray-600');
                this.classList.add('bg-purple-50', 'border-purple-300', 'text-purple-800');
                if (dot) {
                    dot.classList.remove('bg-gray-300');
                    dot.classList.add('bg-purple-600');
                }
            } else {
                this.classList.add('bg-white', 'border-gray-200', 'text-gray-600');
                this.classList.remove('bg-purple-50', 'border-purple-300', 'text-purple-800');
                if (dot) {
                    dot.classList.add('bg-gray-300');
                    dot.classList.remove('bg-purple-600');
                }
            }
            apply();
        });
    }

    document.getElementById('btn-clear-filters').addEventListener('click', () => {
        state.focus = 'all';
        state.search = '';
        state.dept = '';
        state.showArchived = false;
        document.getElementById('global-search').value = '';
        document.getElementById('filter-dept').value = '';
        
        const toggleBtn = document.getElementById('btn-toggle-archived');
        if (toggleBtn) {
            toggleBtn.dataset.active = 'false';
            toggleBtn.classList.add('bg-white', 'border-gray-200', 'text-gray-600');
            toggleBtn.classList.remove('bg-purple-50', 'border-purple-300', 'text-purple-800');
            const dot = document.getElementById('archived-dot');
            if (dot) {
                dot.classList.add('bg-gray-300');
                dot.classList.remove('bg-purple-600');
            }
        }
        
        updateQuickFilterUI();
        apply();
    });

    // ===== COLLAPSIBLE & SEEN STATE =====
    function markVacancyAsSeen(card) {
        const vacancyId = card.dataset.lowonganId;
        const unreadDots = card.querySelectorAll('.bg-blue-500'); // Blue dot elements
        if (unreadDots.length === 0) return;

        fetch(`/hr/pelamar/lowongan/${vacancyId}/mark-seen`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                unreadDots.forEach(dot => {
                    dot.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                    setTimeout(() => dot.remove(), 300);
                });
                card.querySelectorAll('.applicant-row').forEach(row => {
                    row.dataset.isSeen = 'true';
                });
            }
        })
        .catch(err => console.error('Failed to mark vacancy as seen:', err));
    }

    function removeNewBadge(card) {
        const badge = card.querySelector('.new-vacancy-badge');
        if (badge) {
            badge.remove();
        }
    }

    function removeNewApplicantsBadge(card) {
        const badge = card.querySelector('.new-applicants-badge');
        if (badge) {
            badge.remove();
        }
    }

    function dismissNewBadges(card) {
        dismissedBadgeState.set(card, true);
        card.classList.add('new-badges-dismissed');
        try {
            sessionStorage.setItem(getDismissedBadgeStorageKey(card), '1');
        } catch (e) {
            // Ignore storage failures and keep the DOM state as the source of truth.
        }
        removeNewBadge(card);
        removeNewApplicantsBadge(card);
    }

    function syncDismissedBadges(card) {
        let persisted = false;
        try {
            persisted = sessionStorage.getItem(getDismissedBadgeStorageKey(card)) === '1';
        } catch (e) {
            persisted = false;
        }

        if (dismissedBadgeState.get(card) || persisted) {
            dismissedBadgeState.set(card, true);
            card.classList.add('new-badges-dismissed');
            removeNewBadge(card);
            removeNewApplicantsBadge(card);
        }
    }

    function expandCard(card) {
        card.classList.add('is-expanded');
        card.querySelector('.lowongan-body').classList.remove('hidden');
        card.querySelector('.lowongan-chevron').style.transform = 'rotate(90deg)';
        markVacancyAsSeen(card);
        const vacancyId = card.dataset.lowonganId;
        if (vacancyId) {
            sessionStorage.setItem('expanded_vacancy_' + vacancyId, 'true');
        }
    }
    function collapseCard(card) {
        card.classList.remove('is-expanded');
        card.querySelector('.lowongan-body').classList.add('hidden');
        card.querySelector('.lowongan-chevron').style.transform = 'rotate(0deg)';
        dismissNewBadges(card);
        const vacancyId = card.dataset.lowonganId;
        if (vacancyId) {
            sessionStorage.removeItem('expanded_vacancy_' + vacancyId);
        }
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

    const statusWeights = {
        'submitted': 1,
        'shortlisted': 2,
        'interview': 3,
        'rejected': 4,
        'accepted': 5,
        'withdrawn': 6
    };

    function sortAndGroup(card) {
        const tbody = card.querySelector('.applicant-tbody');
        if (!tbody) return;
        const rowsArray = Array.from(card.querySelectorAll('.applicant-row'));
        const sortSelect = card.querySelector('.sort-select');
        const mode = sortSelect ? sortSelect.value : 'recent';
        const emptyEl = card.querySelector('.applicant-empty');

        rowsArray.sort((a, b) => {
            if (mode === 'score-desc') return parseInt(b.dataset.score) - parseInt(a.dataset.score);
            if (mode === 'score-asc') return parseInt(a.dataset.score) - parseInt(b.dataset.score);
            if (mode === 'name') return a.dataset.name.localeCompare(b.dataset.name);
            return parseInt(a.dataset.dateIdx) - parseInt(b.dataset.dateIdx);
        });

        rowsArray.forEach(r => tbody.appendChild(r));
        if (emptyEl) tbody.appendChild(emptyEl);
    }

    // ===== STATUS TABS (per card) & STATE RESTORATION =====
    document.querySelectorAll('.lowongan-card').forEach((card, index) => {
        const vacancyId = card.dataset.lowonganId;

        // Restore expansion state
        if (vacancyId) {
            const isExpandedPersisted = sessionStorage.getItem('expanded_vacancy_' + vacancyId);
            if (isExpandedPersisted === 'true') {
                expandCard(card);
            } else if (isExpandedPersisted === null) {
                // If no persisted state, keep the default (first card expanded)
                if (index === 0) {
                    expandCard(card);
                } else {
                    collapseCard(card);
                }
            } else {
                collapseCard(card);
            }
        }

        // Restore tab selection state
        let activeTabStatus = 'all';
        if (vacancyId) {
            const persistedTab = sessionStorage.getItem('active_tab_vacancy_' + vacancyId);
            if (persistedTab) {
                activeTabStatus = persistedTab;
            }
        }
        statusTabState.set(card, activeTabStatus);

        // Sync the UI active tab classes based on activeTabStatus
        const tabs = card.querySelectorAll('.status-tab');
        tabs.forEach(tab => {
            if (tab.dataset.status === activeTabStatus) {
                tab.classList.add('active-tab', 'text-green-800', 'border-b-2', 'border-green-700');
                tab.classList.remove('text-gray-500', 'border-transparent');
            } else {
                tab.classList.remove('active-tab', 'text-green-800', 'border-b-2', 'border-green-700');
                tab.classList.add('text-gray-500', 'border-transparent');
            }
        });

        syncDismissedBadges(card);

        // Set up tab click listeners
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => {
                    t.classList.remove('active-tab', 'text-green-800', 'border-b-2', 'border-green-700');
                    t.classList.add('text-gray-500', 'border-transparent');
                });
                this.classList.add('active-tab', 'text-green-800', 'border-b-2', 'border-green-700');
                this.classList.remove('text-gray-500', 'border-transparent');

                const status = this.dataset.status;
                statusTabState.set(card, status);

                if (vacancyId) {
                    sessionStorage.setItem('active_tab_vacancy_' + vacancyId, status);
                }

                dismissNewBadges(card);
                apply();
            });
        });

        // SORT applicant rows
        const sortSelect = card.querySelector('.sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', function () {
                sortAndGroup(card);
            });
            // Initial group & sort
            sortAndGroup(card);
        }
    });

    // ===== EXPORT EXCEL (Styled XLSX workbook) =====
    const btnExport = document.getElementById('btn-export');
    const exportModal = document.getElementById('export-modal');
    const btnCloseExportModal = document.getElementById('btn-close-export-modal');
    const btnCancelExport = document.getElementById('btn-cancel-export');
    const btnConfirmExport = document.getElementById('btn-confirm-export');
    const exportSingleSelect = document.getElementById('export-single-select');
    const exportWarningModal = document.getElementById('export-warning-modal');
    const btnCloseExportWarningModal = document.getElementById('btn-close-export-warning-modal');
    const btnOkExportWarningModal = document.getElementById('btn-ok-export-warning-modal');
    const radioScopeAll = document.querySelector('input[name="export-scope"][value="all"]');
    const radioScopeSingle = document.querySelector('input[name="export-scope"][value="single"]');
    const ExcelJS = window.ExcelJS;
    const usedSheetNames = new Set();

    const createSafeSheetName = (title, fallback = 'Vacancy') => {
        const base = String(title || fallback)
            .replace(/[\[\]\:\*\?\/\\]/g, ' ')
            .replace(/\s+/g, ' ')
            .trim()
            .slice(0, 31) || fallback;

        let sheetName = base;
        let suffix = 2;

        while (usedSheetNames.has(sheetName.toLowerCase())) {
            const suffixText = ` (${suffix})`;
            sheetName = `${base.slice(0, 31 - suffixText.length)}${suffixText}`;
            suffix += 1;
        }

        usedSheetNames.add(sheetName.toLowerCase());
        return sheetName;
    };

    const closeExportWarningModal = () => exportWarningModal?.classList.add('hidden');
    const openExportWarningModal = () => {
        exportModal.classList.add('hidden');
        exportWarningModal?.classList.remove('hidden');
    };

    const getAllVacancies = () => cards().reduce((acc, card, idx) => {
        const applicants = [];
        card.querySelectorAll('.applicant-row').forEach(row => {
            applicants.push({
                name: row.dataset.name || row.querySelector('.applicant-name')?.textContent?.trim() || '',
                email: row.dataset.email || row.querySelector('.applicant-email')?.textContent?.trim() || '',
                phone: row.dataset.phone || '-',
                gpa: row.dataset.gpa || '-',
                date: row.cells && row.cells[1] ? row.cells[1].textContent.trim() : '',
                status: row.dataset.status || '',
                score: row.dataset.score || ''
            });
        });

        acc.push({
            idx,
            title: card.querySelector('.lowongan-title')?.textContent?.trim() || card.dataset.title || '',
            department: card.dataset.department || '',
            deadline: card.dataset.deadlineDays ? `${card.dataset.deadlineDays} days` : 'N/A',
            applicants
        });
        return acc;
    }, []);

    if (btnExport && exportModal) {
        btnExport.addEventListener('click', function (e) {
            e.preventDefault();

            if (exportSingleSelect) {
                exportSingleSelect.innerHTML = '';
                const allCards = cards();
                allCards.forEach((card, idx) => {
                    const jobTitle = card.querySelector('.lowongan-title')?.textContent?.trim() || card.dataset.title || '';
                    const totalApplicants = parseInt(card.dataset.total) || 0;
                    const opt = document.createElement('option');
                    opt.value = idx;
                    opt.textContent = totalApplicants > 0 ? jobTitle : `${jobTitle} (No applicants)`;
                    exportSingleSelect.appendChild(opt);
                });

                if (allCards.length === 0) {
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'No active vacancies';
                    exportSingleSelect.appendChild(opt);
                }
            }

            if (radioScopeAll) radioScopeAll.checked = true;
            if (exportSingleSelect) exportSingleSelect.disabled = true;
            closeExportWarningModal();
            exportModal.classList.remove('hidden');
        });

        const closeModal = () => exportModal.classList.add('hidden');
        btnCloseExportModal?.addEventListener('click', closeModal);
        btnCancelExport?.addEventListener('click', closeModal);
        btnCloseExportWarningModal?.addEventListener('click', closeExportWarningModal);
        btnOkExportWarningModal?.addEventListener('click', closeExportWarningModal);

        exportModal.addEventListener('click', e => {
            if (e.target === exportModal) closeModal();
        });

        exportWarningModal?.addEventListener('click', e => {
            if (e.target === exportWarningModal) closeExportWarningModal();
        });

        document.querySelectorAll('input[name="export-scope"]').forEach(radio => {
            radio.addEventListener('change', function () {
                if (exportSingleSelect) {
                    exportSingleSelect.disabled = (this.value === 'all');
                }
            });
        });

        btnConfirmExport?.addEventListener('click', async function () {
            const isAll = radioScopeAll ? radioScopeAll.checked : true;
            const selectedIdx = exportSingleSelect ? exportSingleSelect.value : '';

            if (!isAll) {
                const selectedCard = cards()[parseInt(selectedIdx, 10)];
                const selectedTotal = selectedCard ? parseInt(selectedCard.dataset.total) || 0 : 0;
                if (!selectedCard || selectedTotal <= 0) {
                    openExportWarningModal();
                    return;
                }
            }

            if (!ExcelJS) {
                alert('Excel export library is not loaded.');
                return;
            }

            const spinnerSvg = '<svg class="w-4 h-4 animate-spin inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>';
            const checkSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
            const downloadSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>';

            btnConfirmExport.innerHTML = spinnerSvg + ' Exporting...';
            btnConfirmExport.disabled = true;

            try {
                const allVacancies = getAllVacancies();
                const selectedVacancies = isAll
                    ? cards().filter(c => c.style.display !== 'none').map(c => allVacancies.find(v => String(v.idx) === String(cards().indexOf(c)))).filter(Boolean)
                    : allVacancies.filter(v => String(v.idx) === String(selectedIdx));

                if (!selectedVacancies.length) {
                    throw new Error('No data found to export');
                }

                const workbook = new ExcelJS.Workbook();
                usedSheetNames.clear();
                workbook.creator = 'PT Ecogreen Oleochemicals';
                workbook.created = new Date();
                workbook.modified = new Date();
                workbook.properties.date1904 = false;
                workbook.views = [{ activeTab: 0, firstSheet: 0, visibility: 'visible' }];

                const green = 'FF15803D';
                const greenDark = 'FF14532D';
                const blue = 'FF2563EB';
                const amber = 'FFF59E0B';
                const red = 'FFDC2626';
                const slate = 'FF475569';
                const borderColor = 'FFE2E8F0';

                const paintBand = (sheet, rowNumber, fromCol, toCol, fillArgb, fontProps = {}) => {
                    for (let col = fromCol; col <= toCol; col += 1) {
                        const cell = sheet.getCell(rowNumber, col);
                        cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: fillArgb } };
                        cell.font = {
                            name: 'Calibri',
                            size: fontProps.size || 11,
                            bold: !!fontProps.bold,
                            italic: !!fontProps.italic,
                            color: { argb: fontProps.color || 'FFFFFFFF' }
                        };
                        cell.alignment = fontProps.alignment || { vertical: 'middle' };
                    }
                };

                const styleTitle = (sheet, rowNumber, fromCol, toCol) => {
                    paintBand(sheet, rowNumber, fromCol, toCol, greenDark, { size: 16, bold: true, color: 'FFFFFFFF' });
                };
                const styleSubTitle = (sheet, rowNumber, fromCol, toCol) => {
                    paintBand(sheet, rowNumber, fromCol, toCol, 'FFEFF6F0', { size: 10, italic: true, color: slate });
                };
                const styleHeader = cell => {
                    cell.font = { name: 'Calibri', size: 11, bold: true, color: { argb: 'FFFFFFFF' } };
                    cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: green } };
                    cell.alignment = { horizontal: 'center', vertical: 'middle' };
                    cell.border = {
                        top: { style: 'thin', color: { argb: greenDark } },
                        left: { style: 'thin', color: { argb: greenDark } },
                        bottom: { style: 'thin', color: { argb: greenDark } },
                        right: { style: 'thin', color: { argb: greenDark } }
                    };
                };
                const styleData = (cell, fillArgb = null, align = 'left') => {
                    cell.font = { name: 'Calibri', size: 11 };
                    cell.alignment = { horizontal: align, vertical: 'middle' };
                    cell.border = {
                        top: { style: 'thin', color: { argb: borderColor } },
                        left: { style: 'thin', color: { argb: borderColor } },
                        bottom: { style: 'thin', color: { argb: borderColor } },
                        right: { style: 'thin', color: { argb: borderColor } }
                    };
                    if (fillArgb) {
                        cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: fillArgb } };
                    }
                };
                const colorForScore = score => {
                    const val = Number(score) || 0;
                    if (val >= 80) return { fill: 'FFDCFCE7', font: 'FF15803D' };
                    if (val >= 60) return { fill: 'FFFEF3C7', font: 'FFB45309' };
                    return { fill: 'FFFEE2E2', font: 'FFB91C1C' };
                };

                if (isAll) {
                    const overview = workbook.addWorksheet('Overview Summary', {
                        views: [{ state: 'frozen', ySplit: 3 }],
                        properties: { defaultRowHeight: 20 }
                    });
                    overview.columns = [
                        { width: 34 },
                        { width: 22 },
                        { width: 18 },
                        { width: 16 },
                        { width: 14 }
                    ];

                    overview.mergeCells('A1:E1');
                    overview.getCell('A1').value = 'Recruitment Summary Overview';
                    styleTitle(overview, 1, 1, 5);

                    overview.mergeCells('A2:E2');
                    overview.getCell('A2').value = `Exported on: ${new Date().toLocaleString()} | Active Vacancies: ${selectedVacancies.length}`;
                    styleSubTitle(overview, 2, 1, 5);

                    const header = overview.addRow(['Vacancy Position', 'Department', 'Total Applicants', 'Deadline', 'Status']);
                    header.eachCell(cell => styleHeader(cell));

                    selectedVacancies.forEach((v, index) => {
                        const row = overview.addRow([v.title, v.department, v.applicants.length, v.deadline, 'Active']);
                        row.eachCell((cell, colNumber) => {
                            const align = colNumber === 3 || colNumber === 5 ? 'center' : 'left';
                            styleData(cell, index % 2 === 0 ? 'FFF8FAFC' : null, align);
                        });
                        row.getCell(5).font = { name: 'Calibri', size: 11, bold: true, color: { argb: greenDark } };
                    });
                }

                selectedVacancies.forEach(v => {
                    const ws = workbook.addWorksheet(createSafeSheetName(v.title));
                    ws.views = [{ state: 'frozen', ySplit: 4 }];
                    ws.columns = [
                        { width: 24 },
                        { width: 30 },
                        { width: 18 },
                        { width: 12 },
                        { width: 18 },
                        { width: 14 },
                        { width: 14 }
                    ];

                    ws.mergeCells('A1:G1');
                    ws.getCell('A1').value = v.title;
                    styleTitle(ws, 1, 1, 7);

                    ws.mergeCells('A2:G2');
                    ws.getCell('A2').value = `Department: ${v.department} | Total Applicants: ${v.applicants.length}`;
                    styleSubTitle(ws, 2, 1, 7);

                    ws.addRow([]);

                    const header = ws.addRow(['Applicant Name', 'Email', 'Phone', 'GPA', 'Applied Date', 'Status', 'Match Score']);
                    header.eachCell(cell => styleHeader(cell));

                    if (!v.applicants.length) {
                        ws.mergeCells(`A5:G5`);
                        const emptyCell = ws.getCell('A5');
                        emptyCell.value = 'No applicants found for this vacancy.';
                        styleData(emptyCell, 'FFF3F4F6', 'center');
                    } else {
                        v.applicants.forEach((p, rowIndex) => {
                            const row = ws.addRow([
                                p.name,
                                p.email,
                                p.phone,
                                p.gpa,
                                p.date,
                                String(p.status).toUpperCase(),
                                Number(p.score) || 0
                            ]);

                            const scoreStyles = colorForScore(p.score);
                            row.eachCell((cell, colNumber) => {
                                const align = colNumber === 7 || colNumber === 4 ? 'center' : (colNumber === 3 ? 'center' : 'left');
                                const fill = colNumber === 7 ? scoreStyles.fill : (rowIndex % 2 === 0 ? 'FFF8FAFC' : null);
                                styleData(cell, fill, align);
                                if (colNumber === 7) {
                                    cell.font = { name: 'Calibri', size: 11, bold: true, color: { argb: scoreStyles.font } };
                                }
                                if (colNumber === 6) {
                                    const statusMap = {
                                        submitted: { fill: 'FFF3F4F6', font: 'FF4B5563' },
                                        shortlisted: { fill: 'FFFEF3C7', font: 'FF92400E' },
                                        interview: { fill: 'FFDBEAFE', font: 'FF1D4ED8' },
                                        accepted: { fill: 'FFDCFCE7', font: 'FF15803D' },
                                        rejected: { fill: 'FFFEE2E2', font: 'FFB91C1C' },
                                        withdrawn: { fill: 'FFE5E7EB', font: 'FF6B7280' }
                                    };
                                    const s = statusMap[String(p.status).toLowerCase()] || statusMap.submitted;
                                    cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: s.fill } };
                                    cell.font = { name: 'Calibri', size: 11, bold: true, color: { argb: s.font } };
                                }
                            });

                            row.height = 20;
                        });
                    }
                });

                const buffer = await workbook.xlsx.writeBuffer();
                const blob = new Blob([buffer], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                const url = URL.createObjectURL(blob);
                const filename = isAll
                    ? `applicant_report_all_${new Date().toISOString().slice(0, 10)}.xlsx`
                    : `applicant_report_${selectedVacancies[0].title.toLowerCase().replace(/[^a-z0-9]/g, '_')}_${new Date().toISOString().slice(0, 10)}.xlsx`;

                const link = document.createElement('a');
                link.href = url;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                link.remove();
                setTimeout(() => URL.revokeObjectURL(url), 1000);

                btnConfirmExport.innerHTML = checkSvg + ' Success';
                btnConfirmExport.classList.add('text-green-700', 'border-green-300', 'bg-green-50');
                setTimeout(() => {
                    btnConfirmExport.innerHTML = downloadSvg + ' Export Excel';
                    btnConfirmExport.classList.remove('text-green-700', 'border-green-300', 'bg-green-50');
                }, 1500);

                closeModal();
            } catch (e) {
                console.error(e);
                alert('Failed to export data: ' + e.message);
            } finally {
                btnConfirmExport.innerHTML = 'Export Excel';
                btnConfirmExport.disabled = false;
            }
        });
    }

    // ===== ARCHIVE MODAL =====
    const archiveModal = document.getElementById('archive-confirm-modal');
    const btnCloseArchiveModal = document.getElementById('btn-close-archive-modal');
    const btnCancelArchive = document.getElementById('btn-cancel-archive');
    const btnConfirmArchive = document.getElementById('btn-confirm-archive');
    const archiveJobTitle = document.getElementById('archive-job-title');
    const warningActive = document.getElementById('archive-warning-active');
    const warningUndecided = document.getElementById('archive-warning-undecided');
    const undecidedCountText = document.getElementById('archive-undecided-count');
    const archiveInfoText = document.getElementById('archive-info-text');

    let currentArchiveVacancyId = null;

    if (archiveModal) {
        const closeArchiveModal = () => {
            archiveModal.classList.add('hidden');
            currentArchiveVacancyId = null;
        };

        if (btnCloseArchiveModal) btnCloseArchiveModal.addEventListener('click', closeArchiveModal);
        if (btnCancelArchive) btnCancelArchive.addEventListener('click', closeArchiveModal);
        archiveModal.addEventListener('click', (e) => {
            if (e.target === archiveModal) closeArchiveModal();
        });

        document.querySelectorAll('.btn-archive-vacancy').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation(); // prevent card toggle
                
                const vacancyId = this.dataset.vacancyId;
                const title = this.dataset.title;
                const status = this.dataset.status;
                const undecided = parseInt(this.dataset.undecided) || 0;

                currentArchiveVacancyId = vacancyId;
                if (archiveJobTitle) archiveJobTitle.textContent = title;

                // Reset states
                warningActive.classList.add('hidden');
                warningUndecided.classList.add('hidden');
                archiveInfoText.classList.remove('hidden');
                btnConfirmArchive.disabled = false;
                btnConfirmArchive.classList.remove('opacity-50', 'cursor-not-allowed');

                // Validation
                if (status === 'open') {
                    warningActive.classList.remove('hidden');
                    archiveInfoText.classList.add('hidden');
                    btnConfirmArchive.disabled = true;
                    btnConfirmArchive.classList.add('opacity-50', 'cursor-not-allowed');
                } else if (undecided > 0) {
                    if (undecidedCountText) undecidedCountText.textContent = undecided;
                    warningUndecided.classList.remove('hidden');
                    archiveInfoText.classList.add('hidden');
                    btnConfirmArchive.disabled = true;
                    btnConfirmArchive.classList.add('opacity-50', 'cursor-not-allowed');
                }

                archiveModal.classList.remove('hidden');
            });
        });

        if (btnConfirmArchive) {
            btnConfirmArchive.addEventListener('click', function () {
                if (!currentArchiveVacancyId) return;

                btnConfirmArchive.disabled = true;
                btnConfirmArchive.textContent = 'Archiving...';

                fetch(`/hr/pelamar/lowongan/${currentArchiveVacancyId}/archive`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const card = document.querySelector(`.lowongan-card[data-lowongan-id="${currentArchiveVacancyId}"]`);
                        if (card) {
                            card.dataset.archived = 'true';
                            card.classList.remove('bg-white', 'border-gray-100');
                            card.classList.add('bg-purple-50/20', 'border-purple-200', 'opacity-85', 'hover:opacity-100', 'transition-all');
                            
                            const titleContainer = card.querySelector('.lowongan-title')?.parentElement;
                            if (titleContainer) {
                                titleContainer.querySelectorAll('.rounded-full').forEach(b => b.remove());
                                const archivedBadge = document.createElement('span');
                                archivedBadge.className = 'text-[10px] font-bold text-purple-700 bg-purple-50 border border-purple-200 px-2 py-0.5 rounded-full shrink-0';
                                archivedBadge.textContent = 'ARCHIVED';
                                titleContainer.appendChild(archivedBadge);
                            }
                            
                            const actionContainer = card.querySelector('.btn-archive-vacancy')?.parentElement;
                            if (actionContainer) {
                                actionContainer.innerHTML = `
                                    <span class="p-2 text-purple-500 bg-purple-50 rounded-lg flex items-center justify-center cursor-default" title="Vacancy is Archived">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                                            <path d="m9 14 2 2 4-4"/>
                                        </svg>
                                    </span>
                                `;
                            }

                            if (state.showArchived) {
                                apply();
                            } else {
                                card.classList.add('opacity-0', 'transition-all', 'duration-500');
                                card.style.height = '0px';
                                card.style.margin = '0px';
                                card.style.padding = '0px';
                                setTimeout(() => {
                                    card.style.display = 'none';
                                    card.classList.remove('opacity-0');
                                    card.style.height = '';
                                    card.style.margin = '';
                                    card.style.padding = '';
                                    apply();
                                }, 500);
                            }
                        }
                        closeArchiveModal();
                    } else {
                        alert(data.message || 'Failed to archive vacancy.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('An error occurred while archiving.');
                })
                .finally(() => {
                    btnConfirmArchive.disabled = false;
                    btnConfirmArchive.textContent = 'Archive Vacancy';
                });
            });
        }
    }

    // Parse URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const lowonganId = urlParams.get('lowongan');
    const searchQuery = urlParams.get('search');

    if (searchQuery) {
        state.search = searchQuery.toLowerCase().trim();
        const searchInput = document.getElementById('global-search');
        if (searchInput) searchInput.value = searchQuery;
    }

    if (lowonganId) {
        setTimeout(() => {
            const targetCard = document.querySelector(`.lowongan-card[data-lowongan-id="${lowonganId}"]`);
            if (targetCard) {
                // Pastikan semua kartu ditutup (minimize) terlebih dahulu
                cards().forEach(c => {
                    collapseCard(c);
                });

                // 1. Tarik layar (scroll) langsung ke kartu yang masih ter-minimize
                const yOffset = -140;
                const y = targetCard.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });

                // 2. Tunggu proses scroll selesai (sekitar 800ms)
                setTimeout(() => {
                    // 3. Beri kedipan penanda (highlight-pulse) sekali saja (0.8s)
                    targetCard.classList.add('highlight-pulse');

                    // 4. Setelah kedipan selesai (800ms), buka datanya (expandCard)
                    setTimeout(() => {
                        expandCard(targetCard);
                        targetCard.classList.remove('highlight-pulse');
                    }, 800);
                }, 800);
            }
        }, 100);
    }

    // ===== COUNTDOWN STOPWATCH =====
    function initCountdownTimers() {
        const timerBadges = document.querySelectorAll('.countdown-timer-badge');
        if (timerBadges.length === 0) return;

        function updateTimers() {
            const now = Date.now();
            timerBadges.forEach(badge => {
                const deadlineStr = badge.dataset.deadline;
                if (!deadlineStr) return;

                const deadlineTime = new Date(deadlineStr).getTime();
                if (isNaN(deadlineTime)) return;

                const diff = deadlineTime - now;
                const textEl = badge.querySelector('.countdown-text');
                if (!textEl) return;

                if (diff <= 0) {
                    textEl.textContent = 'Deadline Passed';
                    badge.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
                    badge.classList.remove('bg-red-500', 'text-white', 'border-red-600', 'animate-pulse');
                    const svg = badge.querySelector('svg');
                    if (svg) svg.classList.add('text-red-605');
                    return;
                }

                // If remaining time is under 24 hours (86400000 ms)
                if (diff <= 86400000) {
                    const hours = Math.floor(diff / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    const pad = num => String(num).padStart(2, '0');
                    textEl.textContent = `Deadline ${pad(hours)}:${pad(minutes)}:${pad(seconds)} left`;

                    // Apply active red stopwatch styling
                    badge.classList.remove('bg-red-50', 'text-red-700', 'border-red-200');
                    badge.classList.add('bg-red-500', 'text-white', 'border-red-600', 'animate-pulse');
                    const svg = badge.querySelector('svg');
                    if (svg) svg.classList.remove('text-red-605');
                } else {
                    // Fallback to PHP rendered text
                    textEl.textContent = badge.dataset.fallback || textEl.textContent;
                    badge.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
                    badge.classList.remove('bg-red-500', 'text-white', 'border-red-600', 'animate-pulse');
                    const svg = badge.querySelector('svg');
                    if (svg) svg.classList.add('text-red-605');
                }
            });
        }

        updateTimers();
        setInterval(updateTimers, 1000);
    }

    // Initial
    initCountdownTimers();
    apply();
    updateQuickFilterUI(); // sync stat cards & pills with restored state
});

