-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 24, 2026 at 05:45 PM
-- Server version: 11.8.6-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u193610993_traceapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `AuditLogs`
--

CREATE TABLE `AuditLogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(100) NOT NULL,
  `entity_id` bigint(20) DEFAULT NULL,
  `meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_json`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `AuditLogs`
--

INSERT INTO `AuditLogs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `meta_json`, `ip_address`, `created_at`) VALUES
(1, 2, 'Logout', 'Users', 2, NULL, '127.0.0.1', '2026-04-22 19:03:07'),
(2, 2, 'SaveDraft', 'DailyReports', 1, NULL, '127.0.0.1', '2026-04-22 19:06:07'),
(3, 2, 'SubmitReport', 'DailyReports', 1, NULL, '127.0.0.1', '2026-04-22 19:06:14'),
(4, 2, 'Logout', 'Users', 2, NULL, '127.0.0.1', '2026-04-22 19:07:08'),
(5, 3, 'Logout', 'Users', 3, NULL, '127.0.0.1', '2026-04-22 19:08:39'),
(6, 1, 'Logout', 'Users', 1, NULL, '127.0.0.1', '2026-04-22 19:12:45'),
(7, 2, 'Logout', 'Users', 2, NULL, '127.0.0.1', '2026-04-22 19:19:48'),
(8, 1, 'Logout', 'Users', 1, NULL, '127.0.0.1', '2026-04-22 19:25:25'),
(9, 1, 'Logout', 'Users', 1, NULL, '127.0.0.1', '2026-04-22 19:26:27'),
(10, 1, 'Login', 'Users', 1, '{\"ip\": \"127.0.0.1\"}', '127.0.0.1', '2026-04-24 12:51:56'),
(11, 1, 'Logout', 'Users', 1, NULL, '127.0.0.1', '2026-04-24 14:48:46'),
(12, 1, 'Login', 'Users', 1, '{\"ip\": \"127.0.0.1\"}', '127.0.0.1', '2026-04-24 14:51:35'),
(13, 1, 'Logout', 'Users', 1, NULL, '127.0.0.1', '2026-04-24 15:52:58'),
(14, 3, 'Login', 'Users', 3, '{\"ip\": \"127.0.0.1\"}', '127.0.0.1', '2026-04-24 15:53:13'),
(15, 4, 'Register', 'Users', 4, '{\"username\":\"richy\"}', '140.213.138.7', '2026-04-24 16:22:19'),
(16, 4, 'Login', 'Users', 4, '{\"ip\":\"140.213.138.7\"}', '140.213.138.7', '2026-04-24 16:22:32'),
(17, 4, 'Login', 'Users', 4, '{\"ip\":\"140.213.138.7\"}', '140.213.138.7', '2026-04-24 16:32:43'),
(18, 4, 'Logout', 'Users', 4, NULL, '140.213.138.7', '2026-04-24 16:36:57'),
(19, 4, 'Login', 'Users', 4, '{\"ip\":\"140.213.138.7\"}', '140.213.138.7', '2026-04-24 16:37:11'),
(20, 4, 'Logout', 'Users', 4, NULL, '140.213.4.152', '2026-04-24 17:15:59'),
(21, 4, 'Login', 'Users', 4, '{\"ip\":\"140.213.4.152\"}', '140.213.4.152', '2026-04-24 17:16:10'),
(22, 4, 'Logout', 'Users', 4, NULL, '140.213.4.152', '2026-04-24 17:20:11'),
(23, 1, 'Login', 'Users', 1, '{\"ip\":\"140.213.4.152\"}', '140.213.4.152', '2026-04-24 17:20:31'),
(24, 1, 'Logout', 'Users', 1, NULL, '140.213.251.145', '2026-04-24 17:27:17'),
(25, 1, 'Login', 'Users', 1, '{\"ip\":\"140.213.251.145\"}', '140.213.251.145', '2026-04-24 17:28:22'),
(26, 1, 'Logout', 'Users', 1, NULL, '140.213.4.152', '2026-04-24 17:35:09'),
(27, 1, 'Login', 'Users', 1, '{\"ip\":\"140.213.251.145\"}', '140.213.251.145', '2026-04-24 17:36:03');

