-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2026 at 12:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `court_pulse`
--

-- --------------------------------------------------------

--
-- Table structure for table `advocate_profiles`
--

CREATE TABLE `advocate_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bar_council_number` varchar(255) NOT NULL,
  `enrollment_number` varchar(255) NOT NULL,
  `enrollment_date` date NOT NULL,
  `high_court` varchar(255) NOT NULL,
  `practice_areas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`practice_areas`)),
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `bio` text DEFAULT NULL,
  `office_address` varchar(255) DEFAULT NULL,
  `office_phone` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verified_at` timestamp NULL DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advocate_profiles`
--

INSERT INTO `advocate_profiles` (`id`, `user_id`, `bar_council_number`, `enrollment_number`, `enrollment_date`, `high_court`, `practice_areas`, `experience_years`, `bio`, `office_address`, `office_phone`, `website`, `is_verified`, `verified_at`, `verified_by`, `created_at`, `updated_at`) VALUES
(1, 4, '123456', '12345678', '2026-03-09', 'Allabhbad', '[\"Criminal Law\",\"Civil Law\"]', 2, 'nothing', 'Pratapgarh', '7080032118', NULL, 0, NULL, NULL, '2026-03-09 05:08:12', '2026-03-09 05:08:12');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ca_profiles`
--

CREATE TABLE `ca_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `membership_number` varchar(255) NOT NULL,
  `icai_region` varchar(255) NOT NULL,
  `membership_date` date NOT NULL,
  `specializations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`specializations`)),
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `bio` text DEFAULT NULL,
  `firm_name` varchar(255) DEFAULT NULL,
  `office_address` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verified_at` timestamp NULL DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clerk_profiles`
--

CREATE TABLE `clerk_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `clerk_id_number` varchar(255) NOT NULL,
  `court_name` varchar(255) NOT NULL,
  `court_city` varchar(255) NOT NULL,
  `court_state` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `experience_years` int(11) NOT NULL DEFAULT 0,
  `bio` text DEFAULT NULL,
  `advocate_contacts` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`advocate_contacts`)),
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verified_at` timestamp NULL DEFAULT NULL,
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courts`
--

CREATE TABLE `courts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('supreme','high','district','session','civil','criminal','family','consumer','tribunal') NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courts`
--

INSERT INTO `courts` (`id`, `name`, `type`, `city`, `state`, `pincode`, `address`, `phone`, `email`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Pratapgarh High Court', 'high', 'Pratapgarh', 'Utter Pradesh', '230503', 'Pratapgarh', '7080032118', 'digiempsachin@gmail.com', 1, 2, '2026-03-08 22:40:41', '2026-03-08 22:40:41'),
(2, 'Lucknow', 'supreme', 'Thane', 'Maharashtra', '230503', 'test', '7080032118', 'digiempsachin@gmail.com', 1, 2, '2026-03-08 23:07:26', '2026-03-08 23:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` enum('bar_council_certificate','enrollment_certificate','degree_certificate','aadhar_card','pan_card','photo_id','practice_certificate','clerk_appointment_letter','court_id_card','service_certificate','ca_membership_certificate','icai_certificate','firm_registration','profile_photo','other') NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `user_id`, `document_type`, `file_name`, `file_path`, `file_size`, `mime_type`, `status`, `rejection_reason`, `reviewed_by`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'profile_photo', 'WhatsApp Image 2025-07-30 at 10.23.07_aaa61cab.jpg', 'documents/3/cfntueMM5aI3waReolUWEWPcFlN3g7qht31CYtjN.jpg', '96735', 'image/jpeg', 'approved', NULL, 2, '2026-03-09 00:09:09', '2026-03-08 23:57:17', '2026-03-09 00:09:09'),
(2, 4, 'profile_photo', 'test.jpg', 'documents/4/GDIoXgBdROijoxT8e6Zdn5Fc3ZdevbsxwpXtr6Mf.jpg', '1126940', 'image/jpeg', 'approved', NULL, 2, '2026-03-09 07:01:35', '2026-03-09 06:58:56', '2026-03-09 07:01:35'),
(3, 6, 'profile_photo', 'logo.jpeg', 'documents/6/5xIsqM6tWz354xwdCVOZv3sUkD8lYJ8kXSIaG1Ch.jpg', '21256', 'image/jpeg', 'pending', NULL, NULL, NULL, '2026-03-10 01:55:56', '2026-03-10 01:55:56'),
(4, 6, 'court_id_card', 'One View by AKTU SDC Team.pdf', 'documents/6/yCy1ySoNGcu0dldLRTC8l3xWyIftaEVQGIIn8G7e.pdf', '297890', 'application/pdf', 'approved', NULL, 2, '2026-03-10 04:06:19', '2026-03-10 01:59:47', '2026-03-10 04:06:19');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `given_by` bigint(20) UNSIGNED NOT NULL,
  `given_to` bigint(20) UNSIGNED NOT NULL,
  `role_type` enum('advocate','clerk','ca') NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `is_compulsory` tinyint(1) NOT NULL DEFAULT 0,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `given_by`, `given_to`, `role_type`, `rating`, `comment`, `is_compulsory`, `is_anonymous`, `created_at`, `updated_at`) VALUES
