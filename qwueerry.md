# Laporan Analisis & Dokumentasi Skema Database (Constraint Keys)
*Dokumen ini menyajikan audit, perbandingan, dan pemetaan seluruh Primary Key (PK), Foreign Key (FK), dan Unique Key di database proyek e-Recruitment.*

---

## 1. Ringkasan Eksekutif & Statistik Constraint

Berikut adalah ringkasan jumlah constraint yang aktif di database proyek saat ini:

| Jenis Constraint | Total Aktif | Keterangan |
| :--- | :---: | :--- |
| **Primary Key (PK)** | **24** | 21 Tabel Relasional + 3 Tabel Sistem/Cache/Session |
| **Foreign Key (FK)** | **24** | Menghubungkan tabel relasional untuk menjaga integritas data |
| **Unique Key (Unique)** | **9** | Mencegah duplikasi data (email, slug, composite key, dll.) |
| **Database Triggers** | **5** | Mengontrol batasan bisnis tingkat lanjut (usia, kuota lamaran, passing grade) |

### Analisis Logika: Mengapa Jumlah Total Foreign Key (FK) adalah 24?
Meskipun ada 8 tabel mandiri yang tidak memiliki relasi (0 FK), total FK di database tetap berjumlah 24 karena adanya akumulasi dari beberapa tabel relasional yang memiliki lebih dari satu FK (multi-relasi):

| Jumlah FK per Tabel | Daftar Tabel | Perhitungan Subtotal | Subtotal FK |
| :---: | :--- | :---: | :---: |
| **3 FK** | `applications` | 1 tabel × 3 FK | 3 |
| **2 FK** | `applicant_cvs`, `job_postings`, `saved_jobs`, `application_status_logs`, `interviews`, `interview_results` | 6 tabel × 2 FK | 12 |
| **1 FK** | `user_profiles`, `password_reset_tokens`, `work_experiences`, `educations`, `applicant_skills`, `notifications`, `organization_experiences`, `portofolio`, `user_notification_preferences` | 9 tabel × 1 FK | 9 |
| **0 FK** (Mandiri) | `users`, `cv_templates`, `job_categories`, `work_locations`, `sessions`, `cache`, `cache_locks`, `migrations` | 8 tabel × 0 FK | 0 |
| **TOTAL** | | | **24 FK** |

---

## 2. Analisis Perbandingan: Skema Asli vs Aktual Proyek

| Kategori Constraint | Status di Proyek | Keterangan / Penyesuaian |
| :--- | :---: | :--- |
| **Tabel yang Dihapus** | **TIDAK ADA** | Tabel `login_attempts`, `job_search_logs`, dan `certificates` telah dihapus lewat migrasi pembersihan (`2026_07_01_000002_drop_unused_tables.php`). |
| **Perubahan PK Reset Token** | **MISMATCHED (BERBEDA)** | Tabel `password_reset_tokens` menggunakan PK `id` (Auto-increment BigInt) dan FK `user_id`, bukan menggunakan PK `email` seperti perencanaan awal. |
| **Constraint Baru Ditemukan** | **TAMBAHAN BARU** | Menambahkan `fk_saved_jobs_job`, `fk_password_reset_tokens_user`, `fk_user_notification_preferences_user`, dan `password_reset_tokens_token_unique`. |

---

## 3. Kamus Lengkap & Query SQL Aktual

### A. Primary Keys (PK) - Total: 24