-- --------------------------------------------------------

--
-- Table structure for table `DailyReports`
--

CREATE TABLE `DailyReports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_code` varchar(40) NOT NULL,
  `report_date` date NOT NULL,
  `worker_user_id` bigint(20) UNSIGNED NOT NULL,
  `created_by_user_id` bigint(20) UNSIGNED NOT NULL,
  `weather_code` enum('Cerah','Hujan','Mendung') NOT NULL,
  `realization_summary` text NOT NULL,
  `whatsapp_summary` longtext DEFAULT NULL,
  `status` enum('Draft','Submitted') NOT NULL DEFAULT 'Draft',
  `submitted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `DailyReports`
--

INSERT INTO `DailyReports` (`id`, `report_code`, `report_date`, `worker_user_id`, `created_by_user_id`, `weather_code`, `realization_summary`, `whatsapp_summary`, `status`, `submitted_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'RPT-20260422190607-6A0931', '2026-04-22', 2, 2, 'Cerah', '2222222222222222222d', 'Nama Supervisor : I Made Adi\nTanggal : 22 April 2026\nUpdate Pekerja :\nLogistik : 222\n222 : 222\nPelaksana KSO : 22\nPelaksana Subkon / Vendor : 22\nGudang : 22\nLokasi Pekerjaan : Area Lanal - aa222222222222\nResume Realisasi Pekerjaan : 2222222222222222222d\nKondisi Cuaca : Cerah\nMaterial & Bahan : 222222222222222222\nAlat Berat :\n22 : 22\nAlat Kerja : 2222222222\nKendala Pekerjaan : Bentuk: 22222222 Penyebab: 222222 Dampak: 222222222 Catatan: 2222\nJika Ada Lembur : 18:00 - 24:00\nRencana Pekerjaan Esok : 2222222222222222', 'Submitted', '2026-04-22 19:06:14', '2026-04-22 19:06:07', '2026-04-22 19:06:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `HeavyEquipmentCategories`
--

CREATE TABLE `HeavyEquipmentCategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `HeavyEquipmentCategories`
--

INSERT INTO `HeavyEquipmentCategories` (`id`, `name`, `slug`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dump Truck', 'dump-truck', 1, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(2, 'Excavator', 'excavator', 2, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(3, 'Bulldozer', 'bulldozer', 3, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(4, 'Loader', 'loader', 4, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(5, 'Vibroroller', 'vibroroller', 5, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(6, 'Hyab Crane', 'hyab-crane', 6, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(7, 'Crane', 'crane', 7, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(8, 'Boring Machine', 'boring-machine', 8, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `PasswordResets`
--

CREATE TABLE `PasswordResets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(160) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `RefreshTokens`
--

