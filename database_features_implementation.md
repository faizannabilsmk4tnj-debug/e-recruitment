# Laporan Implementasi Fitur & Logika Kode Database (E-Recruitment)

Laporan ini menyajikan hasil *screening* menyeluruh dari seluruh kode program proyek E-Recruitment untuk mengidentifikasi penggunaan delapan fitur utama database. Setiap fitur dilengkapi dengan penggalan kode asli, fungsi langsungnya di sistem, serta alur eksekusi kodenya.

---

## 1. Aggregates (Agregasi)
* **Status**: **ADA (Digunakan)**
* **Penggalan Kode**:
  Ditemukan di dalam Stored Procedure `sp_laporan_rekrutmen` pada file `database/migrations/2026_06_25_000007_create_recruitment_functions_procedures.php`:
  ```sql
  SELECT 
      jp.id AS job_id,
      jp.title AS job_title,
      COUNT(a.id) AS total_pelamar, -- Menghitung jumlah pelamar
      SUM(CASE WHEN a.status = 'accepted' THEN 1 ELSE 0 END) AS diterima, -- Menjumlahkan pelamar diterima
      ROUND(AVG(ir.score), 1) AS rata_rata_skor_interview -- Menghitung nilai rata-rata wawancara
  FROM job_postings jp
  LEFT JOIN applications a ON a.job_id = jp.id
  LEFT JOIN interviews i ON i.application_id = a.id
  LEFT JOIN interview_results ir ON ir.interview_id = i.id
  GROUP BY jp.id, jp.title;
  ```
* **Fungsi Langsung**: Merangkum kumpulan data transaksi lamaran dan wawancara pelamar yang jumlahnya banyak menjadi angka statistik ringkas (total pendaftar, jumlah pelamar lolos, dan rata-rata skor) per lowongan pekerjaan untuk dashboard HR Master.
* **Alur Kode**:
  1. MySQL menggabungkan tabel `job_postings` dengan tabel terkait (`applications`, `interviews`, `interview_results`).
  2. Data dikelompokkan per lowongan menggunakan perintah `GROUP BY jp.id`.
  3. Mesin MySQL menghitung agregat: `COUNT()` menjumlahkan baris lamaran, `SUM()` menghitung pelamar bertatus `'accepted'`, dan `AVG()` menjumlahkan semua skor wawancara lalu membaginya dengan jumlah peserta.
  4. Hasil kalkulasi dikembalikan sebagai satu baris data statistik per lowongan.

---

## 2. Sub Query (Subkueri)
* **Status**: **ADA (Digunakan)**
* **Penggalan Kode**:
  Ditemukan di dalam Stored Procedure `sp_statistik_pelamar` pada file `database/migrations/2026_06_25_000007_create_recruitment_functions_procedures.php`:
  ```sql
  SELECT 
      u.id AS user_id,
      u.name,
      -- Sub Query untuk mencari rata-rata skor interview dari user tertentu
      (SELECT ROUND(AVG(ir2.score), 1) 
       FROM interviews i2 
       JOIN interview_results ir2 ON ir2.interview_id = i2.id 
       JOIN applications a2 ON a2.id = i2.application_id 
       WHERE a2.user_id = u.id) AS rata_rata_skor
  FROM users u
  LEFT JOIN applications a ON a.user_id = u.id
  WHERE u.id = p_user_id
  GROUP BY u.id, u.name, u.email;
  ```
* **Fungsi Langsung**: Menghitung rata-rata skor wawancara yang dimiliki oleh pelamar tertentu dari riwayat seluruh wawancara yang pernah ia ikuti di berbagai lamaran pekerjaan berbeda.
* **Alur Kode**:
  1. Kueri utama mengambil data identitas pengguna dari tabel `users` berdasarkan `p_user_id`.
  2. Saat memproses kolom `rata_rata_skor`, MySQL mengeksekusi subkueri independen di dalam tanda kurung `(SELECT ...)`.
  3. Subkueri tersebut mencari dan merelasikan data nilai wawancara (`interview_results`) yang memiliki `user_id` cocok dengan pengguna di kueri utama (`a2.user_id = u.id`).
  4. Hasil rata-rata skor dari subkueri dikembalikan sebagai nilai kolom `rata_rata_skor` untuk baris data tersebut.

---

## 3. Constraints (Batasan Data)
* **Status**: **ADA (Digunakan)**
* **Penggalan Kode**:
  * **Referential Integrity (Foreign Key)** di file `database/migrations/2026_03_23_045623_create_applications_table.php`:
    ```php
    $table->foreignId('user_id')->constrained('users');
    $table->foreignId('job_id')->constrained('job_postings');
    ```
  * **Domain Integrity (CHECK Constraint)** di file `database/migrations/2026_07_02_000001_add_min_age_check_to_user_profiles_table.php`:
    ```php
    DB::statement("ALTER TABLE user_profiles ADD CONSTRAINT chk_usia_minimal CHECK (TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= 17)");
    ```
