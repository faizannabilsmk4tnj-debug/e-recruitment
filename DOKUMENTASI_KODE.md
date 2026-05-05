# 📚 BUKU PANDUAN LENGKAP: STRUKTUR & KODE APLIKASI E-RECRUITMENT
**Proyek:** E-Recruitment PT Eco Green Oleochemicals
**Framework:** Laravel 11/10 (Backend) + TailwindCSS (Frontend) + Vanilla JS

Dokumen ini adalah panduan pamungkas yang membedah SETIAP folder, SETIAP file, dan SETIAP logika kodingan yang ada di dalam proyek Anda. Dokumen ini dirancang agar Anda bisa menguasai 100% arsitektur proyek ini untuk presentasi.

---

## 📂 BAGIAN 1: FUNGSI DAN TUJUAN SEMUA FOLDER PROYEK
Laravel memiliki struktur folder standar. Berikut adalah penjelasan logis untuk setiap folder di dalam *root* proyek Anda:
 
1. **`app/`**
   *   **Fungsi:** Ini adalah otak dan jantung aplikasi (Backend). Di sini berisi logika komputasi PHP (Models untuk database, Controllers untuk logika bisnis, Middleware untuk keamanan).
   *   **Tujuan:** Saat Anda mulai membuat API nanti, semua kodingan pemrosesan data akan ditaruh di sini. Folder ini **tidak boleh dihapus** karena tanpanya sistem akan mati.
2. **`bootstrap/`**
   *   **Fungsi:** Folder ini mengatur proses *startup* (booting) saat TODO: Laravel pertama kali dijalankan. Terdapat file `app.php` dan folder `cache/` untuk mempercepat pemuatan (loading) framework ke memori.
3. **`config/`**
   *   **Fungsi:** Pusat pengaturan (*settings*). Semua konfigurasi krusial seperti koneksi database (`database.php`), pengaturan sesi login user (`session.php`), dan zona waktu ada di sini.
4. **`database/`**
   *   **Fungsi:** Tempat mengelola database. Berisi rancangan pembuatan tabel tanpa phpMyAdmin (Migrations), pembuat data palsu (Factories), dan eksekutor penyebar data palsu ke database (Seeders).
5. **`node_modules/`**
   *   **Fungsi:** Gudang penyimpanan semua *library* Javascript yang didownload secara otomatis oleh perintah `npm install`. <!--TODO: Kompilator TailwindCSS dan Vite bersemayam di sini.-->
   *   **Tujuan:** Folder ini sangat besar dan berfungsi untuk menerjemahkan kodingan class Tailwind Anda (`bg-green-500`) menjadi CSS sungguhan saat perintah `npm run dev` berjalan.
6. **`public/`**
   *   **Fungsi:** Satu-satunya folder yang bisa diakses langsung oleh *browser* pengunjung (Client). Di sinilah letak file `index.php` (pintu masuk utama), serta tempat penyimpanan gambar (`images/`), CSS (`css/`), dan kodingan Javascript buatan Anda (`js/`).
7. **`resources/`**
   *   **Fungsi:** Tempat penyimpanan *raw materials* (bahan mentah) tampilan antarmuka (UI). Di sinilah letak semua file kodingan `.blade.php` (Views) yang Anda susun secara visual.
8. **`routes/`**
   *   **Fungsi:** Peta jalan navigasi aplikasi. Mengatur rute URL apa memanggil file tampilan apa.
9. **`storage/`**
   *   **Fungsi:** Tempat sistem Laravel menyimpan file *upload* pelamar (seperti PDF CV), file catatan error sistem (`logs/`), dan memori singgahan (*cache* template).
10. **`tests/`**
    *   **Fungsi:** Folder untuk <!--TODO: menulis kodingan pengujian otomatis (Unit Testing/Automation) agar aplikasi dijamin bebas *bug*. -->
11. **`vendor/`**
    *   **Fungsi:** Gudang penyimpanan *library* bawaan PHP (didownload lewat `composer install`). Inti mesin dari framework Laravel bersembunyi di dalam folder ini.

---

## 📄 BAGIAN 2: FUNGSI FILE-FILE DI ROOT (LUAR FOLDER)
1. **`.env`**
   *   **Fungsi & Logika:** Ini adalah brankas rahasia aplikasi. File ini menyimpan *password* database, kunci keamanan aplikasi, dan *setting environment*. Kodingan `env('DB_PASSWORD')` di Laravel akan mengambil nilai langsung dari file ini.
2. **`artisan`**
   *   **Fungsi:** Ini adalah skrip *command-line* Laravel. Memungkinkan Anda menjalankan perintah terminal seperti `php artisan serve` untuk menyalakan server.