(1, 6, 3, 'advocate', 5, 'You are tha best', 1, 1, '2026-03-06 10:28:10', '2026-03-06 10:28:10'),
(3, 6, 4, 'advocate', 5, 'test', 1, 0, '2026-03-09 04:01:24', '2026-03-09 04:01:24'),
(4, 4, 6, 'clerk', 5, 'test', 0, 0, '2026-03-09 06:53:33', '2026-03-09 06:53:33'),
(5, 5, 3, 'advocate', 5, 'test User', 0, 0, '2026-03-12 03:44:53', '2026-03-12 03:44:53'),
(6, 5, 6, 'clerk', 5, 'Test Guest', 0, 0, '2026-03-12 04:03:47', '2026-03-12 04:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_06_092122_create_permission_tables', 1),
(5, '2026_03_06_093913_modify_users_table', 1),
(6, '2026_03_06_094047_create_advocate_profiles_table', 1),
(7, '2026_03_06_094153_create_clerk_profiles_table', 1),
(8, '2026_03_06_094248_create_ca_profiles_table', 1),
(9, '2026_03_06_094343_create_documents_table', 1),
(10, '2026_03_06_094433_create_courts_table', 1),
(11, '2026_03_06_094516_create_feedbacks_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 6),
(5, 'App\\Models\\User', 7),
(6, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('sachin.verma.dev12002@gmail.com', '$2y$12$Z71WZCH.tX455nwwb4ZRjuzfAFvLVpptAGDGNNhJ4j81/bQMg7YZe', '2026-03-16 00:03:29'),
('sachinve4@gmail.com', '$2y$12$EEhD9htuGe2KcCt1Fu65Z.SwMfh4D7JxMvmz6Ob6DC.Hh3crj5UFC', '2026-03-16 00:13:50');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view users', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(2, 'create users', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(3, 'edit users', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(4, 'delete users', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(5, 'verify users', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(6, 'reject users', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(7, 'view advocates', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(8, 'create advocate profile', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(9, 'edit advocate profile', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(10, 'delete advocate profile', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(11, 'search advocates', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(12, 'view clerks', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(13, 'create clerk profile', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(14, 'edit clerk profile', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(15, 'delete clerk profile', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(16, 'search clerks', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(17, 'view cas', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(18, 'create ca profile', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(19, 'edit ca profile', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(20, 'delete ca profile', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(21, 'search cas', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(22, 'upload documents', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(23, 'view own documents', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(24, 'view all documents', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(25, 'approve documents', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(26, 'reject documents', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(27, 'view courts', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(28, 'create courts', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(29, 'edit courts', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(30, 'delete courts', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(31, 'give feedback', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(32, 'view feedback', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(33, 'view all feedback', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(34, 'delete feedback', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(35, 'view admin dashboard', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(36, 'view advocate dashboard', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(37, 'view clerk dashboard', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(38, 'view guest dashboard', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(39, 'view ca dashboard', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(40, 'manage roles', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(41, 'manage permissions', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(42, 'assign roles', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(2, 'admin', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(3, 'advocate', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(4, 'clerk', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(5, 'ca', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46'),
(6, 'guest', 'web', '2026-03-06 04:25:46', '2026-03-06 04:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(7, 4),
(7, 5),
(7, 6),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(9, 3),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(11, 4),
(11, 5),
(11, 6),
(12, 1),
(12, 2),
(12, 3),
(12, 6),
(13, 1),
(13, 2),
(13, 4),
(14, 1),
(14, 2),
(14, 4),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(16, 3),
(16, 6),
(17, 1),
(17, 2),
(18, 1),
(18, 2),
(18, 5),
(19, 1),
(19, 2),
(19, 5),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(22, 1),
(22, 2),
(22, 3),
(22, 4),
(22, 5),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(23, 5),
(24, 1),
(24, 2),
(25, 1),
(25, 2),
(26, 1),
(26, 2),
(27, 1),
(27, 2),
(27, 3),
(27, 4),
(27, 5),
(27, 6),
(28, 1),
(28, 2),
(29, 1),
(29, 2),
(30, 1),
(30, 2),
(31, 1),
(31, 2),
(31, 3),
(31, 4),
(31, 5),
(31, 6),
(32, 1),
(32, 2),
(32, 3),
(32, 4),
(32, 5),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(36, 1),
(36, 2),
(36, 3),
(37, 1),
(37, 2),
(37, 4),
(38, 1),
(38, 2),
(38, 6),
(39, 1),
(39, 2),
(39, 5),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(42, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cf40vFYPqhSgW7jdUsIuT6ny9t7TVA93LXL2TwP0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2Mwa0g4ZWFNWU9kUDRpMUlBYURjbXJ5UVNQS0xJU1ZKNlhEUHN2cCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcmVzZXQtcGFzc3dvcmQvMzlmMDE1NTVjMDQ5MWQ2OTBkY2EwMzlkNDExY2NlZjI0NmVlNWEzZDRkMTA4OTY5NWNiODQwNjRhOWI3NTIzZT9lbWFpbD1zYWNoaW52ZTQlNDBnbWFpbC5jb20iO3M6NToicm91dGUiO3M6MTQ6InBhc3N3b3JkLnJlc2V0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1773639855),
('H6EideOmSpqrXCoLi5yqA1Zv32n8DtMgDFXQqxVS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTBJWFFhU01JME01YURzZkwwRWlvcmhHck9yMlRHbk8zMjY5Y0xKQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1773652642),
('wp5gvY2hxrsGthSTt1v9Qw1fgsx77niYR2dPlsKX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiYkJTejVFQzJsTTdOcUo2cnZHYUNwVWNRNFdKUmRzbWVEbklUM2tNZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1773651150);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('super_admin','admin','advocate','clerk','guest','ca') NOT NULL DEFAULT 'guest',
  `status` enum('pending','active','rejected') NOT NULL DEFAULT 'pending',
  `profile_photo` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`, `profile_photo`, `address`, `city`, `state`, `pincode`) VALUES
(1, 'Super Admin', 'superadmin@courtpulse.com', NULL, NULL, '$2y$12$tv8gBt6HdyHbV4oYdrBcReJygZOjNj6C/.xd/DBmO.5Vr9Tq89al.', NULL, '2026-03-06 04:25:47', '2026-03-06 04:25:47', 'super_admin', 'active', NULL, NULL, NULL, NULL, NULL),
(2, 'Court Admin', 'admin@courtpulse.com', NULL, NULL, '$2y$12$C/l2ILGZSuTC6QIcFGWrZ.0byI8JDXp4U86pvSmfW1XCIfRCyiDju', NULL, '2026-03-06 04:25:47', '2026-03-06 04:25:47', 'admin', 'active', NULL, NULL, NULL, NULL, NULL),
(3, 'Sachin Verma', 'sachinve4@gmail.com', '7080032118', NULL, '$2y$12$h8m26QYLvrH3MpsetVjNKurPX2cKI3aMb5AzHUlO32X2YvCJ0NWFm', NULL, '2026-03-06 07:44:17', '2026-03-06 07:46:47', 'advocate', 'active', NULL, NULL, NULL, NULL, NULL),
(4, 'Raj Kumar', 'sachin.verma.dev2002@gmail.com', '7080032118', NULL, '$2y$12$h8m26QYLvrH3MpsetVjNKurPX2cKI3aMb5AzHUlO32X2YvCJ0NWFm', NULL, '2026-03-06 08:03:41', '2026-03-09 05:08:12', 'advocate', 'active', NULL, 'Pratapgarh', 'PratapGarh', NULL, NULL),
(5, 'Rajesh kumar', 'pk@gmail.com', '7800060691', NULL, '$2y$12$5fPbY34Cs.ssKs7WNgfCtuT8zsp477Q3D5AA4B7mAdO.Jv7idOWY.', NULL, '2026-03-06 10:05:46', '2026-03-06 10:05:46', 'guest', 'active', NULL, NULL, NULL, NULL, NULL),
(6, 'Rahul Kumar', 'rahul@gmail.com', '6890976123', NULL, '$2y$12$Hm0Kyov/O2tw4bIFQ8qLkuzWqFEe1oz1nDiLCOuuyQRH8csRuGnCG', NULL, '2026-03-06 10:11:32', '2026-03-06 10:21:06', 'clerk', 'active', NULL, NULL, NULL, NULL, NULL),
(7, 'Kapil Verma', 'sachin.verma.dev12002@gmail.com', '1234567890', NULL, '$2y$12$j9Q9bfKMrEnfgwZoAyKwceteyKKs5bzTF8V3Y.mLVUHF5eSdyd8ES', NULL, '2026-03-06 10:41:56', '2026-03-06 10:41:56', 'ca', 'pending', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advocate_profiles`
--
ALTER TABLE `advocate_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `advocate_profiles_bar_council_number_unique` (`bar_council_number`),
  ADD UNIQUE KEY `advocate_profiles_enrollment_number_unique` (`enrollment_number`),
  ADD KEY `advocate_profiles_user_id_foreign` (`user_id`),
  ADD KEY `advocate_profiles_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `ca_profiles`
--
ALTER TABLE `ca_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ca_profiles_membership_number_unique` (`membership_number`),
  ADD KEY `ca_profiles_user_id_foreign` (`user_id`),
  ADD KEY `ca_profiles_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `clerk_profiles`
--
ALTER TABLE `clerk_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clerk_profiles_clerk_id_number_unique` (`clerk_id_number`),
  ADD KEY `clerk_profiles_user_id_foreign` (`user_id`),
  ADD KEY `clerk_profiles_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `courts`
--
ALTER TABLE `courts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courts_created_by_foreign` (`created_by`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`),
  ADD KEY `documents_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedbacks_given_by_foreign` (`given_by`),
  ADD KEY `feedbacks_given_to_foreign` (`given_to`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advocate_profiles`
--
ALTER TABLE `advocate_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ca_profiles`
--
ALTER TABLE `ca_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clerk_profiles`
--
ALTER TABLE `clerk_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courts`
--
ALTER TABLE `courts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advocate_profiles`
--
ALTER TABLE `advocate_profiles`
  ADD CONSTRAINT `advocate_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `advocate_profiles_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `ca_profiles`
--
ALTER TABLE `ca_profiles`
  ADD CONSTRAINT `ca_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ca_profiles_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `clerk_profiles`
--
ALTER TABLE `clerk_profiles`
  ADD CONSTRAINT `clerk_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `clerk_profiles_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `courts`
--
ALTER TABLE `courts`
  ADD CONSTRAINT `courts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_given_by_foreign` FOREIGN KEY (`given_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedbacks_given_to_foreign` FOREIGN KEY (`given_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
