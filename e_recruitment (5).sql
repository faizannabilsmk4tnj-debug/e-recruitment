-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2026 at 04:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_recruitment`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant_cvs`
--

CREATE TABLE `applicant_cvs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `template_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `cv_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`cv_data`)),
  `pdf_url` varchar(500) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicant_cvs`
--

INSERT INTO `applicant_cvs` (`id`, `user_id`, `template_id`, `title`, `cv_data`, `pdf_url`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'CV Utama Budi Santoso', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(2, 4, 1, 'CV Utama Sari Dewi', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(3, 5, 1, 'CV Utama Ahmad Rizki', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(4, 6, 1, 'CV Utama Mr. Frankie Schmidt DDS', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(5, 7, 1, 'CV Utama Milton Howe III', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(6, 8, 1, 'CV Utama Hattie Gerlach DDS', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(7, 9, 1, 'CV Utama Madeline Pollich', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(8, 10, 1, 'CV Utama Margot Goyette', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(9, 11, 1, 'CV Utama Lucile Bogan V', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(10, 12, 1, 'CV Utama Alf Schroeder', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(11, 13, 1, 'CV Utama Jerrold Hirthe', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(12, 14, 1, 'CV Utama Betsy Deckow', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(13, 15, 1, 'CV Utama Prof. Reginald King', '{\"objective\":\"Mencari posisi yang sesuai dengan kemampuan saya.\",\"sections\":[\"experience\",\"education\",\"skills\"]}', NULL, 1, '2026-03-25 18:18:14', '2026-03-25 18:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_skills`
--

CREATE TABLE `applicant_skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `category` enum('technical','soft','language') NOT NULL,
  `level` enum('beginner','intermediate','expert') NOT NULL,
  `cert_name` varchar(200) DEFAULT NULL,
  `cert_url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicant_skills`
--

INSERT INTO `applicant_skills` (`id`, `user_id`, `skill_name`, `category`, `level`, `cert_name`, `cert_url`, `created_at`) VALUES
(1, 3, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:13'),
(2, 3, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:13'),
(3, 3, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:13'),
(4, 4, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:13'),
(5, 4, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:13'),
(6, 4, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:13'),
(7, 5, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:13'),
(8, 5, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:13'),
(9, 5, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:13'),
(10, 6, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:13'),
(11, 6, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:13'),
(12, 6, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:13'),
(13, 7, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(14, 7, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(15, 7, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:14'),
(16, 8, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(17, 8, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(18, 8, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:14'),
(19, 9, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(20, 9, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(21, 9, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:14'),
(22, 10, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(23, 10, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(24, 10, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:14'),
(25, 11, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(26, 11, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(27, 11, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:14'),
(28, 12, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(29, 12, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(30, 12, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:14'),
(31, 13, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(32, 13, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(33, 13, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:14'),
(34, 14, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(35, 14, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(36, 14, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:14'),
(37, 15, 'Microsoft Office', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(38, 15, 'Komunikasi', 'soft', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(39, 15, 'Bahasa Inggris', 'language', 'intermediate', NULL, NULL, '2026-03-26 01:18:14'),
(40, 3, 'Laravel', 'technical', 'expert', NULL, NULL, '2026-03-26 01:18:14'),
(41, 3, 'MySQL', 'technical', 'intermediate', NULL, NULL, '2026-03-26 01:18:14'),
(42, 3, 'JavaScript', 'technical', 'intermediate', NULL, NULL, '2026-03-26 01:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `cv_id` bigint(20) UNSIGNED NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `resume_url` varchar(500) DEFAULT NULL,
  `status` enum('applied','reviewed','shortlisted','interview','offered','rejected','withdrawn') NOT NULL DEFAULT 'applied',
  `hr_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `job_id`, `cv_id`, `cover_letter`, `resume_url`, `status`, `hr_notes`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 'Saya sangat tertarik dengan posisi Backend Developer di PT Eco Green. Dengan pengalaman 2 tahun menggunakan Laravel dan MySQL, saya yakin dapat berkontribusi maksimal.', NULL, 'shortlisted', NULL, '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(2, 3, 2, 1, 'Saya juga memiliki kemampuan frontend dan ingin mengembangkan keahlian di bidang ini.', NULL, 'applied', NULL, '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(3, 4, 3, 2, 'Dengan pengalaman 3 tahun di bidang akuntansi, saya siap memberikan kontribusi terbaik untuk PT Eco Green Oleochemicals.', NULL, 'interview', NULL, '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(4, 5, 1, 3, 'Saya ingin bergabung dan berkembang bersama tim IT PT Eco Green.', NULL, 'rejected', 'Pengalaman kurang dari yang dibutuhkan. Bisa dipertimbangkan untuk posisi junior di masa depan.', '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(5, 5, 5, 3, 'Saya bersedia bekerja dalam sistem shift dan siap bekerja keras.', NULL, 'applied', NULL, '2026-03-25 18:18:14', '2026-03-25 18:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `application_status_logs`
--

CREATE TABLE `application_status_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `changed_by` bigint(20) UNSIGNED NOT NULL,
  `old_status` enum('applied','reviewed','shortlisted','interview','offered','rejected','withdrawn') NOT NULL,
  `new_status` enum('applied','reviewed','shortlisted','interview','offered','rejected','withdrawn') NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_status_logs`
--

INSERT INTO `application_status_logs` (`id`, `application_id`, `changed_by`, `old_status`, `new_status`, `reason`, `created_at`) VALUES
(1, 1, 1, 'applied', 'reviewed', 'CV dan pengalaman sesuai dengan kebutuhan posisi.', '2026-03-26 01:18:14'),
(2, 1, 1, 'reviewed', 'shortlisted', 'Kandidat masuk dalam daftar shortlist untuk wawancara.', '2026-03-26 01:18:14'),
(3, 3, 1, 'applied', 'reviewed', 'Dokumen lengkap dan pengalaman relevan.', '2026-03-26 01:18:14'),
(4, 3, 1, 'reviewed', 'shortlisted', 'Kandidat terbaik dari semua pelamar.', '2026-03-26 01:18:14'),
(5, 3, 1, 'shortlisted', 'interview', 'Dijadwalkan wawancara tahap pertama.', '2026-03-26 01:18:14'),
(6, 4, 1, 'applied', 'reviewed', 'Dokumen sudah ditinjau.', '2026-03-26 01:18:14'),
(7, 4, 1, 'reviewed', 'rejected', 'Kualifikasi belum memenuhi standar minimum posisi ini.', '2026-03-26 01:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `cv_templates`
--

CREATE TABLE `cv_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `preview_url` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cv_templates`
--

INSERT INTO `cv_templates` (`id`, `name`, `preview_url`, `is_active`, `created_at`) VALUES
(1, 'Modern Professional', NULL, 1, '2026-03-26 01:18:13'),
(2, 'Classic Elegant', NULL, 1, '2026-03-26 01:18:13'),
(3, 'Fresh Graduate', NULL, 1, '2026-03-26 01:18:13'),
(4, 'Creative Portfolio', NULL, 0, '2026-03-26 01:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE `educations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `institution` varchar(200) NOT NULL,
  `degree` enum('SMA','D3','S1','S2','S3') NOT NULL,
  `major` varchar(150) DEFAULT NULL,
  `gpa` decimal(3,2) DEFAULT NULL,
  `start_year` year(4) NOT NULL,
  `end_year` year(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `user_id`, `institution`, `degree`, `major`, `gpa`, `start_year`, `end_year`, `created_at`) VALUES
(1, 3, 'Universitas Riau', 'S1', 'Teknik Informatika', 3.75, '2019', '2023', '2026-03-26 01:18:13'),
(2, 4, 'Politeknik Negeri Batam', 'D3', 'Akuntansi', 3.12, '2019', '2023', '2026-03-26 01:18:13'),
(3, 5, 'Universitas Riau', 'S1', 'Teknik Industri', 3.07, '2019', '2023', '2026-03-26 01:18:13'),
(4, 6, 'Universitas Indonesia', 'D3', 'Teknik Industri', 3.54, '2019', '2023', '2026-03-26 01:18:13'),
(5, 7, 'Universitas Indonesia', 'S1', 'Teknik Industri', 3.06, '2019', '2023', '2026-03-26 01:18:14'),
(6, 8, 'Universitas Riau', 'D3', 'Sistem Informasi', 3.78, '2019', '2023', '2026-03-26 01:18:14'),
(7, 9, 'Universitas Riau', 'D3', 'Akuntansi', 3.08, '2019', '2023', '2026-03-26 01:18:14'),
(8, 10, 'Universitas Putera Batam', 'D3', 'Sistem Informasi', 3.74, '2019', '2023', '2026-03-26 01:18:14'),
(9, 11, 'Universitas Riau', 'S1', 'Sistem Informasi', 3.29, '2019', '2023', '2026-03-26 01:18:14'),
(10, 12, 'Politeknik Negeri Batam', 'D3', 'Teknik Industri', 3.39, '2019', '2023', '2026-03-26 01:18:14'),
(11, 13, 'Universitas Riau', 'D3', 'Manajemen', 3.91, '2019', '2023', '2026-03-26 01:18:14'),
(12, 14, 'Politeknik Negeri Batam', 'D3', 'Sistem Informasi', 3.55, '2019', '2023', '2026-03-26 01:18:14'),
(13, 15, 'Universitas Indonesia', 'S1', 'Akuntansi', 3.07, '2019', '2023', '2026-03-26 01:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `interviews`
--

CREATE TABLE `interviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_by` bigint(20) UNSIGNED NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `duration_minutes` int(10) UNSIGNED NOT NULL DEFAULT 60,
  `interview_type` enum('online','offline','phone') NOT NULL,
  `location_or_link` varchar(500) DEFAULT NULL,
  `status` enum('scheduled','completed','cancelled','rescheduled') NOT NULL DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interviews`
--

INSERT INTO `interviews` (`id`, `application_id`, `scheduled_by`, `scheduled_at`, `duration_minutes`, `interview_type`, `location_or_link`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2026-03-29 10:00:00', 60, 'online', 'https://meet.google.com/eco-green-interview', 'scheduled', 'Mohon hadir 5 menit sebelum jadwal. Siapkan dokumen pendukung.', '2026-03-25 18:18:14', '2026-03-25 18:18:14'),
(2, 3, 1, '2026-03-19 14:00:00', 45, 'offline', 'Kantor PT Eco Green, Gedung A Lantai 2, Batam', 'completed', 'Wawancara awal untuk mengenal kandidat.', '2026-03-25 18:18:14', '2026-03-25 18:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `interview_results`
--

CREATE TABLE `interview_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `interview_id` bigint(20) UNSIGNED NOT NULL,
  `reviewed_by` bigint(20) UNSIGNED NOT NULL,
  `score` tinyint(3) UNSIGNED NOT NULL,
  `feedback` text DEFAULT NULL,
  `recommendation` enum('proceed','hold','reject') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interview_results`
--

INSERT INTO `interview_results` (`id`, `interview_id`, `reviewed_by`, `score`, `feedback`, `recommendation`, `created_at`) VALUES
(1, 2, 1, 82, 'Kandidat memiliki pemahaman akuntansi yang baik dan komunikasi yang lancar. Pengalaman relevan dengan kebutuhan posisi. Perlu dites lebih lanjut terkait kemampuan software akuntansi.', 'proceed', '2026-03-26 01:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `job_categories`
--

CREATE TABLE `job_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_categories`
--

INSERT INTO `job_categories` (`id`, `name`, `slug`, `icon`, `is_active`) VALUES
(1, 'IT & Engineering', 'it-engineering', NULL, 1),
(2, 'Finance & Accounting', 'finance-accounting', NULL, 1),
(3, 'Human Resources', 'human-resources', NULL, 1),
(4, 'Operations & Production', 'operations-production', NULL, 1),
(5, 'Marketing & Sales', 'marketing-sales', NULL, 1),
(6, 'Logistics & Supply Chain', 'logistics-supply-chain', NULL, 1),
(7, 'Quality Control', 'quality-control', NULL, 1),
(8, 'Research & Development', 'research-development', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hr_user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `benefits` text DEFAULT NULL,
  `employment_type` enum('full-time','part-time','contract','internship') NOT NULL,
  `location_type` enum('onsite','remote','hybrid') NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `salary_min` decimal(12,2) DEFAULT NULL,
  `salary_max` decimal(12,2) DEFAULT NULL,
  `show_salary` tinyint(1) NOT NULL DEFAULT 0,
  `quota` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `applicant_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('draft','open','closed','expired') NOT NULL DEFAULT 'draft',
  `deadline` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `hr_user_id`, `category_id`, `title`, `slug`, `description`, `requirements`, `benefits`, `employment_type`, `location_type`, `location`, `salary_min`, `salary_max`, `show_salary`, `quota`, `applicant_count`, `status`, `deadline`, `created_at`, `updated_at`, `closed_at`) VALUES
(1, 1, 1, 'Backend Developer Laravel', 'backend-developer-laravel', 'Kami mencari Backend Developer yang berpengalaman dalam membangun sistem API menggunakan Laravel. Kandidat akan bertanggung jawab dalam pengembangan dan pemeliharaan sistem rekrutmen digital perusahaan.', 'Minimal S1 Teknik Informatika atau bidang terkait. Pengalaman minimal 1 tahun dengan Laravel. Memahami konsep REST API, MySQL, dan Git.', 'Gaji kompetitif, BPJS Kesehatan & Ketenagakerjaan, bonus kinerja tahunan, lingkungan kerja kondusif.', 'full-time', 'onsite', 'Batam, Kepulauan Riau', 6000000.00, 10000000.00, 1, 2, 2, 'open', '2026-05-26', '2026-03-25 18:18:14', '2026-03-25 18:18:14', NULL),
(2, 1, 1, 'Frontend Developer', 'frontend-developer', 'Dibutuhkan Frontend Developer yang mampu membangun tampilan web yang responsif dan modern menggunakan HTML, CSS, dan JavaScript murni.', 'Minimal D3/S1 jurusan IT. Menguasai HTML5, CSS3, JavaScript. Memahami konsep AJAX dan REST API.', 'Gaji kompetitif, asuransi kesehatan, peluang pengembangan karir.', 'full-time', 'hybrid', 'Batam, Kepulauan Riau', 5000000.00, 8000000.00, 1, 1, 1, 'open', '2026-04-26', '2026-03-25 18:18:14', '2026-03-25 18:18:14', NULL),
(3, 2, 2, 'Staff Keuangan & Akuntansi', 'staff-keuangan-akuntansi', 'Mencari Staff Keuangan yang teliti dan berpengalaman dalam pengelolaan laporan keuangan perusahaan manufaktur.', 'S1 Akuntansi atau Keuangan. Pengalaman minimal 2 tahun. Menguasai software akuntansi dan Microsoft Excel.', 'Gaji sesuai pengalaman, BPJS, tunjangan makan dan transport.', 'full-time', 'onsite', 'Batam, Kepulauan Riau', 5000000.00, 7000000.00, 0, 1, 1, 'open', '2026-05-26', '2026-03-25 18:18:14', '2026-03-25 18:18:14', NULL),
(4, 2, 3, 'HR Recruitment Specialist', 'hr-recruitment-specialist', 'Posisi HR Recruitment untuk mendukung proses rekrutmen internal PT Eco Green Oleochemicals yang terus berkembang.', 'S1 Psikologi atau Manajemen SDM. Pengalaman di bidang rekrutmen minimal 1 tahun. Mampu mengoperasikan sistem HRIS.', 'Gaji kompetitif, pelatihan dan pengembangan karir, lingkungan kerja profesional.', 'full-time', 'onsite', 'Batam, Kepulauan Riau', 5000000.00, 8000000.00, 1, 1, 0, 'open', '2026-06-26', '2026-03-25 18:18:14', '2026-03-25 18:18:14', NULL),
(5, 1, 4, 'Operator Produksi', 'operator-produksi', 'Dibutuhkan Operator Produksi untuk lini produksi oleokimia. Kandidat akan bekerja dalam shift dan bertanggung jawab atas kelancaran proses produksi.', 'Minimal SMA/SMK sederajat. Bersedia bekerja shift. Memiliki pengalaman di industri manufaktur lebih diutamakan.', 'Gaji pokok + tunjangan shift, BPJS, makan siang gratis.', 'full-time', 'onsite', 'Batam, Kepulauan Riau', 3500000.00, 5000000.00, 1, 5, 1, 'open', '2026-04-16', '2026-03-25 18:18:14', '2026-03-25 18:18:14', NULL),
(6, 1, 1, 'IT Support Intern', 'it-support-intern', 'Program magang IT Support untuk mahasiswa aktif semester 5 ke atas. Akan mendapatkan pengalaman nyata dalam pengelolaan infrastruktur IT perusahaan.', 'Mahasiswa aktif D3/S1 jurusan IT. Memahami dasar jaringan komputer. Komunikatif dan cepat belajar.', 'Uang saku harian, sertifikat magang, peluang direkrut sebagai karyawan tetap.', 'internship', 'onsite', 'Batam, Kepulauan Riau', 1500000.00, 2500000.00, 1, 3, 0, 'open', '2026-04-26', '2026-03-25 18:18:14', '2026-03-25 18:18:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_search_logs`
--

CREATE TABLE `job_search_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `keyword` varchar(255) NOT NULL,
  `results_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_03_23_005345_create_users_table', 1),
(2, '2026_03_23_005402_create_user_profiles_table', 1),
(3, '2026_03_23_005411_create_password_reset_tokens_table', 1),
(4, '2026_03_23_005419_create_login_attempts_table', 1),
(5, '2026_03_23_031608_create_cv_templates_table', 1),
(6, '2026_03_23_031617_create_applicant_cvs_table', 1),
(7, '2026_03_23_031633_create_work_experiences_table', 1),
(8, '2026_03_23_031641_create_educations_table', 1),
(9, '2026_03_23_031655_create_applicant_skills_table', 1),
(10, '2026_03_23_034200_create_job_categories_table', 1),
(11, '2026_03_23_034208_create_job_postings_table', 1),
(12, '2026_03_23_034215_create_saved_jobs_table', 1),
(13, '2026_03_23_045623_create_applications_table', 1),
(14, '2026_03_23_045635_create_application_status_logs_table', 1),
(15, '2026_03_23_045647_create_job_search_logs_table', 1),
(16, '2026_03_23_084909_create_interviews_table', 1),
(17, '2026_03_23_084923_create_interview_results_table', 1),
(18, '2026_03_23_085224_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `data`, `read_at`, `created_at`) VALUES
(1, 3, 'status_changed', 'Lamaran Anda Diperbarui', 'Selamat! Lamaran Anda untuk posisi Backend Developer Laravel telah masuk tahap Shortlisted.', '{\"application_id\":1,\"new_status\":\"shortlisted\"}', NULL, '2026-03-26 01:18:14'),
(2, 3, 'application_received', 'Lamaran Berhasil Dikirim', 'Lamaran Anda untuk posisi Frontend Developer telah berhasil dikirim.', '{\"application_id\":2,\"job_title\":\"Frontend Developer\"}', '2026-03-25 18:18:14', '2026-03-26 01:18:14'),
(3, 4, 'interview_scheduled', 'Undangan Wawancara', 'Anda dijadwalkan untuk wawancara online pada 29 Mar 2026 pukul 10.00 WIB.', '{\"interview_id\":1,\"type\":\"online\",\"link\":\"https:\\/\\/meet.google.com\\/eco-green-interview\"}', NULL, '2026-03-26 01:18:14'),
(4, 4, 'status_changed', 'Lamaran Masuk Tahap Interview', 'Selamat! Lamaran Anda untuk posisi Staff Keuangan & Akuntansi telah masuk tahap Interview.', '{\"application_id\":3,\"new_status\":\"interview\"}', '2026-03-25 18:18:14', '2026-03-26 01:18:14'),
(5, 5, 'status_changed', 'Update Status Lamaran', 'Mohon maaf, lamaran Anda untuk posisi Backend Developer Laravel tidak dapat kami lanjutkan saat ini.', '{\"application_id\":4,\"new_status\":\"rejected\"}', NULL, '2026-03-26 01:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_jobs`
--

CREATE TABLE `saved_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('hr','applicant') NOT NULL DEFAULT 'applicant',
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `phone`, `is_active`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin HR Eco Green', 'hr@ecogreen.com', '$2y$12$DGSQvGS.utxL7ps37yDqyOR7r2LQvBwK0Wj4OEfFqDWJYUcnUJIkG', 'hr', '081234567890', 1, '2026-03-25 18:18:07', NULL, '2026-03-25 18:18:07', '2026-03-25 18:18:07'),
(2, 'Siti Rahayu HR', 'siti.hr@ecogreen.com', '$2y$12$ulGvi2ZJyb4mXMGGMhK5jeu9xyCQBaf8QsNXMLE6TRZKJJz2PcYhO', 'hr', '081234567891', 1, '2026-03-25 18:18:08', NULL, '2026-03-25 18:18:08', '2026-03-25 18:18:08'),
(3, 'Budi Santoso', 'budi@gmail.com', '$2y$12$6ANtCZjdrDB6k0i.sFNpG.pWkZln3k5BCDnCAIVWmKtzW8p4O2X/O', 'applicant', '082345678901', 1, '2026-03-25 18:18:08', NULL, '2026-03-25 18:18:08', '2026-03-25 18:18:08'),
(4, 'Sari Dewi', 'sari@gmail.com', '$2y$12$rs8/lZlKdTumH1mMOQWXUeta8UIBP2nSmbdztMrHXpMOgGceE2V3u', 'applicant', '083456789012', 1, '2026-03-25 18:18:08', NULL, '2026-03-25 18:18:08', '2026-03-25 18:18:08'),
(5, 'Ahmad Rizki', 'rizki@gmail.com', '$2y$12$20SWmhZERslSjI0A2wqQeuVjBjNXaPgBAypz.LJWIpow6vtosOwju', 'applicant', '084567890123', 1, '2026-03-25 18:18:09', NULL, '2026-03-25 18:18:09', '2026-03-25 18:18:09'),
(6, 'Mr. Frankie Schmidt DDS', 'beer.moses@example.com', '$2y$12$KCyDRX6NrkMRLmClEZvviuII4e2bYjhBERSQMOj9OPYSDTMbepz9y', 'applicant', '086418562669', 1, '2026-03-25 18:18:10', NULL, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(7, 'Milton Howe III', 'nstehr@example.net', '$2y$12$H2wqpEmFwxkhC9PPfRxnrunGy.XaPsf1diBd.TTMFJxvBhxaH8q8O', 'applicant', '087714302536', 1, '2026-03-25 18:18:10', NULL, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(8, 'Hattie Gerlach DDS', 'gparisian@example.org', '$2y$12$l8iqiJDH3hWa3S/DYLUck.IZeiuWlxa/6N22pU/6jBXteH16mS5/q', 'applicant', '084128395122', 1, '2026-03-25 18:18:11', NULL, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(9, 'Madeline Pollich', 'fletcher.von@example.net', '$2y$12$ShIw83xYrJiKnTnQTys.8OgtGHWTYIbqL90q3H/Wrowx.JJttrPuq', 'applicant', '088445356905', 1, '2026-03-25 18:18:11', NULL, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(10, 'Margot Goyette', 'parker.shaina@example.org', '$2y$12$LLzv1iVqPPV2QijEZLwJ5O4TBypFy2/w5CbhGQAffa5JqHe.evVz2', 'applicant', '082737189889', 1, '2026-03-25 18:18:12', NULL, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(11, 'Lucile Bogan V', 'estell82@example.org', '$2y$12$5w0oMZnN58U9bxED.NZii.XYloKxPtgd4d.SOFekl6bsGGUVjxuPy', 'applicant', '086932306804', 1, '2026-03-25 18:18:12', NULL, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(12, 'Alf Schroeder', 'pmccullough@example.net', '$2y$12$.8k4qG8VlCbAcPOBO5PR4OvIz44MygPGN3CYu56NN/Hls211atl42', 'applicant', '081026233517', 1, '2026-03-25 18:18:12', NULL, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(13, 'Jerrold Hirthe', 'ondricka.loraine@example.org', '$2y$12$Jv6o/NLoOE10pCcg40Q08.tw6pNrcj..ukdKXlSbnuHJIMfv8m7am', 'applicant', '087914322352', 1, '2026-03-25 18:18:13', NULL, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(14, 'Betsy Deckow', 'alysson.deckow@example.com', '$2y$12$pw7Py4tU830bjoyMSGDFDuZsx84LQA6Lsn4INOhezEM8Hvlq5CzDq', 'applicant', '086117054738', 1, '2026-03-25 18:18:13', NULL, '2026-03-25 18:18:13', '2026-03-25 18:18:13'),
(15, 'Prof. Reginald King', 'raynor.lavinia@example.com', '$2y$12$oqyZXgO1E3aQ2rAm9m5NQ.ufxc//cL6b.WBIQ6P6w4K6X3l30WTSS', 'applicant', '080824418455', 1, '2026-03-25 18:18:13', NULL, '2026-03-25 18:18:13', '2026-03-25 18:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bio` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `avatar_url` varchar(500) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `portfolio_url` varchar(500) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `bio`, `address`, `city`, `province`, `birth_date`, `gender`, `avatar_url`, `linkedin_url`, `portfolio_url`, `updated_at`) VALUES
(1, 1, NULL, NULL, 'Batam', 'Kepulauan Riau', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, NULL, NULL, 'Batam', 'Kepulauan Riau', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 'Fresh graduate S1 Teknik Informatika dengan pengalaman magang 6 bulan.', NULL, 'Batam', 'Kepulauan Riau', '2000-05-15', 'male', NULL, 'https://linkedin.com/in/budisantoso', NULL, NULL),
(4, 4, 'Profesional keuangan dengan pengalaman 3 tahun di bidang akuntansi.', NULL, 'Batam', 'Kepulauan Riau', '1998-08-22', 'female', NULL, NULL, NULL, NULL),
(5, 5, 'Backend developer dengan 2 tahun pengalaman Laravel dan MySQL.', NULL, 'Batam', 'Kepulauan Riau', '1999-03-10', 'male', NULL, NULL, NULL, NULL),
(6, 6, NULL, NULL, 'Jakarta', 'DKI Jakarta', NULL, 'female', NULL, NULL, NULL, NULL),
(7, 7, NULL, NULL, 'Tanjung Pinang', 'Jawa Timur', NULL, 'male', NULL, NULL, NULL, NULL),
(8, 8, NULL, NULL, 'Tanjung Pinang', 'Jawa Timur', NULL, 'male', NULL, NULL, NULL, NULL),
(9, 9, NULL, NULL, 'Batam', 'DKI Jakarta', NULL, 'male', NULL, NULL, NULL, NULL),
(10, 10, NULL, NULL, 'Batam', 'Kepulauan Riau', NULL, 'male', NULL, NULL, NULL, NULL),
(11, 11, NULL, NULL, 'Surabaya', 'DKI Jakarta', NULL, 'female', NULL, NULL, NULL, NULL),
(12, 12, NULL, NULL, 'Tanjung Pinang', 'DKI Jakarta', NULL, 'female', NULL, NULL, NULL, NULL),
(13, 13, NULL, NULL, 'Tanjung Pinang', 'DKI Jakarta', NULL, 'female', NULL, NULL, NULL, NULL),
(14, 14, NULL, NULL, 'Tanjung Pinang', 'Kepulauan Riau', NULL, 'male', NULL, NULL, NULL, NULL),
(15, 15, NULL, NULL, 'Batam', 'Jawa Timur', NULL, 'female', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_experiences`
--

CREATE TABLE `work_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `position` varchar(150) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_experiences`
--

INSERT INTO `work_experiences` (`id`, `user_id`, `company_name`, `position`, `start_date`, `end_date`, `is_current`, `description`, `created_at`) VALUES
(1, 3, 'Walker, Kris and Effertz', 'Teacher Assistant', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:13'),
(2, 3, 'Reinger Ltd', 'Talent Director', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:13'),
(3, 4, 'Oberbrunner-Kautzer', 'Pewter Caster', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:13'),
(4, 4, 'Swift-Rosenbaum', 'Private Sector Executive', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:13'),
(5, 5, 'Swift-Dach', 'Political Science Teacher', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:13'),
(6, 5, 'Moen LLC', 'Rail Transportation Worker', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:13'),
(7, 6, 'Dicki Ltd', 'Municipal Fire Fighting Supervisor', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:13'),
(8, 6, 'Kozey, Kutch and Glover', 'Business Development Manager', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:13'),
(9, 7, 'Stiedemann, Turner and VonRueden', 'Mechanical Equipment Sales Representative', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:13'),
(10, 7, 'Simonis-Daniel', 'Office and Administrative Support Worker', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:13'),
(11, 8, 'Thiel-O\'Reilly', 'Carver', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:14'),
(12, 8, 'Little-Torphy', 'Biological Technician', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:14'),
(13, 9, 'Reilly LLC', 'Marine Oiler', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:14'),
(14, 9, 'Herman-Kassulke', 'Manager Tactical Operations', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:14'),
(15, 10, 'Lindgren Inc', 'Range Manager', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:14'),
(16, 10, 'Moen-Gulgowski', 'Rolling Machine Setter', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:14'),
(17, 11, 'Hegmann, Schiller and Nikolaus', 'Financial Examiner', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:14'),
(18, 11, 'Kilback, Dach and Bergnaum', 'GED Teacher', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:14'),
(19, 12, 'Koss-Beatty', 'Hand Presser', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:14'),
(20, 12, 'Kiehn, Jast and Kuhic', 'Wellhead Pumper', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:14'),
(21, 13, 'Schuppe, Roob and Little', 'Postsecondary Teacher', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:14'),
(22, 13, 'Hilpert Group', 'Hunter and Trapper', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:14'),
(23, 14, 'Herman-Shields', 'Ticket Agent', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:14'),
(24, 14, 'DuBuque-Heidenreich', 'Sewing Machine Operator', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:14'),
(25, 15, 'Pouros-Parisian', 'Stonemason', '2022-01-01', '2023-12-31', 0, 'Bertanggung jawab dalam pengelolaan sistem dan pelaporan rutin.', '2026-03-26 01:18:14'),
(26, 15, 'Breitenberg-Krajcik', 'Mechanical Drafter', '2024-01-01', NULL, 1, 'Mengelola proses operasional dan koordinasi tim.', '2026-03-26 01:18:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant_cvs`
--
ALTER TABLE `applicant_cvs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_cvs_user_id_foreign` (`user_id`),
  ADD KEY `applicant_cvs_template_id_foreign` (`template_id`);

--
-- Indexes for table `applicant_skills`
--
ALTER TABLE `applicant_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_skills_user_id_foreign` (`user_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applications_user_id_job_id_unique` (`user_id`,`job_id`),
  ADD KEY `applications_job_id_foreign` (`job_id`),
  ADD KEY `applications_cv_id_foreign` (`cv_id`);

--
-- Indexes for table `application_status_logs`
--
ALTER TABLE `application_status_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_status_logs_application_id_foreign` (`application_id`),
  ADD KEY `application_status_logs_changed_by_foreign` (`changed_by`);

--
-- Indexes for table `cv_templates`
--
ALTER TABLE `cv_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `educations_user_id_foreign` (`user_id`);

--
-- Indexes for table `interviews`
--
ALTER TABLE `interviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interviews_application_id_foreign` (`application_id`),
  ADD KEY `interviews_scheduled_by_foreign` (`scheduled_by`);

--
-- Indexes for table `interview_results`
--
ALTER TABLE `interview_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `interview_results_interview_id_unique` (`interview_id`),
  ADD KEY `interview_results_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `job_categories`
--
ALTER TABLE `job_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_categories_slug_unique` (`slug`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_postings_slug_unique` (`slug`),
  ADD KEY `job_postings_hr_user_id_foreign` (`hr_user_id`),
  ADD KEY `job_postings_category_id_foreign` (`category_id`);
ALTER TABLE `job_postings` ADD FULLTEXT KEY `ft_job_search` (`title`,`description`,`requirements`,`benefits`);

--
-- Indexes for table `job_search_logs`
--
ALTER TABLE `job_search_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_search_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_read_at_index` (`user_id`,`read_at`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `password_reset_tokens_token_unique` (`token`),
  ADD KEY `password_reset_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `saved_jobs_user_id_job_id_unique` (`user_id`,`job_id`),
  ADD KEY `saved_jobs_job_id_foreign` (`job_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_profiles_user_id_unique` (`user_id`);

--
-- Indexes for table `work_experiences`
--
ALTER TABLE `work_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_experiences_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant_cvs`
--
ALTER TABLE `applicant_cvs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `applicant_skills`
--
ALTER TABLE `applicant_skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `application_status_logs`
--
ALTER TABLE `application_status_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cv_templates`
--
ALTER TABLE `cv_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `educations`
--
ALTER TABLE `educations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `interviews`
--
ALTER TABLE `interviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `interview_results`
--
ALTER TABLE `interview_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_categories`
--
ALTER TABLE `job_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `job_search_logs`
--
ALTER TABLE `job_search_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `work_experiences`
--
ALTER TABLE `work_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicant_cvs`
--
ALTER TABLE `applicant_cvs`
  ADD CONSTRAINT `applicant_cvs_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `cv_templates` (`id`),
  ADD CONSTRAINT `applicant_cvs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `applicant_skills`
--
ALTER TABLE `applicant_skills`
  ADD CONSTRAINT `applicant_skills_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_cv_id_foreign` FOREIGN KEY (`cv_id`) REFERENCES `applicant_cvs` (`id`),
  ADD CONSTRAINT `applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `job_postings` (`id`),
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `application_status_logs`
--
ALTER TABLE `application_status_logs`
  ADD CONSTRAINT `application_status_logs_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_status_logs_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `educations`
--
ALTER TABLE `educations`
  ADD CONSTRAINT `educations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interviews`
--
ALTER TABLE `interviews`
  ADD CONSTRAINT `interviews_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interviews_scheduled_by_foreign` FOREIGN KEY (`scheduled_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `interview_results`
--
ALTER TABLE `interview_results`
  ADD CONSTRAINT `interview_results_interview_id_foreign` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interview_results_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD CONSTRAINT `job_postings_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`id`),
  ADD CONSTRAINT `job_postings_hr_user_id_foreign` FOREIGN KEY (`hr_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `job_search_logs`
--
ALTER TABLE `job_search_logs`
  ADD CONSTRAINT `job_search_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD CONSTRAINT `saved_jobs_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `job_postings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_experiences`
--
ALTER TABLE `work_experiences`
  ADD CONSTRAINT `work_experiences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
