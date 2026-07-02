# Laporan Evolusi Skema Database (E-Recruitment)

Berikut adalah rangkuman evolusi struktur database dari skema awal hingga kondisi final setelah pembersihan tabel yang tidak terpakai dilakukan.

---

## 1. Skema Awal Database (18 Tabel)
Pada awal pengembangan, kita merancang 18 tabel inti untuk mengakomodasi kebutuhan dasar sistem:

1. **`users`**: Data kredensial dan hak akses (role) pengguna.
2. **`user_profiles`**: Informasi biodata personal pelamar.
3. **`password_reset_tokens`**: Token keamanan untuk fitur reset kata sandi.
4. **`login_attempts`**: Pencatatan riwayat percobaan masuk (gagal/sukses). *(Dihapus)*
5. **`cv_templates`**: Koleksi template desain CV yang disediakan HR.
6. **`applicant_cvs`**: Data CV builder milik pelamar yang terhubung dengan template.
7. **`work_experiences`**: Pengalaman kerja pelamar.
8. **`educations`**: Riwayat pendidikan formal pelamar.
9. **`applicant_skills`**: Daftar keahlian pelamar beserta tingkatannya.
10. **`job_categories`**: Pengelompokan bidang industri lowongan kerja.
11. **`job_postings`**: Detail lowongan pekerjaan yang dipasang oleh HR.
12. **`saved_jobs`**: Fitur bookmark lowongan favorit oleh pelamar.
13. **`applications`**: Berkas lamaran kerja pelamar yang dikirimkan ke lowongan tertentu.
14. **`application_status_logs`**: Log riwayat perubahan status lamaran (applied, shortlisted, dll).
15. **`job_search_logs`**: Pencatatan riwayat pencarian lowongan. *(Dihapus)*
16. **`interviews`**: Penjadwalan wawancara kerja pelamar.
17. **`interview_results`**: Hasil evaluasi dan keputusan kelolosan wawancara.
18. **`notifications`**: Pesan pemberitahuan/notifikasi sistem untuk user.

---

## 2. Tabel Baru yang Ditambahkan & Alasannya
Seiring berjalannya proyek, kita menambahkan beberapa tabel baru untuk mengakomodasi fitur yang lebih kompleks:

* **`sessions` & `cache` / `cache_locks`** (Tabel bawaan Laravel): 
  * *Alasan*: Untuk mendukung fitur manajemen perangkat login di halaman HR (bisa melihat perangkat aktif dan logout jarak jauh) serta mempercepat performa aplikasi lewat caching database.
* **`organization_experiences`**: 
  * *Alasan*: Agar pelamar bisa mengisi pengalaman organisasi secara terpisah dari pengalaman kerja profesional pada CV mereka.
* **`portofolio`**: 
  * *Alasan*: Untuk memfasilitasi pelamar mengunggah berkas portofolio (PDF/Gambar) atau melampirkan link eksternal (GitHub/Behance).
* **`user_notification_preferences`**: 
  * *Alasan*: Menyediakan pengaturan kendali notifikasi (toggles) bagi masing-masing user (terutama HR) agar dapat memilih notifikasi apa saja yang ingin diterima.
* **`work_locations`**: 
  * *Alasan*: Agar lokasi penempatan kerja bersifat dinamis (tidak hardcoded), sehingga HR bisa menambah kantor cabang baru dan pelamar bisa memfilter lowongan berdasarkan lokasi.

---

## 3. Tabel & Kolom yang Dihapus & Alasannya
* **`login_attempts`** & **`job_search_logs`** (Tabel):
  * *Alasan*: Fitur statistik pencarian dan log percobaan masuk tidak diimplementasikan di antarmuka (UI) maupun logika bisnis aplikasi saat ini.
* **`certificates`** (Tabel):
  * *Alasan*: Dokumen sertifikat diputuskan untuk disimpan langsung di dalam kolom tabel `applicant_skills` (seperti nama berkas, ukuran, dan path) agar lebih ringkas saat pelamar mengisi data keahlian.
