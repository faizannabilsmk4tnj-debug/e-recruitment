/**
 * Pelamar Dashboard JS
 * Features: progress fill animation, animated counters, greeting, interactions
 */

document.addEventListener('DOMContentLoaded', function () {

    const PROFILE_PERCENT = window.PROFILE_PERCENT ?? 0;

    // ===== GREETING BY TIME =====
    const greetingText = document.getElementById('greeting-text');
    if (greetingText) {
        const hour = new Date().getHours();
        let greeting = 'Halo';
        if (hour < 12) greeting = 'Selamat Pagi';
        else if (hour < 15) greeting = 'Selamat Siang';
        else if (hour < 18) greeting = 'Selamat Sore';
        else greeting = 'Selamat Malam';
        greetingText.innerHTML = greeting + ', <span id="user-name">Ahmad</span>!';
    }

    // ===== PROGRESS FILL ANIMATION =====
    const fill = document.getElementById('progress-fill');
    const greetText = document.getElementById('greeting-text');
    const greetSub = document.getElementById('greeting-sub');
    const progressLabel = document.getElementById('progress-label');
    const progressNumber = document.getElementById('progress-number');
    const progressArrow = document.getElementById('progress-arrow');

    // Colors: left text changes early (it's on left), right text changes late (it's on right)
    function updateTextColors(percent) {
        // LEFT side (greeting) — covered early by fill
        if (percent >= 40) {
            greetText.classList.add('text-white');
            greetText.classList.remove('text-gray-900');
            greetSub.classList.add('text-green-200');
            greetSub.classList.remove('text-gray-500');
        } else {
            greetText.classList.remove('text-white');
            greetText.classList.add('text-green-800');  // ganti dari text-gray-900
            greetSub.classList.remove('text-green-200');
            greetSub.classList.add('text-gray-500');
        }

        // RIGHT side (percentage) — positioned at far right edge
        if (percent >= 95) {
            progressLabel.classList.add('text-green-200');
            progressLabel.classList.remove('text-green-800');
            progressNumber.classList.add('text-white');
            progressNumber.classList.remove('text-green-800');
            progressArrow.classList.add('border-white/50', 'text-white');
            progressArrow.classList.remove('border-green-300', 'text-green-700');
        } else {
            progressLabel.classList.remove('text-green-200');
            progressLabel.classList.add('text-green-800');
            progressNumber.classList.remove('text-white');
            progressNumber.classList.add('text-green-800');
            progressArrow.classList.remove('border-white/50', 'text-white');
            progressArrow.classList.add('border-green-300', 'text-green-700');
        }
    }

    // Set initial state
    updateTextColors(PROFILE_PERCENT);

    // Animate fill after short delay
    if (fill) {
        setTimeout(() => {
            fill.style.width = PROFILE_PERCENT + '%';
        }, 300);
    }

    // ===== ANIMATED COUNTERS =====
    function animateCounter(el, target, duration) {
        let start = 0;
        const step = Math.max(1, Math.ceil(target / (duration / 16)));
        const timer = setInterval(() => {
            start += step;
            if (start >= target) { start = target; clearInterval(timer); }
            el.textContent = start;
        }, 16);
    }

    const counters = {
    'stat-total': parseInt(document.getElementById('stat-total')?.textContent) || 0,
    'stat-aktif': parseInt(document.getElementById('stat-aktif')?.textContent) || 0,
    'stat-ditolak': parseInt(document.getElementById('stat-ditolak')?.textContent) || 0,
    'stat-wawancara': parseInt(document.getElementById('stat-wawancara')?.textContent) || 0,
};
    Object.entries(counters).forEach(([id, target]) => {
        const el = document.getElementById(id);
        if (el) { el.textContent = '0'; setTimeout(() => animateCounter(el, target, 800), 400); }
    });

    // ===== STAT CARDS CLICKABLE =====
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', () => window.location.href = '/pelamar/status-lamaran');
    });

    // ===== TABLE ROWS CLICKABLE =====
    document.querySelectorAll('#lamaran-table tr').forEach(row => {
        row.addEventListener('click', () => window.location.href = '/pelamar/status-lamaran');
    });

    // ===== NOTIFICATIONS: Mark as read =====
    document.querySelectorAll('#notifications > div').forEach(item => {
        item.addEventListener('click', function () {
            const dot = this.querySelector('.bg-blue-500');
            if (dot) {
                dot.classList.remove('bg-blue-500', 'ring-2', 'ring-blue-200');
                dot.classList.add('bg-gray-300');
            }
        });
    });

    console.log('Dashboard loaded');
});
