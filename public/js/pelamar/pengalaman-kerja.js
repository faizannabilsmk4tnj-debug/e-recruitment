/**
 * Pengalaman Kerja List JS
 * Functional: delete with animation, edit redirects to form page
 */
document.addEventListener('DOMContentLoaded', function () {
    const list = document.getElementById('experience-list');
    const emptyState = document.getElementById('empty-state');

    list.addEventListener('click', function (e) {
        // HAPUS
        const hapusBtn = e.target.closest('.btn-hapus');
        if (hapusBtn && confirm('Yakin ingin menghapus pengalaman ini?')) {
            const card = hapusBtn.closest('[data-id]');
            card.style.transition = 'opacity 0.3s, transform 0.3s';
            card.style.opacity = '0';
            card.style.transform = 'translateX(-20px)';
            setTimeout(() => {
                card.remove();
                if (list.children.length === 0) emptyState.classList.remove('hidden');
            }, 300);
        }

        // EDIT — redirect ke halaman form
        const editBtn = e.target.closest('.btn-edit');
        if (editBtn) {
            window.location.href = '/pelamar/pengalaman-kerja/tambah?edit=' + editBtn.dataset.id;
        }
    });
});