* **Kolom `language` pada Tabel `users`** (Kolom):
  * *Alasan*: Sebelumnya kolom `language` ditambahkan untuk mendukung lokalisasi antarmuka dwibahasa (Indonesia/English). Namun karena lokalisasi tidak 100% lengkap pada keseluruhan tampilan aplikasi, fitur preferensi bahasa ini dihapus dan tampilan aplikasi diatur sepenuhnya menggunakan Bahasa Inggris sebagai default universal demi standarisasi dan kesederhanaan.

---

## 4. Tabel yang Mengalami Penyesuaian (Perubahan & Perbaikan Kolom)
Beberapa tabel mengalami penyesuaian kolom dari rancangan awal karena adanya kolom yang terlewat (*miss*) atau penyesuaian fungsionalitas seiring perkembangan alur kerja aplikasi:

* **`users` (Modifikasi Enum Role & Kolom Baru)**:
  * *Perubahan*: Kolom `role` dimodifikasi dari `ENUM('hr', 'applicant')` menjadi `ENUM('hr', 'hr_master', 'applicant')`.
    * *Alasan*: Untuk mendukung tingkatan role baru **HR Master** yang bertugas mengawasi dan mengelola tim HR lainnya.
  * *Kolom Baru*: `job_title` (jabatan HR) dan `has_privilege` (hak melamar pekerjaan).
    * *Alasan*: `job_title` untuk kelengkapan identitas tim HR, dan `has_privilege` digunakan untuk membatasi pelamar bermasalah agar tidak dapat melamar pekerjaan.
* **`applicant_skills` (Ganti Nama Kolom / Rename & Tambah Ukuran Berkas)**:
  * *Perubahan*: Kolom **`cert_url`** diubah namanya menjadi **`cert_file_path`**, serta ditambahkan kolom `cert_file_size`.
    * *Alasan*: Metode pengunggahan berkas sertifikat diubah dari yang semula menyimpan tautan/URL teks eksternal menjadi berkas fisik nyata (PDF/Gambar) yang tersimpan aman di direktori lokal server.
* **`cv_templates` (Tambah Kolom Waktu & Metadata Builder)**:
  * *Perubahan*: Ditambahkan kolom `updated_at`, `description`, `content_html`, `status` (draft/published), dan `is_default`.
    * *Alasan*: Kolom `updated_at` terlewat pada skema awal. Kolom lainnya ditambahkan untuk memfasilitasi fitur **HR CV Builder Editor** agar template CV bisa disimpan sebagai draf, di-publish, dan dijadikan template default pelamar.
* **`user_profiles` (Kelengkapan Profil Tambahan)**:
  * *Perubahan*: Menambahkan kolom `avatar_url`, `gender`, `birth_date`, `address`, `city`, `province`, `bio`, dan `linkedin_url`.
    * *Alasan*: Rancangan awal profil terlalu minim. Kolom ini ditambahkan agar pelamar dapat membuat profil yang representatif sebagai pengganti CV fisik, serta mendukung penghitungan persentase kelengkapan profil (minimal 75% sebelum melamar).
* **`educations` (Unggah Dokumen Ijazah)**:
  * *Perubahan*: Menambahkan kolom berkas `file_path`, `file_name`, `file_ext`, dan `file_size`.
    * *Alasan*: HR memerlukan bukti fisik kelulusan resmi (transkrip nilai/ijazah) untuk proses verifikasi berkas pelamar.
* **`job_postings` (Syarat Validasi Lowongan)**:
  * *Perubahan*: Menambahkan kolom `auto_close_method`, `quota`, `closed_at`, `age_min`, `age_max`, dan `passing_grade`.
    * *Alasan*: Mendukung penutupan lowongan otomatis ketika kuota pendaftar terpenuhi. Kolom usia (`age_min`/`age_max`) dan `passing_grade` (syarat nilai profil) digunakan untuk filter kelayakan otomatis pelamar menggunakan *database trigger* dan *stored function*.
