CREATE DATABASE IF NOT EXISTS `reportappdb`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `reportappdb`;

CREATE TABLE IF NOT EXISTS `Roles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(50) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `description` VARCHAR(255) NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_roles_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `role_id` BIGINT UNSIGNED NOT NULL,
    `full_name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(160) NOT NULL,
    `username` VARCHAR(60) NOT NULL,
    `phone` VARCHAR(30) NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `status` ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active',
    `last_login_at` DATETIME NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    `deleted_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_users_email` (`email`),
    UNIQUE KEY `uniq_users_username` (`username`),
    KEY `idx_users_role` (`role_id`),
    KEY `idx_users_status` (`status`),
    CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `PasswordResets` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(160) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `expires_at` DATETIME NOT NULL,
    `created_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    KEY `idx_password_resets_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `UserSessions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `session_id` VARCHAR(128) NOT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `last_activity_at` DATETIME NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_user_sessions_session` (`session_id`),
    KEY `idx_user_sessions_user` (`user_id`),
    CONSTRAINT `fk_user_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `RefreshTokens` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `token_hash` CHAR(64) NOT NULL,
    `expires_at` DATETIME NOT NULL,
    `revoked_at` DATETIME NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_refresh_tokens_hash` (`token_hash`),
    KEY `idx_refresh_tokens_user` (`user_id`),
    CONSTRAINT `fk_refresh_tokens_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `AuditLogs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NULL,
    `action` VARCHAR(100) NOT NULL,
    `entity_type` VARCHAR(100) NOT NULL,
    `entity_id` BIGINT NULL,
    `meta_json` JSON NULL,
    `ip_address` VARCHAR(45) NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_audit_logs_user` (`user_id`),
    KEY `idx_audit_logs_action` (`action`),
    CONSTRAINT `fk_audit_logs_user` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `WorkerCategories` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(120) NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_worker_categories_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `HeavyEquipmentCategories` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(120) NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_heavy_categories_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `DailyReports` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `report_code` VARCHAR(40) NOT NULL,
    `report_date` DATE NOT NULL,
    `worker_user_id` BIGINT UNSIGNED NOT NULL,
    `created_by_user_id` BIGINT UNSIGNED NOT NULL,
    `weather_code` ENUM('Cerah', 'Hujan', 'Mendung') NOT NULL,
    `realization_summary` TEXT NOT NULL,
    `whatsapp_summary` LONGTEXT NULL,
    `status` ENUM('Draft', 'Submitted') NOT NULL DEFAULT 'Draft',
    `submitted_at` DATETIME NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    `deleted_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_daily_reports_code` (`report_code`),
    UNIQUE KEY `uniq_daily_reports_date_user` (`report_date`, `worker_user_id`),
    KEY `idx_daily_reports_status` (`status`),
    KEY `idx_daily_reports_worker` (`worker_user_id`),
    CONSTRAINT `fk_daily_reports_worker_user` FOREIGN KEY (`worker_user_id`) REFERENCES `Users` (`id`),
    CONSTRAINT `fk_daily_reports_created_user` FOREIGN KEY (`created_by_user_id`) REFERENCES `Users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ReportLocations` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `daily_report_id` BIGINT UNSIGNED NOT NULL,
    `current_location` VARCHAR(255) NOT NULL,
    `area_code` VARCHAR(50) NOT NULL,
    `area_label` VARCHAR(120) NOT NULL,
    `reason` TEXT NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_report_locations_report` (`daily_report_id`),
    CONSTRAINT `fk_report_locations_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ReportPhotos` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `daily_report_id` BIGINT UNSIGNED NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `mime_type` VARCHAR(100) NOT NULL,
    `file_size` BIGINT UNSIGNED NOT NULL,
    `caption` VARCHAR(255) NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    KEY `idx_report_photos_report` (`daily_report_id`),
    CONSTRAINT `fk_report_photos_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ReportWorkerUpdates` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `daily_report_id` BIGINT UNSIGNED NOT NULL,
    `worker_category_id` BIGINT UNSIGNED NULL,
    `category_label` VARCHAR(120) NOT NULL,
    `quantity` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    KEY `idx_report_worker_updates_report` (`daily_report_id`),
    KEY `idx_report_worker_updates_category` (`worker_category_id`),
    CONSTRAINT `fk_report_worker_updates_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_report_worker_updates_category` FOREIGN KEY (`worker_category_id`) REFERENCES `WorkerCategories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ReportHeavyEquipmentUsages` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `daily_report_id` BIGINT UNSIGNED NOT NULL,
    `heavy_equipment_category_id` BIGINT UNSIGNED NULL,
    `equipment_label` VARCHAR(120) NOT NULL,
    `quantity` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    KEY `idx_report_heavy_usage_report` (`daily_report_id`),
    KEY `idx_report_heavy_usage_category` (`heavy_equipment_category_id`),
    CONSTRAINT `fk_report_heavy_usage_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_report_heavy_usage_category` FOREIGN KEY (`heavy_equipment_category_id`) REFERENCES `HeavyEquipmentCategories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ReportMaterialSummaries` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `daily_report_id` BIGINT UNSIGNED NOT NULL,
    `summary_text` TEXT NOT NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_report_material_report` (`daily_report_id`),
    CONSTRAINT `fk_report_material_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ReportToolSummaries` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `daily_report_id` BIGINT UNSIGNED NOT NULL,
    `summary_text` TEXT NOT NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_report_tool_report` (`daily_report_id`),
    CONSTRAINT `fk_report_tool_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ReportObstacleSummaries` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `daily_report_id` BIGINT UNSIGNED NOT NULL,
    `obstacle_shape` VARCHAR(255) NOT NULL,
    `obstacle_cause` VARCHAR(255) NOT NULL,
    `obstacle_impact` VARCHAR(255) NOT NULL,
    `additional_note` TEXT NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_report_obstacle_report` (`daily_report_id`),
    CONSTRAINT `fk_report_obstacle_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ReportTomorrowPlans` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `daily_report_id` BIGINT UNSIGNED NOT NULL,
    `summary_text` TEXT NOT NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_report_tomorrow_report` (`daily_report_id`),
    CONSTRAINT `fk_report_tomorrow_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ReportOvertimes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `daily_report_id` BIGINT UNSIGNED NOT NULL,
    `is_enabled` TINYINT(1) NOT NULL DEFAULT 0,
    `start_time` VARCHAR(10) NULL,
    `end_time` VARCHAR(10) NULL,
    `summary_text` VARCHAR(255) NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_report_overtime_report` (`daily_report_id`),
    CONSTRAINT `fk_report_overtime_report` FOREIGN KEY (`daily_report_id`) REFERENCES `DailyReports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Roles` (`id`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'Akses penuh monitoring, user management, dan pelaporan.', NOW(), NOW()),