* **Fungsi Langsung**: 
  * *Foreign Key*: Menjaga keutuhan relasi data (*Referential Integrity*) agar tidak ada baris lamaran pekerjaan yang mengarah ke ID pengguna atau ID lowongan palsu.
  * *CHECK Constraint*: Membatasi secara keras agar tidak ada pelamar dengan usia di bawah 17 tahun yang dapat menyimpan tanggal lahir pada data profil.
* **Alur Kode**:
  1. Pelamar melengkapi data profil (mengisi tanggal lahir) lalu klik "Simpan".
  2. Laravel mengirimkan kueri `UPDATE user_profiles SET birth_date = ... WHERE user_id = ...`.
  3. Sebelum data di-commit, mesin database MySQL mengeksekusi pemeriksaan CHECK constraint `chk_usia_minimal`.
  4. Jika usia yang dihitung (`TIMESTAMPDIFF(YEAR, birth_date, CURDATE())`) kurang dari 17 tahun, database membatalkan kueri, memicu error, dan Laravel menangkapnya lewat `QueryException` untuk ditampilkan sebagai notifikasi error di halaman profil.

---

## 4. Stored Procedure & Function (Prosedur & Fungsi Database)
* **Status**: **ADA (Digunakan)**
* **Penggalan Kode**:
  * **Stored Function** (`fn_cek_kelayakan_melamar` di file `database/migrations/2026_06_25_000007_create_recruitment_functions_procedures.php`):
    ```sql
    CREATE FUNCTION fn_cek_kelayakan_melamar(p_user_id BIGINT, p_job_id BIGINT)
    RETURNS VARCHAR(255)
    BEGIN
        -- Validasi jumlah lamaran aktif
        SELECT COUNT(*) INTO v_active_count FROM applications WHERE user_id = p_user_id AND status IN ('applied', 'shortlisted', 'interview');
        IF v_active_count >= 3 THEN
            RETURN 'MELEBIHI_BATAS_AKTIF';
        END IF;
        RETURN 'ELIGIBLE';
    END;
    ```
    Pemanggilan di Laravel (`app/Http/Controllers/VacancyController.php` baris 116):
    ```php
    $eligibility = DB::selectOne("SELECT fn_cek_kelayakan_melamar(?, ?) as eligibility", [$userId, $id])->eligibility;
    ```
  * **Stored Procedure** (`sp_laporan_rekrutmen` di file yang sama):
    ```sql
    CREATE PROCEDURE sp_laporan_rekrutmen()
    BEGIN
        SELECT jp.id, COUNT(a.id) AS total_pelamar, ...
        FROM job_postings jp
        GROUP BY jp.id;
    END;
    ```
    Pemanggilan di Laravel (`app/Http/Controllers/HR/LaporanController.php` baris 224):
    ```php
    $jobReports = DB::select("CALL sp_laporan_rekrutmen()");
    ```
* **Fungsi Langsung**: 
  * *Stored Function*: Memeriksa kelayakan pelamar dalam sekali panggil query untuk menghemat waktu muat halaman lowongan.
  * *Stored Procedure*: Memproses dan menyajikan data laporan rekrutmen dalam bentuk siap saji untuk dashboard HR Master.
* **Alur Kode**:
  1. Laravel memicu kueri melalui perintah PHP (`SELECT fn_cek_kelayakan...` atau `CALL sp_laporan...`).
  2. Mesin MySQL mengeksekusi logika internal prosedural/fungsi yang sudah terkompilasi langsung di server database.
  3. Hasil akhir (string status untuk function, atau baris kueri untuk procedure) dikembalikan ke aplikasi Laravel.

---

## 5. Trigger (Pemicu Otomatis)
* **Status**: **ADA (Digunakan)**
* **Penggalan Kode**:
  Ditemukan pada file `database/migrations/2026_06_25_000006_create_recruitment_triggers.php`:
  ```sql
  CREATE TRIGGER before_application_insert
  BEFORE INSERT ON applications
  FOR EACH ROW
  BEGIN
      DECLARE v_active_count INT;
      
      -- Menghitung lamaran aktif pelamar
      SELECT COUNT(*) INTO v_active_count
      FROM applications
      WHERE user_id = NEW.user_id AND status IN ('applied', 'shortlisted', 'interview');

      IF v_active_count >= 3 THEN
          SIGNAL SQLSTATE '45000'
          SET MESSAGE_TEXT = 'Batas maksimal lamaran aktif tercapai (Maksimal 3 lamaran aktif secara bersamaan).';
      END IF;
  END;
  ```