* **`interviews` (Konfirmasi Kehadiran Wawancara)**:
  * *Perubahan*: Menambahkan kolom `attendance_status`, `attendance_confirmed_at`, dan `attendance_photo`.
    * *Alasan*: Memungkinkan pelamar melakukan konfirmasi kehadiran wawancara secara mandiri lewat dashboard mereka dan mengunggah bukti kehadiran jika diperlukan.

---

## 5. Tools Database yang Digunakan & Analisis Perbandingan Kritis

Berikut adalah teknologi dan alat (*tools*) database yang kita terapkan dalam sistem E-Recruitment ini beserta analisis perbandingan kritis terhadap beberapa alternatif sejenis:

### A. MySQL / MariaDB (RDBMS)
* **Penjelasan**: MySQL / MariaDB adalah sistem manajemen database relasional (RDBMS) berbasis SQL yang digunakan untuk menyimpan dan mengelola data secara terstruktur dalam bentuk tabel yang saling terhubung.
* **Alasan Penggunaan**: Sebagai database relasional utama untuk menyimpan data terstruktur (user, lowongan, lamaran, dsb.) dengan performa yang cepat, handal, dan kompatibilitas penuh dengan Laravel.
* **Analisis Perbandingan Kritis**:
  Di bawah ini adalah perbandingan kritis penggunaan MySQL dengan alternatif tools lain yang mirip seperti PostgreSQL dan MongoDB (NoSQL):
  * **vs PostgreSQL**: PostgreSQL seperti truk kontainer besar—sangat kuat untuk beban kerja berat (seperti data peta/koordinat dan grafik analisis raksasa). Tapi, ia butuh parkiran luas (RAM server besar). MySQL seperti mobil keluarga—lincah, sangat cepat untuk membaca data lowongan, dan hemat tempat (bisa berjalan stabil di server kecil dengan RAM 1GB).
  * **vs MongoDB**: MySQL memiliki "kunci pengaman otomatis" (Foreign Keys) yang menjaga hubungan antar-tabel. Contoh: Kita tidak bisa menghapus data Lowongan kerja jika masih ada Pelamar yang terdaftar di lowongan tersebut. MongoDB tidak memiliki pengaman otomatis ini, sehingga kita harus mengetik kode PHP manual untuk menjaganya. Jika kode PHP kita ada bug, data bisa rusak/terputus (misalnya data lamaran tersimpan tapi data lowongannya hilang).

### B. Laravel Migrations
* **Penjelasan**: Laravel Migrations adalah fitur bawaan Laravel yang berfungsi sebagai sistem pengontrol versi (*version control*) untuk database, mirip seperti Git tetapi khusus untuk mengelola struktur tabel.
* **Alasan Penggunaan**: Berperan sebagai version control bagi skema database. Memudahkan tim untuk memodifikasi struktur tabel, melakukan migrasi secara otomatis, dan memastikan seluruh anggota tim memiliki struktur database yang sama tanpa perlu melakukan import SQL manual.
* **Analisis Perbandingan Kritis**:
  Di bawah ini adalah perbandingan kritis penggunaan Laravel Migrations dengan alternatif lain seperti Script SQL Mentah (.sql) dan Liquibase:
  * **vs Script SQL Mentah**: Lebih simpel, tidak perlu mengirimkan berkas `.sql` secara manual. Pengembang lain hanya perlu melakukan clone proyek dari GitHub dan menjalankan perintah `php artisan migrate` di terminal untuk menyelaraskan struktur database, sehingga mengurangi kemungkinan kesalahan manusia (*human error*).
  * **vs Liquibase**: Liquibase memerlukan *environment* tambahan yaitu Java Runtime Environment (JRE) di server aplikasi, sementara jika menggunakan Laravel Migrations tidak perlu menambah *environment*, sudah sepaket dengan Laravel itu sendiri.