3. **`composer.json` & `composer.lock`**
   *   **Fungsi:** Buku catatan yang mencatat daftar *library* PHP versi spesifik apa saja yang dibutuhkan proyek agar tidak *crash* jika dipindahkan ke komputer lain.
4. **`package.json` & `package-lock.json`**
   *   **Fungsi:** Sama seperti composer, namun ini adalah buku catatan daftar *library* Javascript (seperti Tailwind dan Vite).
5. **`tailwind.config.js`**
   *   **Fungsi:** Tempat Anda mendeklarasikan warna *custom* perusahaan (misal warna hijau Eco Green) dan *font* kustom agar dikenali oleh kompilator Tailwind.
6. **`vite.config.js`**
   *   **Fungsi & Logika:** Alat (*Bundler*) canggih yang membungkus, memperkecil, dan mempercepat pemuatan seluruh file CSS dan JS Anda di browser.

---

## 💻 BAGIAN 3: BEDAH LOGIKA KODINGAN ROUTING (`routes/web.php`)
Di file ini, kita tidak meletakkan kodingan rumit. File ini sepenuhnya menerapkan logika percabangan URL sederhana.
**Logika Kodingan Dasar:**
```php
Route::get('/hr/dashboard', function () {
    return view('hr.dashboard');
});
```
*   **Fungsi Logis:** 
    1. Metode `Route::get` menyuruh sistem menangkap *request* saat user mengetik URL `/hr/dashboard` di browser. 
    2. Kode `return view('hr.dashboard')` menginstruksikan server: *"Cari file berekstensi .blade.php di dalam folder resources/views/hr/ yang bernama dashboard, ubah HTML-nya, dan kembalikan ke layar user"*.

**Logika Kodingan Grouping:**
Terdapat kode `Route::prefix('hr')->group(function () {...});`. Logika ini dipakai agar kita tidak perlu repot mengetik ulang kata `/hr/` berulang-ulang untuk setiap halaman internal HR. 

---

## 🖥️ BAGIAN 4: BEDAH LOGIKA KODINGAN VIEWS / TAMPILAN (`resources/views/`)
Kodingan `.blade.php` kita menerapkan logika **Warisan (Inheritance)**. Kita tidak mengetik struktur HTML dasar berulang-ulang.

**A. Logika Folder `layouts/` (Cangkang/Master Template)**
*   **File:** `landing.blade.php`, `auth.blade.php`, `hr.blade.php`, <!--TODO:`pelamar.blade.php`.-->
*   **Logika Kodingan:** Di dalam file ini terdapat *syntax* ajaib `@yield('content')`.
*   **Penjelasan Logis:** File ini seperti papan berlubang. Kode `@yield` <!--TODO:berarti: *"Saya membuat kerangka navbar dan sidebar statis di sini. Tolong sediakan lubang kosong di bagian tengah, nanti lubang ini akan diisi secara dinamis oleh halaman lain yang memanggil saya"* --> 

**B. Logika Halaman Konten (`hr/` & `pelamar/`)**
*   **Logika Kodingan:** Di baris paling atas file `dashboard.blade.php`, <!--TODO:kita mengetik `@extends('layouts.hr')` dan `@section('content')`.-->
*   **Penjelasan Logis:** Kode ini berkata: *"Halo sistem, tolong ambil kerangka layout HR (navbar & sidebar), lalu tempelkan tabel dan grafik yang saya buat di file ini tepat ke dalam lubang kosong yang sudah disiapkan sebelumnya"*. Ini membuat kodingan menjadi sangat bersih.

---

## ⚙️ BAGIAN 5: BEDAH LOGIKA KODINGAN JAVASCRIPT (`public/js/`)
Javascript adalah nyawa interaktif dari aplikasi ini. Ia berjalan murni di dalam *Browser* pengunjung tanpa perlu me-*refresh* koneksi ke server.