| No | Nama Tabel | Kolom PK | Query SQL Aktual |
| :---: | :--- | :---: | :--- |
| 1 | `users` | `id` | `ALTER TABLE users ADD CONSTRAINT pk_users PRIMARY KEY (id);` |
| 2 | `user_profiles` | `id` | `ALTER TABLE user_profiles ADD CONSTRAINT pk_user_profiles PRIMARY KEY (id);` |
| 3 | `password_reset_tokens` | `id` | `ALTER TABLE password_reset_tokens ADD CONSTRAINT pk_password_reset_tokens PRIMARY KEY (id);` |
| 4 | `cv_templates` | `id` | `ALTER TABLE cv_templates ADD CONSTRAINT pk_cv_templates PRIMARY KEY (id);` |
| 5 | `applicant_cvs` | `id` | `ALTER TABLE applicant_cvs ADD CONSTRAINT pk_applicant_cvs PRIMARY KEY (id);` |
| 6 | `work_experiences` | `id` | `ALTER TABLE work_experiences ADD CONSTRAINT pk_work_experiences PRIMARY KEY (id);` |
| 7 | `educations` | `id` | `ALTER TABLE educations ADD CONSTRAINT pk_educations PRIMARY KEY (id);` |
| 8 | `applicant_skills` | `id` | `ALTER TABLE applicant_skills ADD CONSTRAINT pk_applicant_skills PRIMARY KEY (id);` |
| 9 | `job_categories` | `id` | `ALTER TABLE job_categories ADD CONSTRAINT pk_job_categories PRIMARY KEY (id);` |
| 10 | `job_postings` | `id` | `ALTER TABLE job_postings ADD CONSTRAINT pk_job_postings PRIMARY KEY (id);` |
| 11 | `saved_jobs` | `id` | `ALTER TABLE saved_jobs ADD CONSTRAINT pk_saved_jobs PRIMARY KEY (id);` |
| 12 | `applications` | `id` | `ALTER TABLE applications ADD CONSTRAINT pk_applications PRIMARY KEY (id);` |
| 13 | `application_status_logs` | `id` | `ALTER TABLE application_status_logs ADD CONSTRAINT pk_application_status_logs PRIMARY KEY (id);` |
| 14 | `interviews` | `id` | `ALTER TABLE interviews ADD CONSTRAINT pk_interviews PRIMARY KEY (id);` |
| 15 | `interview_results` | `id` | `ALTER TABLE interview_results ADD CONSTRAINT pk_interview_results PRIMARY KEY (id);` |
| 16 | `notifications` | `id` | `ALTER TABLE notifications ADD CONSTRAINT pk_notifications PRIMARY KEY (id);` |
| 17 | `organization_experiences` | `id` | `ALTER TABLE organization_experiences ADD CONSTRAINT pk_organization_experiences PRIMARY KEY (id);` |
| 18 | `portofolio` | `id` | `ALTER TABLE portofolio ADD CONSTRAINT pk_portofolio PRIMARY KEY (id);` |
| 19 | `user_notification_preferences` | `id` | `ALTER TABLE user_notification_preferences ADD CONSTRAINT pk_user_notification_preferences PRIMARY KEY (id);` |
| 20 | `work_locations` | `id` | `ALTER TABLE work_locations ADD CONSTRAINT pk_work_locations PRIMARY KEY (id);` |
| 21 | `sessions` | `id` | `ALTER TABLE sessions ADD CONSTRAINT pk_sessions PRIMARY KEY (id);` |
| 22 | `cache` | `key` | `ALTER TABLE cache ADD CONSTRAINT pk_cache PRIMARY KEY (\`key\`);` |
| 23 | `cache_locks` | `key` | `ALTER TABLE cache_locks ADD CONSTRAINT pk_cache_locks PRIMARY KEY (\`key\`);` |
| 24 | `migrations` | `id` | `ALTER TABLE migrations ADD CONSTRAINT pk_migrations PRIMARY KEY (id);` |

---

### B. Foreign Keys (FK) - Total: 24