### C. Laravel Eloquent ORM
* **Penjelasan**: Laravel Eloquent ORM (*Object-Relational Mapping*) adalah fitur bawaan Laravel yang bertindak sebagai jembatan penerjemah untuk menghubungkan dan mengelola tabel database menggunakan objek dan kode PHP biasa tanpa perlu menulis kueri SQL secara manual.
* **Alasan Penggunaan**: Mempermudah interaksi dengan database menggunakan konsep *Active Record*. Memungkinkan kita untuk memetakan tabel menjadi model objek di PHP, mendefinisikan relasi antar-tabel (seperti `belongsTo` atau `hasMany`), serta mengamankan query dari serangan SQL Injection secara bawaan.
* **Analisis Perbandingan Kritis**:
  Di bawah ini adalah perbandingan kritis penggunaan Laravel Eloquent ORM dengan alternatif lain seperti Doctrine ORM dan Raw PDO:
  * **vs Doctrine ORM**: Doctrine memiliki aturan penulisan yang kaku dan rumit dipelajari. Anda bayangkan, untuk mendeklarasikan satu tabel saja kita perlu membuat file entity sendiri, mengisi nilainya satu per satu, lalu harus disimpan lewat entity manager, yang membuat baris kode dalam satu file menjadi sangat banyak. Sedangkan Eloquent memiliki kode yang lebih pendek, mudah dibaca, dan secara langsung mempercepat waktu pembuatan program.
  * **vs Raw PDO (Kueri SQL Manual)**: Menulis kueri SQL secara manual meningkatkan risiko kesalahan manusia (*human error*) saat mengetik kueri yang panjang, serta rentan terhadap celah keamanan jika kita lupa menyaring input dari pengguna. Sebaliknya, Eloquent secara otomatis menyaring dan mengamankan seluruh input tersebut sehingga aman secara bawaan.

### D. MySQL Database Triggers, Stored Procedures, & Stored Functions
* **Penjelasan**: Triggers, Stored Procedures, dan Stored Functions adalah blok kode program yang disimpan dan dijalankan secara langsung di dalam server database MySQL, bukan di dalam aplikasi Laravel (PHP).
* **Alasan Penggunaan**:
  * **Database Triggers**: Untuk otomatisasi aksi di tingkat server database demi menjamin konsistensi data (seperti mencatat log riwayat status pelamar secara otomatis saat status diubah).
  * **Stored Procedures & Functions**: Untuk mengeksekusi logika bisnis yang kompleks (seperti pengecekan kelayakan batas usia pelamar dan kuota lowongan) langsung di dalam database server.
* **Analisis Perbandingan Kritis**:
  Di bawah ini adalah perbandingan kritis penggunaan Triggers, Stored Procedures, dan Stored Functions dengan alternatif penulisan logika di sisi aplikasi PHP (Controller):
  * **vs Logika di PHP (Untuk Keamanan Log)**: Jika kita mencatat log riwayat status pelamar lewat kode PHP di website, log itu hanya akan terisi jika perubahan dilakukan lewat website. Jika database diubah langsung dari luar website (seperti lewat phpMyAdmin), log tidak akan tercatat. Dengan *Trigger* di database, lewat mana pun data diubah, catatan log **pasti selalu terisi otomatis**.
  * **vs Logika di PHP (Untuk Kecepatan)**: Untuk mengecek apakah pelamar boleh mendaftar, sistem perlu mengecek banyak hal (apakah umur cukup, apakah kuota masih ada, dll). Jika pengecekan dilakukan di PHP, server web harus bolak-balik mengirim pertanyaan ke database (butuh waktu perjalanan data). Dengan *Stored Function/Procedure*, semua pengecekan itu diselesaikan langsung di dalam database dalam sekejap tanpa ada jeda perjalanan data.

### E. DBA Privilege Management (Simulated via `has_privilege` Column & Flags)
* **Penjelasan**: DBA Privilege Management adalah metode pengelolaan hak akses pengguna terhadap data di database. Dalam proyek ini, hak akses tersebut disimulasikan menggunakan kolom status khusus di tabel users.
* **Alasan Penggunaan**: Untuk mensimulasikan kontrol hak akses pelamar langsung dari sisi server database oleh DBA (*Database Administrator*), yang berguna untuk mendemonstrasikan skenario keamanan data nyata di mana hak akses pengguna dapat dicabut (*revoked*) atau diberikan (*granted*) secara dinamis.
