/**
 * Pelamar Dashboard JS
 * Handles: Load categories, load job listings via AJAX (nanti)
 */

document.addEventListener('DOMContentLoaded', function () {

    // TODO: Fetch kategori dari API
    // fetch('/api/kategori')
    //     .then(res => res.json())
    //     .then(data => {
    //         renderCategories(data);
    //     });

    // TODO: Fetch lowongan terbaru dari API
    // fetch('/api/lowongan?limit=3&sort=latest')
    //     .then(res => res.json())
    //     .then(data => {
    //         renderJobs(data);
    //     });

    // TODO: Fetch stats dari API
    // fetch('/api/stats')
    //     .then(res => res.json())
    //     .then(data => {
    //         document.getElementById('stat-lowongan').textContent = data.lowongan + '+';
    //         document.getElementById('stat-pelamar').textContent = data.pelamar.toLocaleString() + '+';
    //         document.getElementById('stat-diterima').textContent = data.diterima + '+';
    //     });

    console.log('Pelamar Dashboard loaded');
});