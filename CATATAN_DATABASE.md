# Catatan Penyesuaian Database E-Recruitment (TODO)
*Disimpan pada: 4 Mei 2026*

Catatan ini berisi rekomendasi penyesuaian untuk skema database 20 tabel awal. Penyesuaian ini dibuat berdasarkan fitur-fitur UI/UX (Frontend) yang telah dikembangkan secara intensif, sehingga nantinya saat implementasi ke Laravel Migrations, database sudah tersinkronisasi sempurna dengan frontend.

---

## 1. Tabel `interviews` (Penjadwalan Wawancara)
**Konteks:** Fitur HR Dashboard kini memiliki kalender interaktif dan *list view* berdasarkan tanggal.
**Penyesuaian yang Dibutuhkan:**
- Pastikan ada kolom khusus kalender: `interview_date` (DATE), `start_time` (TIME), `end_time` (TIME).
- Tambahkan kolom `location_or_link` (VARCHAR) untuk link Zoom/Meet atau ruangan fisik.
- Pastikan ada foreign key `application_id` agar terhubung langsung dengan lamaran (bukan sekadar `user_id`).
- Kolom enum `status` yang spesifik: `scheduled`, `completed`, `cancelled`.

## 2. Tabel `cv_templates` (Validasi Builder CV)
**Konteks:** Canvas pembuatan CV memiliki batas ketat maksimal 1 halaman A4 (842px).
**Penyesuaian yang Dibutuhkan:**
- Tambahkan kolom `config` (JSON) atau `max_pages` (INT).
- Tujuan: Aturan validasi (seperti tinggi maksimal atau format margin) tidak di-*hardcode* di frontend, melainkan dikontrol dari database.

## 3. Penambahan Tabel Baru: `app_settings` (Opsional tapi Disarankan)
**Konteks:** Teks "PT Eco Green Oleochemicals" sering direvisi, dibersihkan dari *navbar* pelamar, dan disesuaikan.
**Penyesuaian yang Dibutuhkan:**
- Buat 1 tabel konfigurasi dinamis (misal: `app_settings`).
- Berisi kolom `key` dan `value` untuk menyimpan: nama perusahaan, logo utama, teks landing page, atau konfigurasi global lainnya agar HR/Admin bisa mengubahnya tanpa memodifikasi *codebase*.

## 4. Evaluasi Tabel `job_search_logs`
**Konteks:** Menyimpan riwayat pencarian pelamar bisa membuat ukuran database membengkak dengan cepat.
**Penyesuaian yang Dibutuhkan:**
- Jika tidak ada kebutuhan krusial untuk fitur analitik kata kunci yang dicari pelamar, sangat disarankan untuk **menghapus** (drop) tabel ini dari rancangan awal untuk efisiensi resource.

## 5. Sinkronisasi Enum Status pada Tabel `applications`
**Konteks:** Alur lamaran pelamar sudah sangat *seamless*, mengubah status ke "Interview" akan langsung memicu modal wawancara.
**Penyesuaian yang Dibutuhkan:**
- Pastikan enum status lamaran dikunci pada: `['applied', 'reviewed', 'shortlisted', 'interview', 'offered', 'rejected', 'withdrawn']`.

---
*Catatan: Dokumen ini hanya sebagai pengingat. Tidak ada aksi yang perlu dijalankan hingga fase implementasi backend (Backend & Database Integration Phase) dimulai.*