### 1. Logika Kodingan: Form Autentikasi (Mock Login)
*   **Lokasi Kode:** <!--TODO:Skrip JS di bagian bawah halaman `login.blade.php` (atau file eksternal terkait).-->
*   **Logika & Fungsi Baris Kode:**
    1.  `document.getElementById('loginForm').addEventListener('submit', function(e) {...})`: <!--TODO: Mengikat pendengar kejadian (*listener*). Jika form ditekan *Submit*, jalankan fungsi ini. -->
    2.  `e.preventDefault();`: **Mencegah** perilaku *default* browser yang akan me-*refresh* halaman saat form dikirim.
    3.  `const email = document.getElementById('email').value;`: <!--TODO: Mengambil nilai (*value*) teks yang diketik oleh user di kotak email.-->
    4.  `if (email === '') { alertBox.classList.remove('hidden') }`: Ini adalah logika gerbang bersyarat (*If-Else*). <!--TODO:Jika kotak email kosong, maka cari kotak peringatan merah di HTML dan hapus kelas CSS bernama `hidden`. Efeknya: Peringatan berwarna merah muncul tiba-tiba secara dramatis.-->
    5.  `window.location.href = '/hr/dashboard'`: <!--TODO:Jika pengecekan validasi lolos semua -->, kode ini akan "melemparkan" URL browser pengunjung ke halaman Dashboard secara paksa.

### 2. Logika Kodingan: <!--TODO:Manajemen Status & Modal Wawancara HR -->
*   **Lokasi Kode:** File JS yang menangani *dropdown* status di halaman detail pelamar.
*   **Logika & Fungsi Baris Kode:**
    1.  Terdapat *Event Listener* bertipe `change` pada *Dropdown* pilihan status.
    2.  `if (event.target.value === 'interview')`: Logika ini memonitor, "Apakah HR baru saja mengganti status lamaran orang ini ke pilihan 'interview'?".
    3.  Jika YA, kode kita secara ajaib <!--TODO:memblokir form agar tidak dikirim ke server. -->
    4.  `document.getElementById('modal-wawancara').classList.remove('hidden')`: Kode ini akan mencari *Pop-up Modal Input Jadwal Wawancara* yang tadinya gaib/tersembunyi, lalu menampilkannya.
    5.  **Tujuan Logis:** Pemaksaan halus. Kita memaksa HR untuk mengisi tanggal, jam, dan *link Zoom* terlebih dahulu. Status tidak akan benar-benar berubah di sistem sampai HR mengklik tombol "Simpan Jadwal" di *pop-up* tersebut.

### 3. Logika Kodingan: Kalender Interaktif HR Dashboard
*   **Lokasi Kode:** File `public/js/hr/dashboard.js` (Atau script yang tertanam di halaman dashboard HR).
*   **Logika Render Kalender:**
    1.  `const date = new Date()`: Memanggil fungsi mesin waktu bawaan Browser untuk mengambil data bulan dan tahun hari ini.
    2.  Algoritma JS kita menghitung jumlah total hari bulan ini (28/30/31).
    3.  Menggunakan logika *Looping* (Perulangan): <!--TODO:`for (let i = 1; i <= jumlahHari; i++)`-->. Kode ini otomatis membangun cetakan HTML kotak-kotak tanggal tanpa lelah berulang-ulang sampai tanggal habis, lalu menempelkannya ke layar (DOM *Insertion*).
*   **Logika Filter (Menyortir) Antrean:**
    1.  Setiap kotak tanggal diberi kepekaan sensor klik (`click event`).
    2.  Saat tanggal 12 diklik, JS menyimpan nilai "12".
    3.  `document.querySelectorAll('.interview-card')`: JS akan menyorot semua kartu jadwal kandidat yang ada di daftar.
    4.  JS melakukan pengecekan satu per satu (Iterasi). <!--TODO:Jika tanggal di kartu tersebut BUKAN 12, maka ia mengeksekusi `card.style.display = 'none'` (hilang/disembunyikan). Jika COCOK, maka `card.style.display = 'block'` (ditampilkan).-->

### 4. Logika Kodingan: Batasan (*Constraint*) CV Builder Pelamar
*   **Tujuan:** Mencegah pelamar mengetik terlalu banyak hingga CV bocor melebihi ukuran 1 halaman saat di-PDF-kan.
*   **Logika & Fungsi Baris Kode:**
    1.  Setiap kali pelamar mengetik <!--TODO:(*Keyup Event*) -->  pada form pengisian pengalaman kerja/pendidikan.
    2.  `let tinggiKertas = document.getElementById('cv-canvas').scrollHeight;`: JS akan segera mengambil meteran ukur dan menghitung tinggi (*height*) elemen "Kertas CV" di layar secara *real-time*.
    3.  `if (tinggiKertas > 842)`: Ini adalah logika batasan kertas A4. 842 pixel adalah konversi ukuran tinggi kertas A4 standar dalam dunia web.
    4.  Jika tinggi lebih besar dari 842px, JS akan menggagalkan penambahan teks terakhir dan menampilkan `alert('Maaf, maksimal 1 halaman tercapai')`.
    5.  **Tujuan Logis:** Menjamin integritas desain agar UI aplikasi E-Recruitment tetap terlihat sangat terstruktur dan rapi.
