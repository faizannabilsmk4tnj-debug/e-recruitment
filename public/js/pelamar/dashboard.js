/**
 * Pelamar Dashboard JS
 * Features: progress fill animation, animated counters, greeting, interactions
 */

document.addEventListener('DOMContentLoaded', function () {

    const PROFILE_PERCENT = 85;

    // ===== GREETING BY TIME =====
    function getGreeting() {
        const hour = new Date().getHours();
        if (hour >= 5 && hour < 12)  return { salam: 'Selamat Pagi',   sub: 'Semoga harimu menyenangkan dan produktif! 🌤️' };
        if (hour >= 12 && hour < 15) return { salam: 'Selamat Siang',  sub: 'Jangan lupa istirahat sejenak di tengah aktivitasmu. ☀️' };
        if (hour >= 15 && hour < 18) return { salam: 'Selamat Sore',   sub: 'Semangat! Masih ada waktu untuk produktif hari ini. 🌇' };
        return                               { salam: 'Selamat Malam',  sub: 'Selamat beristirahat dan persiapkan hari esok. 🌙' };
    }

    const greetingText = document.getElementById('greeting-text');
    const greetingSub  = document.getElementById('greeting-sub');
    if (greetingText) {
        const userNameEl = document.getElementById('user-name');
        const userName   = userNameEl ? userNameEl.textContent.trim() : '';
        const { salam, sub } = getGreeting();

        greetingText.innerHTML = salam + ', <span id="user-name">' + userName + '</span>!';
        if (greetingSub) greetingSub.textContent = sub;
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
            greetText.classList.add('text-gray-900');
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

    const counters = { 'stat-total': 12, 'stat-aktif': 4, 'stat-ditolak': 2, 'stat-wawancara': 3 };
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