CREATE TABLE `RefreshTokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token_hash` char(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `revoked_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ReportHeavyEquipmentUsages`
--

CREATE TABLE `ReportHeavyEquipmentUsages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `heavy_equipment_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `equipment_label` varchar(120) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ReportHeavyEquipmentUsages`
--

INSERT INTO `ReportHeavyEquipmentUsages` (`id`, `daily_report_id`, `heavy_equipment_category_id`, `equipment_label`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '22', 22, '2026-04-22 19:06:07', '2026-04-22 19:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `ReportLocations`
--

CREATE TABLE `ReportLocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `current_location` varchar(255) NOT NULL,
  `area_code` varchar(50) NOT NULL,
  `area_label` varchar(120) NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ReportLocations`
--

INSERT INTO `ReportLocations` (`id`, `daily_report_id`, `current_location`, `area_code`, `area_label`, `reason`, `created_at`, `updated_at`) VALUES
(1, 1, 'aa222222222222', 'AreaLanal', 'Area Lanal', 'aa2222222222222', '2026-04-22 19:06:07', '2026-04-22 19:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `ReportMaterialSummaries`
--

CREATE TABLE `ReportMaterialSummaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `summary_text` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ReportMaterialSummaries`
--

INSERT INTO `ReportMaterialSummaries` (`id`, `daily_report_id`, `summary_text`, `created_at`, `updated_at`) VALUES
(1, 1, '222222222222222222', '2026-04-22 19:06:07', '2026-04-22 19:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `ReportObstacleSummaries`
--

CREATE TABLE `ReportObstacleSummaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `obstacle_shape` varchar(255) NOT NULL,
  `obstacle_cause` varchar(255) NOT NULL,
  `obstacle_impact` varchar(255) NOT NULL,
  `additional_note` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ReportObstacleSummaries`
--

INSERT INTO `ReportObstacleSummaries` (`id`, `daily_report_id`, `obstacle_shape`, `obstacle_cause`, `obstacle_impact`, `additional_note`, `created_at`, `updated_at`) VALUES
(1, 1, '22222222', '222222', '222222222', '2222', '2026-04-22 19:06:07', '2026-04-22 19:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `ReportOvertimes`
--

CREATE TABLE `ReportOvertimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `start_time` varchar(10) DEFAULT NULL,
  `end_time` varchar(10) DEFAULT NULL,
  `summary_text` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ReportOvertimes`
--

INSERT INTO `ReportOvertimes` (`id`, `daily_report_id`, `is_enabled`, `start_time`, `end_time`, `summary_text`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '18:00', '24:00', '22222222222222222222', '2026-04-22 19:06:07', '2026-04-22 19:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `ReportPhotos`
--

CREATE TABLE `ReportPhotos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_size` bigint(20) UNSIGNED NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ReportPhotos`
--

INSERT INTO `ReportPhotos` (`id`, `daily_report_id`, `file_name`, `file_path`, `mime_type`, `file_size`, `caption`, `sort_order`, `created_at`) VALUES
(1, 1, '1776884767_68fac2af484b8de76e6b.jpg', 'Uploads/Reports/1776884767_68fac2af484b8de76e6b.jpg', 'image/jpeg', 170395, NULL, 1, '2026-04-22 19:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `ReportTomorrowPlans`
--

CREATE TABLE `ReportTomorrowPlans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `summary_text` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ReportTomorrowPlans`
--

INSERT INTO `ReportTomorrowPlans` (`id`, `daily_report_id`, `summary_text`, `created_at`, `updated_at`) VALUES
(1, 1, '2222222222222222', '2026-04-22 19:06:07', '2026-04-22 19:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `ReportToolSummaries`
--

CREATE TABLE `ReportToolSummaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `summary_text` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ReportToolSummaries`
--

INSERT INTO `ReportToolSummaries` (`id`, `daily_report_id`, `summary_text`, `created_at`, `updated_at`) VALUES
(1, 1, '2222222222', '2026-04-22 19:06:07', '2026-04-22 19:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `ReportWorkerUpdates`
--

CREATE TABLE `ReportWorkerUpdates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `daily_report_id` bigint(20) UNSIGNED NOT NULL,
  `worker_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_label` varchar(120) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ReportWorkerUpdates`
--

INSERT INTO `ReportWorkerUpdates` (`id`, `daily_report_id`, `worker_category_id`, `category_label`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Pelaksana KSO', 22, '2026-04-22 19:06:07', '2026-04-22 19:06:07'),
(2, 1, 2, 'Pelaksana Subkon / Vendor', 22, '2026-04-22 19:06:07', '2026-04-22 19:06:07'),
(3, 1, 3, 'Gudang', 22, '2026-04-22 19:06:07', '2026-04-22 19:06:07'),
(4, 1, 4, 'Logistik', 222, '2026-04-22 19:06:07', '2026-04-22 19:06:07'),
(5, 1, NULL, '222', 222, '2026-04-22 19:06:07', '2026-04-22 19:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE `Roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Roles`
--

INSERT INTO `Roles` (`id`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'Akses penuh monitoring, user management, dan pelaporan.', '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(2, 'Supervisor', 'Supervisor / PIC / Pelaksana', 'User lapangan yang mengisi laporan harian.', '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(3, 'Manager', 'Manager', 'Akses rekap dan trend kemajuan pekerjaan.', '2026-04-22 20:04:09', '2026-04-22 20:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(160) NOT NULL,
  `username` varchar(60) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `profile_photo_path` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `role_id`, `full_name`, `email`, `username`, `phone`, `profile_photo_path`, `password_hash`, `status`, `last_login_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Admin Teknik', 'admin@gmail.com', 'admin', '081200000001', 'Uploads/Profile/1777052088_85263f1472dbaf504bb9.jpg', '$2y$10$RqyUoBLF/fB6LGZwQiiBAuu7uV9.DZa/CQ0YnaRH0fsPxVm0X0tSy', 'Active', '2026-04-24 17:36:03', '2026-04-22 20:04:09', '2026-04-24 17:36:03', NULL),
(2, 2, 'I Made Adi', 'supervisor@gmail.com', 'supervisor', '081200000002', NULL, '$2y$10$RqyUoBLF/fB6LGZwQiiBAuu7uV9.DZa/CQ0YnaRH0fsPxVm0X0tSy', 'Active', '2026-04-22 19:12:49', '2026-04-22 20:04:09', '2026-04-24 15:52:51', NULL),
(3, 3, 'Manager Proyek', 'manager@gmail.com', 'manager', '081200000003', NULL, '$2y$10$RqyUoBLF/fB6LGZwQiiBAuu7uV9.DZa/CQ0YnaRH0fsPxVm0X0tSy', 'Active', '2026-04-24 15:53:13', '2026-04-22 20:04:09', '2026-04-24 15:53:13', NULL),
(4, 2, 'Richy Johannes', 'richy@gmail.com', 'richy', '081573635143', 'Uploads/Profile/1777051018_f7d8508560eb688a87c0.jpg', '$2y$10$RqyUoBLF/fB6LGZwQiiBAuu7uV9.DZa/CQ0YnaRH0fsPxVm0X0tSy', 'Active', '2026-04-24 17:16:10', '2026-04-24 16:22:19', '2026-04-24 17:36:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `UserSessions`
--

CREATE TABLE `UserSessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(128) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `last_activity_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `UserSessions`
--

INSERT INTO `UserSessions` (`id`, `user_id`, `session_id`, `ip_address`, `user_agent`, `last_activity_at`, `created_at`, `updated_at`) VALUES
(1, 1, '1a5f8cd0309bb81ef8a30b0633a12400', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 12:51:56', '2026-04-24 12:51:56', '2026-04-24 12:51:56'),
(2, 1, 'f648c8f0f806ac6d4e74708658f19180', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 14:51:35', '2026-04-24 14:51:35', '2026-04-24 14:51:35'),
(3, 3, '9b9339229cea99517209875b8c1840a8', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 15:53:13', '2026-04-24 15:53:13', '2026-04-24 15:53:13'),
(4, 4, '34e11e8cc9dc46759f72b238fdbfe9ff', '140.213.138.7', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:150.0) Gecko/20100101 Firefox/150.0', '2026-04-24 16:22:32', '2026-04-24 16:22:32', '2026-04-24 16:22:32'),
(6, 4, '33093bbac370a12c565dc3d736e958c9', '140.213.138.7', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '2026-04-24 16:37:11', '2026-04-24 16:37:11', '2026-04-24 16:37:11'),
(8, 1, '0f14949c6b57c172cf41418a20b70240', '140.213.4.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '2026-04-24 17:20:31', '2026-04-24 17:20:31', '2026-04-24 17:20:31'),
(10, 1, '783683e4468a9dfe22874474a4632ba0', '140.213.251.145', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '2026-04-24 17:36:03', '2026-04-24 17:36:03', '2026-04-24 17:36:03');

-- --------------------------------------------------------

--
-- Table structure for table `WorkerCategories`
--

CREATE TABLE `WorkerCategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `WorkerCategories`
--

INSERT INTO `WorkerCategories` (`id`, `name`, `slug`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Pelaksana KSO', 'pelaksana-kso', 1, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(2, 'Pelaksana Subkon / Vendor', 'pelaksana-subkon-vendor', 2, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(3, 'Gudang', 'gudang', 3, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(4, 'Logistik', 'logistik', 4, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(5, 'Peralatan', 'peralatan', 5, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(6, 'HSE', 'hse', 6, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(7, 'QA / QC', 'qa-qc', 7, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(8, 'Survey', 'survey', 8, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(9, 'Mekanik & Elektrikal', 'mekanik-elektrikal', 9, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(10, 'Pekerja Subkon / Vendor', 'pekerja-subkon-vendor', 10, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(11, 'Pekerja Harian', 'pekerja-harian', 11, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09'),
(12, 'Tukang', 'tukang', 12, 1, '2026-04-22 20:04:09', '2026-04-22 20:04:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AuditLogs`
--
ALTER TABLE `AuditLogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_logs_user` (`user_id`),
  ADD KEY `idx_audit_logs_action` (`action`);

--
-- Indexes for table `DailyReports`
--
ALTER TABLE `DailyReports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_daily_reports_code` (`report_code`),
  ADD UNIQUE KEY `uniq_daily_reports_date_user` (`report_date`,`worker_user_id`),
  ADD KEY `idx_daily_reports_status` (`status`),
  ADD KEY `idx_daily_reports_worker` (`worker_user_id`),
  ADD KEY `fk_daily_reports_created_user` (`created_by_user_id`);

--
-- Indexes for table `HeavyEquipmentCategories`
--
ALTER TABLE `HeavyEquipmentCategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_heavy_categories_slug` (`slug`);

--
-- Indexes for table `PasswordResets`
--
ALTER TABLE `PasswordResets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_password_resets_email` (`email`);

--
-- Indexes for table `RefreshTokens`
--
ALTER TABLE `RefreshTokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_refresh_tokens_hash` (`token_hash`),
  ADD KEY `idx_refresh_tokens_user` (`user_id`);

--
-- Indexes for table `ReportHeavyEquipmentUsages`
--
ALTER TABLE `ReportHeavyEquipmentUsages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_report_heavy_usage_report` (`daily_report_id`),
  ADD KEY `idx_report_heavy_usage_category` (`heavy_equipment_category_id`);

--
-- Indexes for table `ReportLocations`
--
ALTER TABLE `ReportLocations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_report_locations_report` (`daily_report_id`);

--
-- Indexes for table `ReportMaterialSummaries`
--
ALTER TABLE `ReportMaterialSummaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_report_material_report` (`daily_report_id`);

--
-- Indexes for table `ReportObstacleSummaries`
--
ALTER TABLE `ReportObstacleSummaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_report_obstacle_report` (`daily_report_id`);

--
-- Indexes for table `ReportOvertimes`
--
ALTER TABLE `ReportOvertimes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_report_overtime_report` (`daily_report_id`);

--
-- Indexes for table `ReportPhotos`
--
ALTER TABLE `ReportPhotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_report_photos_report` (`daily_report_id`);

--
-- Indexes for table `ReportTomorrowPlans`
--
ALTER TABLE `ReportTomorrowPlans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_report_tomorrow_report` (`daily_report_id`);

--
-- Indexes for table `ReportToolSummaries`
--
ALTER TABLE `ReportToolSummaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_report_tool_report` (`daily_report_id`);

--
-- Indexes for table `ReportWorkerUpdates`
--
ALTER TABLE `ReportWorkerUpdates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_report_worker_updates_report` (`daily_report_id`),
  ADD KEY `idx_report_worker_updates_category` (`worker_category_id`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_roles_code` (`code`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_users_email` (`email`),
  ADD UNIQUE KEY `uniq_users_username` (`username`),
  ADD KEY `idx_users_role` (`role_id`),
  ADD KEY `idx_users_status` (`status`);

--
-- Indexes for table `UserSessions`
--
ALTER TABLE `UserSessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_user_sessions_session` (`session_id`),
  ADD KEY `idx_user_sessions_user` (`user_id`);

--
-- Indexes for table `WorkerCategories`
--
ALTER TABLE `WorkerCategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_worker_categories_slug` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AuditLogs`
--
ALTER TABLE `AuditLogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `DailyReports`
--
ALTER TABLE `DailyReports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `HeavyEquipmentCategories`
--
ALTER TABLE `HeavyEquipmentCategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `PasswordResets`
--
ALTER TABLE `PasswordResets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `RefreshTokens`
--
ALTER TABLE `RefreshTokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ReportHeavyEquipmentUsages`
--
ALTER TABLE `ReportHeavyEquipmentUsages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ReportLocations`
--
ALTER TABLE `ReportLocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ReportMaterialSummaries`
--
ALTER TABLE `ReportMaterialSummaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ReportObstacleSummaries`
--
ALTER TABLE `ReportObstacleSummaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ReportOvertimes`
--
ALTER TABLE `ReportOvertimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ReportPhotos`
--
ALTER TABLE `ReportPhotos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ReportTomorrowPlans`
--
ALTER TABLE `ReportTomorrowPlans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ReportToolSummaries`
--
ALTER TABLE `ReportToolSummaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ReportWorkerUpdates`
--
ALTER TABLE `ReportWorkerUpdates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Roles`
--
ALTER TABLE `Roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `UserSessions`
--
ALTER TABLE `UserSessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `WorkerCategories`
--
ALTER TABLE `WorkerCategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AuditLogs`
--
ALTER TABLE `AuditLogs`
  ADD CONSTRAINT `fk_audit_logs_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `DailyReports`
--
ALTER TABLE `DailyReports`
  ADD CONSTRAINT `fk_daily_reports_created_user` FOREIGN KEY (`created_by_user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `fk_daily_reports_worker_user` FOREIGN KEY (`worker_user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `RefreshTokens`
--
ALTER TABLE `RefreshTokens`
  ADD CONSTRAINT `fk_refresh_tokens_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ReportHeavyEquipmentUsages`
--
ALTER TABLE `ReportHeavyEquipmentUsages`
  ADD CONSTRAINT `fk_report_heavy_usage_category` FOREIGN KEY (`heavy_equipment_category_id`) REFERENCES `HeavyEquipmentCategories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_report_heavy_usage_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ReportLocations`
--
ALTER TABLE `ReportLocations`
  ADD CONSTRAINT `fk_report_locations_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ReportMaterialSummaries`
--
ALTER TABLE `ReportMaterialSummaries`
  ADD CONSTRAINT `fk_report_material_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ReportObstacleSummaries`
--
ALTER TABLE `ReportObstacleSummaries`
  ADD CONSTRAINT `fk_report_obstacle_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ReportOvertimes`
--
ALTER TABLE `ReportOvertimes`
  ADD CONSTRAINT `fk_report_overtime_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ReportPhotos`
--
ALTER TABLE `ReportPhotos`
  ADD CONSTRAINT `fk_report_photos_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ReportTomorrowPlans`
--
ALTER TABLE `ReportTomorrowPlans`
  ADD CONSTRAINT `fk_report_tomorrow_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ReportToolSummaries`
--
ALTER TABLE `ReportToolSummaries`
  ADD CONSTRAINT `fk_report_tool_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ReportWorkerUpdates`
--
ALTER TABLE `ReportWorkerUpdates`
  ADD CONSTRAINT `fk_report_worker_updates_category` FOREIGN KEY (`worker_category_id`) REFERENCES `WorkerCategories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_report_worker_updates_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`id`);

--
-- Constraints for table `UserSessions`
--
ALTER TABLE `UserSessions`
  ADD CONSTRAINT `fk_user_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