| No | Tabel Asal | Kolom FK | Tabel & Kolom Referensi | Query SQL Aktual |
| :---: | :--- | :---: | :--- | :--- |
| 1 | `user_profiles` | `user_id` | `users(id)` | `ALTER TABLE user_profiles ADD CONSTRAINT fk_user_profiles_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 2 | `password_reset_tokens` | `user_id` | `users(id)` | `ALTER TABLE password_reset_tokens ADD CONSTRAINT fk_password_reset_tokens_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 3 | `applicant_cvs` | `user_id` | `users(id)` | `ALTER TABLE applicant_cvs ADD CONSTRAINT fk_applicant_cvs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 4 | `applicant_cvs` | `template_id` | `cv_templates(id)` | `ALTER TABLE applicant_cvs ADD CONSTRAINT fk_applicant_cvs_template FOREIGN KEY (template_id) REFERENCES cv_templates(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 5 | `work_experiences` | `user_id` | `users(id)` | `ALTER TABLE work_experiences ADD CONSTRAINT fk_work_experiences_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 6 | `educations` | `user_id` | `users(id)` | `ALTER TABLE educations ADD CONSTRAINT fk_educations_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 7 | `applicant_skills` | `user_id` | `users(id)` | `ALTER TABLE applicant_skills ADD CONSTRAINT fk_applicant_skills_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 8 | `job_postings` | `hr_user_id` | `users(id)` | `ALTER TABLE job_postings ADD CONSTRAINT fk_job_postings_hr_user FOREIGN KEY (hr_user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 9 | `job_postings` | `category_id` | `job_categories(id)` | `ALTER TABLE job_postings ADD CONSTRAINT fk_job_postings_category FOREIGN KEY (category_id) REFERENCES job_categories(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 10 | `saved_jobs` | `user_id` | `users(id)` | `ALTER TABLE saved_jobs ADD CONSTRAINT fk_saved_jobs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 11 | `saved_jobs` | `job_id` | `job_postings(id)` | `ALTER TABLE saved_jobs ADD CONSTRAINT fk_saved_jobs_job FOREIGN KEY (job_id) REFERENCES job_postings(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 12 | `applications` | `user_id` | `users(id)` | `ALTER TABLE applications ADD CONSTRAINT fk_applications_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 13 | `applications` | `job_id` | `job_postings(id)` | `ALTER TABLE applications ADD CONSTRAINT fk_applications_job FOREIGN KEY (job_id) REFERENCES job_postings(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 14 | `applications` | `cv_id` | `applicant_cvs(id)` | `ALTER TABLE applications ADD CONSTRAINT fk_applications_cv FOREIGN KEY (cv_id) REFERENCES applicant_cvs(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 15 | `application_status_logs` | `application_id` | `applications(id)` | `ALTER TABLE application_status_logs ADD CONSTRAINT fk_status_logs_application FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 16 | `application_status_logs` | `changed_by` | `users(id)` | `ALTER TABLE application_status_logs ADD CONSTRAINT fk_status_logs_changed_by FOREIGN KEY (changed_by) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 17 | `interviews` | `application_id` | `applications(id)` | `ALTER TABLE interviews ADD CONSTRAINT fk_interviews_application FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 18 | `interviews` | `scheduled_by` | `users(id)` | `ALTER TABLE interviews ADD CONSTRAINT fk_interviews_scheduled_by FOREIGN KEY (scheduled_by) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 19 | `interview_results` | `interview_id` | `interviews(id)` | `ALTER TABLE interview_results ADD CONSTRAINT fk_interview_results_interview FOREIGN KEY (interview_id) REFERENCES interviews(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 20 | `interview_results` | `reviewed_by` | `users(id)` | `ALTER TABLE interview_results ADD CONSTRAINT fk_interview_results_reviewed_by FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 21 | `notifications` | `user_id` | `users(id)` | `ALTER TABLE notifications ADD CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 22 | `organization_experiences` | `user_id` | `users(id)` | `ALTER TABLE organization_experiences ADD CONSTRAINT fk_organization_experiences_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 23 | `portofolio` | `user_id` | `users(id)` | `ALTER TABLE portofolio ADD CONSTRAINT fk_portofolio_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |
| 24 | `user_notification_preferences` | `user_id` | `users(id)` | `ALTER TABLE user_notification_preferences ADD CONSTRAINT fk_user_notification_preferences_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;` |

---

### C. Unique Keys - Total: 9

| No | Nama Tabel | Kolom Unik | Query SQL Aktual |
| :---: | :--- | :--- | :--- |
| 1 | `users` | `email` | `ALTER TABLE users ADD CONSTRAINT users_email_unique UNIQUE (email);` |
| 2 | `password_reset_tokens` | `token` | `ALTER TABLE password_reset_tokens ADD CONSTRAINT password_reset_tokens_token_unique UNIQUE (token);` |
| 3 | `job_categories` | `slug` | `ALTER TABLE job_categories ADD CONSTRAINT job_categories_slug_unique UNIQUE (slug);` |
| 4 | `job_postings` | `slug` | `ALTER TABLE job_postings ADD CONSTRAINT job_postings_slug_unique UNIQUE (slug);` |
| 5 | `work_locations` | `name` | `ALTER TABLE work_locations ADD CONSTRAINT work_locations_name_unique UNIQUE (name);` |
| 6 | `interview_results` | `interview_id` | `ALTER TABLE interview_results ADD CONSTRAINT interview_results_interview_id_unique UNIQUE (interview_id);` |
| 7 | `user_notification_preferences` | `user_id` | `ALTER TABLE user_notification_preferences ADD CONSTRAINT user_notification_preferences_user_id_unique UNIQUE (user_id);` |
| 8 | `saved_jobs` | `[user_id, job_id]` | `ALTER TABLE saved_jobs ADD CONSTRAINT saved_jobs_user_id_job_id_unique UNIQUE (user_id, job_id);` |
| 9 | `applications` | `[user_id, job_id]` | `ALTER TABLE applications ADD CONSTRAINT applications_user_id_job_id_unique UNIQUE (user_id, job_id);` |

---

## 4. Aturan Bisnis & Logika Validasi Tambahan (Database Triggers)
Selain key constraint di atas, database juga dilengkapi dengan **5 Database Triggers** untuk mengontrol kelayakan data secara otomatis:

1.  **`before_user_profile_insert` & `before_user_profile_update`**:
    Menolak pengisian profil apabila usia pelamar di bawah 17 tahun.
2.  **`before_application_insert`**:
    *   Membatasi maksimal 3 lamaran dengan status aktif (`applied`, `shortlisted`, `interview`) per user.
    *   Memvalidasi kesesuaian umur pelamar dengan rentang syarat lowongan (`age_min` & `age_max`).
3.  **`before_interview_result_insert` & `before_interview_result_update`**:
    Mencegah hasil keputusan interview diset ke `'proceed'` jika skor penilaian di bawah batas minimum (`passing_grade`) dari lowongan yang dilamar.