* **Fungsi Langsung**: Melakukan validasi pengaman otomatis di sisi server database tepat sebelum data lamaran dimasukkan.
* **Alur Kode**:
  1. Aplikasi mencoba menyisipkan data pelamar baru ke tabel `applications`.
  2. Sebelum data disimpan (`BEFORE INSERT`), MySQL memicu trigger `before_application_insert`.
  3. Trigger menghitung lamaran aktif milik pengguna. Jika data lamaran aktif berjumlah 3 atau lebih, kueri digagalkan dengan melempar kustom error SQL menggunakan perintah `SIGNAL SQLSTATE '45000'`.

---

## 6. Transaction (Transaksi Database)
* **Status**: **ADA (Digunakan)**
* **Penggalan Kode**:
  Ditemukan pada file `app/Http/Controllers/HrCvTemplateController.php` baris 146:
  ```php
  public function setDefault(CvTemplate $template): RedirectResponse
  {
      DB::transaction(function () use ($template): void {
          // Langkah 1: Ubah semua template lain menjadi non-default
          CvTemplate::query()->update(['is_default' => false]);

          // Langkah 2: Ubah template terpilih menjadi default
          $template->update([
              'status' => 'published',
              'is_active' => true,
              'is_default' => true,
          ]);
      });

      return back()->with('success', 'Template default berhasil diperbarui.');
  }
  ```
* **Fungsi Langsung**: Menjamin prinsip ACID (terutama *Atomicity*), di mana proses mengubah template default harus berjalan sukses 100% secara utuh. Jika salah satu langkah gagal, seluruh perubahan dibatalkan kembali (*rollback*) agar tidak terjadi inkonsistensi data (seperti adanya dua template default sekaligus).
* **Alur Kode**:
  1. HR menekan tombol "Set Default" untuk salah satu template CV.
  2. Laravel memulai transaksi database dengan mengirim perintah `START TRANSACTION` ke MySQL.
  3. Kueri pertama dijalankan (menghapus status default semua template), diikuti kueri kedua (menyetel template terpilih menjadi default).
  4. Jika semua berhasil tanpa error, Laravel mengirim perintah `COMMIT` untuk menyimpan perubahan permanen. Jika ada kegagalan, Laravel mengirim perintah `ROLLBACK` untuk mengembalikan database ke keadaan sebelum transaksi dimulai.

---

## 7. Cursor (Kursor)
* **Status**: **TIDAK ADA (Tidak Digunakan)**
* **Penjelasan**: Proyek E-Recruitment ini tidak menggunakan kursor (`DECLARE cursor_name CURSOR FOR ...`) di dalam database routine.
* **Alasan Teknis**: Pengolahan data di proyek ini didasarkan pada pendekatan set (*set-based approach*) menggunakan kueri SQL relasional standar (seperti `JOIN` dan `GROUP BY` pada Stored Procedure `sp_laporan_rekrutmen`). Pendekatan ini jauh lebih cepat dan efisien dalam MySQL dibandingkan dengan menggunakan kursor, yang melakukan pemrosesan data baris demi baris (*row-by-row / RBAR*) yang memakan banyak memori dan memperlambat performa server database.

---

## 8. PL/SQL (Procedural Language/SQL)
* **Status**: **TIDAK ADA SECARA HARFIAH, NAMUN ADA SECARA KONSEP (MySQL Procedural SQL)**
* **Penjelasan**: Secara harfiah, PL/SQL adalah bahasa ekstensi prosedural khusus milik Oracle Database, sehingga tidak ada di proyek ini karena database yang kita gunakan adalah MySQL/MariaDB. Namun, secara konsep pemrograman prosedural di database, kita **menggunakan bahasa pemrograman SQL prosedural bawaan MySQL** (*Stored Program Language*).
* **Penggalan Kode**:
  Ditemukan di dalam Stored Function/Trigger pada kueri SQL di database kita (menggunakan sintaks prosedural):
  ```sql
  DECLARE v_age INT;
  
  IF v_birth_date IS NULL THEN
      SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Lowongan ini memiliki syarat batas usia...';
  ELSE
      SET v_age = TIMESTAMPDIFF(YEAR, v_birth_date, CURDATE());
      ...
  END IF;
  ```
* **Fungsi Langsung**: Membuat alur keputusan logis (*conditional logic*) dan deklarasi variabel dinamis langsung di tingkat server database untuk menangani validasi yang kompleks.
* **Alur Kode**:
  1. Variabel dideklarasikan terlebih dahulu menggunakan perintah `DECLARE`.
  2. Pernyataan kondisional `IF ... THEN ... ELSE ... END IF` mengevaluasi kondisi boolean.
  3. Blok kode di dalam kondisi yang terpenuhi akan dijalankan, sementara blok lainnya dilewati.