(2, 'Supervisor', 'Supervisor / PIC / Pelaksana', 'User lapangan yang mengisi laporan harian.', NOW(), NOW()),
(3, 'Manager', 'Manager', 'Akses rekap dan trend kemajuan pekerjaan.', NOW(), NOW())
ON DUPLICATE KEY UPDATE
`name` = VALUES(`name`),
`description` = VALUES(`description`),
`updated_at` = NOW();

INSERT INTO `Users` (`id`, `role_id`, `full_name`, `email`, `username`, `phone`, `password_hash`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin Teknik', 'admin@reportdaily.local', 'admin', '081200000001', '$2y$10$GpUviaeoRmTphg0RFu.eGO8.PweGGFe7WxaXrceSLb1wZ23ip2fTy', 'Active', NOW(), NOW()),
(2, 2, 'I Made Adi', 'supervisor@reportdaily.local', 'supervisor', '081200000002', '$2y$10$QrKdBiOwvGbg.M3sSq4ZAetxPqkske5PYbPHy2dkT6TRtx6jzz6Ua', 'Active', NOW(), NOW()),
(3, 3, 'Manager Proyek', 'manager@reportdaily.local', 'manager', '081200000003', '$2y$10$9diYwXaKc0eCYnsoBEfRFuMg48K2aMcFnQy3SxYua8psn5glMI8zG', 'Active', NOW(), NOW())
ON DUPLICATE KEY UPDATE
`full_name` = VALUES(`full_name`),
`role_id` = VALUES(`role_id`),
`phone` = VALUES(`phone`),
`status` = VALUES(`status`),
`updated_at` = NOW();

INSERT INTO `WorkerCategories` (`id`, `name`, `slug`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Pelaksana KSO', 'pelaksana-kso', 1, 1, NOW(), NOW()),
(2, 'Pelaksana Subkon / Vendor', 'pelaksana-subkon-vendor', 2, 1, NOW(), NOW()),
(3, 'Gudang', 'gudang', 3, 1, NOW(), NOW()),
(4, 'Logistik', 'logistik', 4, 1, NOW(), NOW()),
(5, 'Peralatan', 'peralatan', 5, 1, NOW(), NOW()),
(6, 'HSE', 'hse', 6, 1, NOW(), NOW()),
(7, 'QA / QC', 'qa-qc', 7, 1, NOW(), NOW()),
(8, 'Survey', 'survey', 8, 1, NOW(), NOW()),
(9, 'Mekanik & Elektrikal', 'mekanik-elektrikal', 9, 1, NOW(), NOW()),
(10, 'Pekerja Subkon / Vendor', 'pekerja-subkon-vendor', 10, 1, NOW(), NOW()),
(11, 'Pekerja Harian', 'pekerja-harian', 11, 1, NOW(), NOW()),
(12, 'Tukang', 'tukang', 12, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE
`name` = VALUES(`name`),
`sort_order` = VALUES(`sort_order`),
`is_active` = VALUES(`is_active`),
`updated_at` = NOW();

INSERT INTO `HeavyEquipmentCategories` (`id`, `name`, `slug`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dump Truck', 'dump-truck', 1, 1, NOW(), NOW()),
(2, 'Excavator', 'excavator', 2, 1, NOW(), NOW()),
(3, 'Bulldozer', 'bulldozer', 3, 1, NOW(), NOW()),
(4, 'Loader', 'loader', 4, 1, NOW(), NOW()),
(5, 'Vibroroller', 'vibroroller', 5, 1, NOW(), NOW()),
(6, 'Hyab Crane', 'hyab-crane', 6, 1, NOW(), NOW()),
(7, 'Crane', 'crane', 7, 1, NOW(), NOW()),
(8, 'Boring Machine', 'boring-machine', 8, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE
`name` = VALUES(`name`),
`sort_order` = VALUES(`sort_order`),
`is_active` = VALUES(`is_active`),
`updated_at` = NOW();
