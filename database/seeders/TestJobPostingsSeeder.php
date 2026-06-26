<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPosting;
use Carbon\Carbon;

class TestJobPostingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today();

        $jobs = [
            [
                'hr_user_id'        => 1,
                'category_id'       => 1, // IT & Engineering
                'title'             => 'Mobile Developer (Flutter)',
                'description'       => 'Kami mencari Mobile Developer yang berpengalaman dalam membangun aplikasi Android dan iOS menggunakan Flutter. Anda akan berkolaborasi dengan tim backend dan UI/UX untuk merancang fitur baru.',
                'requirements'      => 'Minimal D3/S1 Teknik Informatika. Pengalaman minimal 1 tahun menggunakan Flutter/Dart. Memiliki portofolio aplikasi yang sudah dipublikasikan di Play Store atau App Store.',
                'benefits'          => 'Gaji menarik, laptop kantor, BPJS Kesehatan & Ketenagakerjaan, jam kerja fleksibel.',
                'employment_type'   => 'full-time',
                'location_type'     => 'hybrid',
                'location'          => 'Batam, Kepulauan Riau',
                'salary_min'        => 6000000.00,
                'salary_max'        => 10000000.00,
                'show_salary'       => true,
                'quota'             => 3,
                'age_min'           => 20,
                'age_max'           => 30,
                'passing_grade'     => 75,
                'applicant_count'   => 0,
                'status'            => 'open',
                'auto_close_method' => 'both',
                'deadline'          => $today->copy()->addDays(10)->toDateString(),
            ],
            [
                'hr_user_id'        => 16,
                'category_id'       => 1, // IT & Engineering
                'title'             => 'DevOps Engineer',
                'description'       => 'Kami mencari DevOps Engineer yang dapat mengelola infrastruktur server cloud (AWS/GCP), mengonfigurasi CI/CD pipelines, dan memastikan keamanan sistem operasional.',
                'requirements'      => 'Minimal S1 IT/Sistem Informasi. Memiliki pengalaman dengan Docker, Kubernetes, Jenkins, dan Gitlab CI. Terbiasa mengelola sistem operasi Linux.',
                'benefits'          => 'Gaji kompetitif, tunjangan komunikasi, asuransi swasta, opsi kerja remote.',
                'employment_type'   => 'full-time',
                'location_type'     => 'remote',
                'location'          => 'Jakarta (Remote)',
                'salary_min'        => 9000000.00,
                'salary_max'        => 15000000.00,
                'show_salary'       => true,
                'quota'             => 2,
                'age_min'           => 22,
                'age_max'           => 35,
                'passing_grade'     => 80,
                'applicant_count'   => 0,
                'status'            => 'open',
                'auto_close_method' => 'deadline',
                // Deadline in the past to test auto-close by deadline
                'deadline'          => $today->copy()->subDays(2)->toDateString(),
            ],
            [
                'hr_user_id'        => 2,
                'category_id'       => 1, // IT & Engineering
                'title'             => 'Senior Frontend Developer (React)',
                'description'       => 'Dibutuhkan Senior Frontend Developer yang mahir membangun antarmuka web modern dengan React.js dan TailwindCSS. Bertanggung jawab atas performa, optimasi, dan skalabilitas frontend web.',
                'requirements'      => 'Pengalaman minimal 3 tahun dengan React.js. Kuat dalam JavaScript ES6+, HTML5, CSS3/Tailwind. Memiliki pemahaman yang baik tentang RESTful API integration.',
                'benefits'          => 'Gaji premium, BPJS, bonus tahunan, lingkungan kerja internasional.',
                'employment_type'   => 'full-time',
                'location_type'     => 'onsite',
                'location'          => 'Batam, Kepulauan Riau',
                'salary_min'        => 10000000.00,
                'salary_max'        => 18000000.00,
                'show_salary'       => true,
                'quota'             => 1,
                'age_min'           => 24,
                'age_max'           => 40,
                'passing_grade'     => 85,
                'applicant_count'   => 0,
                'status'            => 'open',
                'auto_close_method' => 'both',
                // Deadline approaching in 3 days to test approaching deadline notification
                'deadline'          => $today->copy()->addDays(3)->toDateString(),
            ],
            [
                'hr_user_id'        => 2,
                'category_id'       => 3, // Human Resources
                'title'             => 'HR Training & Development Specialist',
                'description'       => 'Mencari spesialis HR yang berfokus pada pelatihan dan pengembangan kompetensi karyawan. Anda akan mendesain kurikulum training, membimbing proses onboarding, dan mengevaluasi efektivitas pelatihan.',
                'requirements'      => 'Minimal S1 Psikologi atau Manajemen SDM. Pengalaman minimal 2 tahun di bidang L&D (Learning & Development). Memiliki kemampuan komunikasi publik dan presentasi yang unggul.',
                'benefits'          => 'Gaji kompetitif, tunjangan makan, BPJS lengkap, pelatihan sertifikasi berbayar.',
                'employment_type'   => 'full-time',
                'location_type'     => 'onsite',
                'location'          => 'Batam, Kepulauan Riau',
                'salary_min'        => 5500000.00,
                'salary_max'        => 8000000.00,
                'show_salary'       => false,
                'quota'             => 1,
                'age_min'           => 23,
                'age_max'           => 32,
                'passing_grade'     => 70,
                'applicant_count'   => 0,
                'status'            => 'open',
                'auto_close_method' => 'deadline',
                // Deadline approaching in 1 day to test approaching deadline notification
                'deadline'          => $today->copy()->addDay()->toDateString(),
            ],
            [
                'hr_user_id'        => 16,
                'category_id'       => 1, // IT & Engineering
                'title'             => 'Data Scientist',
                'description'       => 'Mencari Data Scientist untuk mengolah kumpulan data rekrutmen dan operasional perusahaan guna menghasilkan wawasan prediktif dan model pembelajaran mesin (machine learning) yang bermanfaat bagi bisnis.',
                'requirements'      => 'Pendidikan minimal S1 Statistika, Matematika, atau Ilmu Komputer. Menguasai Python/R, SQL, dan pustaka seperti Pandas, Scikit-learn, TensorFlow. Pengalaman min 1 tahun.',
                'benefits'          => 'Gaji menarik, asuransi kesehatan swasta, insentif proyek, lingkungan kerja modern.',
                'employment_type'   => 'full-time',
                'location_type'     => 'hybrid',
                'location'          => 'Batam, Kepulauan Riau',
                'salary_min'        => 8000000.00,
                'salary_max'        => 14000000.00,
                'show_salary'       => true,
                'quota'             => 2,
                'age_min'           => 21,
                'age_max'           => 45,
                'passing_grade'     => 78,
                // Quota met (applicant_count >= quota) to test auto-close by quota
                'applicant_count'   => 2,
                'status'            => 'open',
                'auto_close_method' => 'quota',
                'deadline'          => $today->copy()->addDays(20)->toDateString(),
            ],
            [
                'hr_user_id'        => 1,
                'category_id'       => 2, // Finance & Accounting
                'title'             => 'Accounting Supervisor',
                'description'       => 'Mengawasi jalannya administrasi keuangan harian, membuat laporan laba rugi bulanan dan tahunan, serta memastikan kepatuhan pajak perusahaan berjalan dengan baik sesuai regulasi.',
                'requirements'      => 'S1 Akuntansi dengan pengalaman minimal 3 tahun sebagai Senior Accountant atau Supervisor. Menguasai software perpajakan (e-SPT) dan Accurate/SAP.',
                'benefits'          => 'Gaji pokok kompetitif, tunjangan jabatan, BPJS Kesehatan & Ketenagakerjaan, bonus tahunan.',
                'employment_type'   => 'full-time',
                'location_type'     => 'onsite',
                'location'          => 'Batam, Kepulauan Riau',
                'salary_min'        => 7000000.00,
                'salary_max'        => 11000000.00,
                'show_salary'       => true,
                'quota'             => 1,
                'age_min'           => 25,
                'age_max'           => 38,
                'passing_grade'     => 75,
                'applicant_count'   => 0,
                'status'            => 'open',
                // Auto close only on quota, deadline has passed but should NOT close because auto_close_method is quota
                'auto_close_method' => 'quota',
                'deadline'          => $today->copy()->subDays(5)->toDateString(),
            ],
            [
                'hr_user_id'        => 16,
                'category_id'       => 4, // Operations & Production
                'title'             => 'Production Line Supervisor',
                'description'       => 'Dibutuhkan Supervisor Lini Produksi yang bertanggung jawab mengawasi proses manufaktur oleokimia harian, menjaga standar keselamatan (HSE), serta efisiensi kerja operator.',
                'requirements'      => 'Minimal D3/S1 Teknik Kimia, Teknik Industri, atau Teknik Mesin. Pengalaman minimal 2 tahun memimpin tim produksi di industri manufaktur.',
                'benefits'          => 'Gaji pokok, tunjangan shift, makan siang gratis di kantin perusahaan, BPJS lengkap.',
                'employment_type'   => 'full-time',
                'location_type'     => 'onsite',
                'location'          => 'Batam, Kepulauan Riau',
                'salary_min'        => 6000000.00,
                'salary_max'        => 9000000.00,
                'show_salary'       => false,
                'quota'             => 3,
                'age_min'           => 25,
                'age_max'           => 45,
                'passing_grade'     => 70,
                // Quota met, but auto_close_method is 'deadline' so it should NOT close on quota (only when deadline passes)
                'applicant_count'   => 3,
                'status'            => 'open',
                'auto_close_method' => 'deadline',
                'deadline'          => $today->copy()->addDays(15)->toDateString(),
            ],
            [
                'hr_user_id'        => 2,
                'category_id'       => 5, // Marketing & Sales
                'title'             => 'Content Creator Intern',
                'description'       => 'Kami mencari mahasiswa aktif atau fresh graduate kreatif untuk magang sebagai Content Creator. Anda akan bertugas membuat konten foto, video pendek, dan mengelola media sosial perusahaan.',
                'requirements'      => 'Pendidikan minimal SMA/SMK atau kuliah aktif. Terbiasa menggunakan CapCut, Canva, atau software editing sejenis. Aktif di media sosial seperti Instagram dan TikTok.',
                'benefits'          => 'Uang saku bulanan, sertifikat magang resmi, pendampingan mentor profesional.',
                'employment_type'   => 'internship',
                'location_type'     => 'hybrid',
                'location'          => 'Batam, Kepulauan Riau',
                'salary_min'        => 1500000.00,
                'salary_max'        => 2500000.00,
                'show_salary'       => true,
                'quota'             => 3,
                'age_min'           => 18,
                'age_max'           => 23,
                'passing_grade'     => 60,
                'applicant_count'   => 0,
                'status'            => 'open',
                'auto_close_method' => 'both',
                'deadline'          => $today->copy()->addDays(5)->toDateString(),
            ],
            [
                'hr_user_id'        => 1,
                'category_id'       => 5, // Marketing & Sales
                'title'             => 'Social Media Specialist',
                'description'       => 'Bertanggung jawab dalam merencanakan strategi pemasaran digital perusahaan, menyusun content calendar bulanan, menganalisis kinerja media sosial (engagement rate, reach), dan beriklan digital.',
                'requirements'      => 'S1 Marketing, Ilmu Komunikasi, atau sejenisnya. Memiliki pengalaman minimal 1 tahun di bidang sosial media marketing. Memahami Facebook Ads & Google Analytics.',
                'benefits'          => 'Gaji kompetitif, tunjangan internet, BPJS, peluang karir karyawan tetap.',
                'employment_type'   => 'full-time',
                'location_type'     => 'hybrid',
                'location'          => 'Batam, Kepulauan Riau',
                'salary_min'        => 4500000.00,
                'salary_max'        => 7000000.00,
                'show_salary'       => true,
                'quota'             => 1,
                'age_min'           => 20,
                'age_max'           => 28,
                'passing_grade'     => 70,
                'applicant_count'   => 0,
                'status'            => 'open',
                'auto_close_method' => 'both',
                'deadline'          => $today->copy()->addDays(12)->toDateString(),
            ]
        ];

        foreach ($jobs as $jobData) {
            JobPosting::create($jobData);
        }
    }
}
