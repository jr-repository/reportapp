SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM `AuditLogs` WHERE `entity_type` = 'DailyReports';
DELETE FROM `ReportPhotos`;
DELETE FROM `ReportWorkerUpdates`;
DELETE FROM `ReportHeavyEquipmentUsages`;
DELETE FROM `ReportLocations`;
DELETE FROM `ReportMaterialSummaries`;
DELETE FROM `ReportToolSummaries`;
DELETE FROM `ReportObstacleSummaries`;
DELETE FROM `ReportTomorrowPlans`;
DELETE FROM `ReportOvertimes`;
DELETE FROM `DailyReports`;

ALTER TABLE `DailyReports` AUTO_INCREMENT = 1;
ALTER TABLE `ReportLocations` AUTO_INCREMENT = 1;
ALTER TABLE `ReportMaterialSummaries` AUTO_INCREMENT = 1;
ALTER TABLE `ReportToolSummaries` AUTO_INCREMENT = 1;
ALTER TABLE `ReportObstacleSummaries` AUTO_INCREMENT = 1;
ALTER TABLE `ReportTomorrowPlans` AUTO_INCREMENT = 1;
ALTER TABLE `ReportOvertimes` AUTO_INCREMENT = 1;
ALTER TABLE `ReportPhotos` AUTO_INCREMENT = 1;
ALTER TABLE `ReportWorkerUpdates` AUTO_INCREMENT = 1;
ALTER TABLE `ReportHeavyEquipmentUsages` AUTO_INCREMENT = 1;

INSERT INTO `DailyReports` (`id`, `report_code`, `report_date`, `worker_user_id`, `created_by_user_id`, `weather_code`, `realization_summary`, `whatsapp_summary`, `status`, `submitted_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'RPT-20260421-RCH-01', '2026-04-21', 4, 4, 'Cerah', 'Pembersihan area kerja, pengukuran awal, dan mobilisasi tenaga kerja untuk persiapan pengecoran pondasi sektor utara.', 'Supervisor: Richy Johannes | Tanggal: 21 April 2026 | Cuaca: Cerah | Fokus: persiapan pengecoran pondasi sektor utara | Status: Submitted', 'Submitted', '2026-04-21 17:45:00', '2026-04-21 07:30:00', '2026-04-21 17:45:00', NULL),
(2, 'RPT-20260422-RCH-02', '2026-04-22', 4, 4, 'Mendung', 'Pekerjaan pembesian, pemasangan bekisting, dan koordinasi material untuk pengecoran jalur akses utama.', 'Supervisor: Richy Johannes | Tanggal: 22 April 2026 | Cuaca: Mendung | Fokus: pembesian dan bekisting jalur akses utama | Status: Submitted', 'Submitted', '2026-04-22 18:05:00', '2026-04-22 07:25:00', '2026-04-22 18:05:00', NULL),
(3, 'RPT-20260423-RCH-03', '2026-04-23', 4, 4, 'Hujan', 'Perapihan area, pengamanan material, serta pekerjaan drainase sementara akibat hujan pada area Swangi.', 'Supervisor: Richy Johannes | Tanggal: 23 April 2026 | Cuaca: Hujan | Fokus: drainase sementara dan pengamanan material | Status: Submitted', 'Submitted', '2026-04-23 17:55:00', '2026-04-23 07:35:00', '2026-04-23 17:55:00', NULL),
(4, 'RPT-20260424-RCH-04', '2026-04-24', 4, 4, 'Cerah', 'Finishing pengecoran, curing beton, dan inspeksi hasil kerja bersama tim QA/QC pada area Lanal.', 'Supervisor: Richy Johannes | Tanggal: 24 April 2026 | Cuaca: Cerah | Fokus: curing beton dan inspeksi QA/QC | Status: Submitted', 'Submitted', '2026-04-24 18:10:00', '2026-04-24 07:20:00', '2026-04-24 18:10:00', NULL),
(5, 'RPT-20260421-IMD-01', '2026-04-21', 2, 2, 'Cerah', 'Mobilisasi alat ringan, briefing keselamatan, dan pekerjaan pengukuran elevasi area kerja sektor barat.', 'Supervisor: I Made Adi | Tanggal: 21 April 2026 | Cuaca: Cerah | Fokus: pengukuran elevasi dan briefing keselamatan | Status: Submitted', 'Submitted', '2026-04-21 17:40:00', '2026-04-21 07:15:00', '2026-04-21 17:40:00', NULL),
(6, 'RPT-20260422-IMD-02', '2026-04-22', 2, 2, 'Mendung', 'Pekerjaan galian saluran, perapihan stock material, dan pemasangan patok kontrol area proyek.', 'Supervisor: I Made Adi | Tanggal: 22 April 2026 | Cuaca: Mendung | Fokus: galian saluran dan patok kontrol | Status: Submitted', 'Submitted', '2026-04-22 17:58:00', '2026-04-22 07:18:00', '2026-04-22 17:58:00', NULL),
(7, 'RPT-20260423-IMD-03', '2026-04-23', 2, 2, 'Hujan', 'Pembersihan genangan, pengamanan alat, dan pekerjaan perbaikan akses kerja setelah hujan deras.', 'Supervisor: I Made Adi | Tanggal: 23 April 2026 | Cuaca: Hujan | Fokus: perbaikan akses kerja dan pengamanan alat | Status: Submitted', 'Submitted', '2026-04-23 17:50:00', '2026-04-23 07:22:00', '2026-04-23 17:50:00', NULL),
(8, 'RPT-20260424-IMD-04', '2026-04-24', 2, 2, 'Cerah', 'Pekerjaan pemasangan material finishing, housekeeping area, dan serah terima progres harian ke tim admin.', 'Supervisor: I Made Adi | Tanggal: 24 April 2026 | Cuaca: Cerah | Fokus: finishing dan housekeeping area | Status: Submitted', 'Submitted', '2026-04-24 18:00:00', '2026-04-24 07:10:00', '2026-04-24 18:00:00', NULL);

INSERT INTO `ReportLocations` (`id`, `daily_report_id`, `current_location`, `area_code`, `area_label`, `reason`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sektor Utara Titik A', 'AreaLanal', 'Area Lanal', 'Akses material lancar dan area siap kerja.', '2026-04-21 07:30:00', '2026-04-21 17:45:00'),
(2, 2, 'Jalur Akses Utama Blok 2', 'AreaLanal', 'Area Lanal', 'Fokus pekerjaan pada jalur akses utama dan pembesian.', '2026-04-22 07:25:00', '2026-04-22 18:05:00'),
(3, 3, 'Drainase Swangi Barat', 'AreaSwangi', 'Area Swangi', 'Penanganan drainase sementara karena curah hujan tinggi.', '2026-04-23 07:35:00', '2026-04-23 17:55:00'),
(4, 4, 'Zona Finishing Lanal', 'AreaLanal', 'Area Lanal', 'Pekerjaan akhir dan inspeksi mutu lapangan.', '2026-04-24 07:20:00', '2026-04-24 18:10:00'),
(5, 5, 'Sektor Barat Grid B', 'AreaRpi', 'Area RPI', 'Pengukuran elevasi awal untuk pekerjaan lanjutan.', '2026-04-21 07:15:00', '2026-04-21 17:40:00'),
(6, 6, 'Saluran Timur RPI', 'AreaRpi', 'Area RPI', 'Galian dan kontrol elevasi saluran proyek.', '2026-04-22 07:18:00', '2026-04-22 17:58:00'),
(7, 7, 'Akses Kerja Laut Sisi Selatan', 'AreaLaut', 'Area Laut', 'Perbaikan akses kerja pasca hujan dan pembersihan genangan.', '2026-04-23 07:22:00', '2026-04-23 17:50:00'),
(8, 8, 'Area Finishing Gudang Material', 'Lainnya', 'Lainnya', 'Housekeeping dan penataan area finishing material.', '2026-04-24 07:10:00', '2026-04-24 18:00:00');

INSERT INTO `ReportMaterialSummaries` (`id`, `daily_report_id`, `summary_text`, `created_at`, `updated_at`) VALUES
(1, 1, 'Besi tulangan, wiremesh, kawat bendrat, dan agregat pondasi tersedia sesuai kebutuhan harian.', '2026-04-21 07:30:00', '2026-04-21 17:45:00'),
(2, 2, 'Bekisting panel, besi D13, semen, dan pasir pasang digunakan untuk jalur akses utama.', '2026-04-22 07:25:00', '2026-04-22 18:05:00'),
(3, 3, 'Karung pasir, batu split, dan geotextile dipakai untuk pengendalian aliran air sementara.', '2026-04-23 07:35:00', '2026-04-23 17:55:00'),
(4, 4, 'Air curing, compound curing, dan material patching tersedia untuk pekerjaan finishing beton.', '2026-04-24 07:20:00', '2026-04-24 18:10:00'),
(5, 5, 'Patok ukur, cat marking, benang ukur, dan material bantu pengukuran tersedia lengkap.', '2026-04-21 07:15:00', '2026-04-21 17:40:00'),
(6, 6, 'Pipa saluran, pasir urug, batu kosong, dan material kontrol elevasi digunakan sesuai kebutuhan.', '2026-04-22 07:18:00', '2026-04-22 17:58:00'),
(7, 7, 'Material timbunan, batu belah, dan terpal pelindung digunakan untuk pengamanan area.', '2026-04-23 07:22:00', '2026-04-23 17:50:00'),
(8, 8, 'Sealant, mortar instan, cat marking, dan bahan pembersih dipakai untuk finishing dan housekeeping.', '2026-04-24 07:10:00', '2026-04-24 18:00:00');

INSERT INTO `ReportToolSummaries` (`id`, `daily_report_id`, `summary_text`, `created_at`, `updated_at`) VALUES
(1, 1, 'Theodolite, meteran, gerobak dorong, dan hand tools dipakai untuk persiapan area kerja.', '2026-04-21 07:30:00', '2026-04-21 17:45:00'),
(2, 2, 'Cutting wheel, bar cutter, bar bender, vibrator, dan hand tools digunakan untuk pembesian.', '2026-04-22 07:25:00', '2026-04-22 18:05:00'),
(3, 3, 'Pompa air portable, sekop, cangkul, dan alat pembersih area digunakan selama hujan.', '2026-04-23 07:35:00', '2026-04-23 17:55:00'),
(4, 4, 'Selang curing, alat ukur slump, dan perlengkapan inspeksi dipakai untuk finishing pekerjaan.', '2026-04-24 07:20:00', '2026-04-24 18:10:00'),
(5, 5, 'Total station, meteran laser, waterpass, dan alat tulis lapangan dipakai untuk survey elevasi.', '2026-04-21 07:15:00', '2026-04-21 17:40:00'),
(6, 6, 'Sekop, cangkul, alat ukur elevasi, dan hand compactor dipakai untuk pekerjaan galian saluran.', '2026-04-22 07:18:00', '2026-04-22 17:58:00'),
(7, 7, 'Pompa submersible, sapu dorong, selang, dan alat pengaman area dipakai untuk pembersihan genangan.', '2026-04-23 07:22:00', '2026-04-23 17:50:00'),
(8, 8, 'Hand grinder, kuas, alat kebersihan, dan hand tools finishing dipakai sepanjang hari.', '2026-04-24 07:10:00', '2026-04-24 18:00:00');

INSERT INTO `ReportObstacleSummaries` (`id`, `daily_report_id`, `obstacle_shape`, `obstacle_cause`, `obstacle_impact`, `additional_note`, `created_at`, `updated_at`) VALUES
(1, 1, 'Akses material terbatas', 'Kepadatan kendaraan proyek', 'Distribusi material lebih lambat pada jam sibuk', 'Pengiriman diatur bertahap oleh logistik.', '2026-04-21 07:30:00', '2026-04-21 17:45:00'),
(2, 2, 'Keterlambatan material bekisting', 'Antrian unloading supplier', 'Pekerjaan bekisting bergeser beberapa jam', 'Tim menyesuaikan urutan kerja agar target tetap tercapai.', '2026-04-22 07:25:00', '2026-04-22 18:05:00'),
(3, 3, 'Genangan air lapangan', 'Hujan intensitas tinggi', 'Produktivitas lapangan menurun dan area licin', 'Fokus dialihkan ke drainase sementara dan pengamanan material.', '2026-04-23 07:35:00', '2026-04-23 17:55:00'),
(4, 4, 'Akses inspeksi terbatas', 'Beberapa area masih proses curing', 'Pemeriksaan mutu dilakukan bergantian per zona', 'Koordinasi dilakukan bersama QA/QC untuk inspeksi bertahap.', '2026-04-24 07:20:00', '2026-04-24 18:10:00'),
(5, 5, 'Marker area kurang terlihat', 'Permukaan tanah belum rata', 'Survey awal perlu pengulangan pada beberapa titik', 'Patok tambahan dipasang setelah briefing lapangan.', '2026-04-21 07:15:00', '2026-04-21 17:40:00'),
(6, 6, 'Kontur tanah labil', 'Tanah urug basah akibat cuaca', 'Galian perlu perkuatan sisi kerja', 'Pekerjaan dilakukan bertahap dengan pengawasan lebih ketat.', '2026-04-22 07:18:00', '2026-04-22 17:58:00'),
(7, 7, 'Akses kerja licin', 'Curah hujan tinggi dan genangan', 'Mobilitas pekerja melambat di area kerja', 'Material anti slip dan drainase darurat digunakan.', '2026-04-23 07:22:00', '2026-04-23 17:50:00'),
(8, 8, 'Debu finishing tinggi', 'Pekerjaan pembersihan area intensif', 'Area perlu dibersihkan lebih sering', 'Housekeeping ditingkatkan per dua jam sekali.', '2026-04-24 07:10:00', '2026-04-24 18:00:00');

INSERT INTO `ReportTomorrowPlans` (`id`, `daily_report_id`, `summary_text`, `created_at`, `updated_at`) VALUES
(1, 1, 'Melanjutkan pembesian pondasi dan penyiapan jalur distribusi material.', '2026-04-21 07:30:00', '2026-04-21 17:45:00'),
(2, 2, 'Melaksanakan pengecoran bertahap dan pengawasan bekisting area utama.', '2026-04-22 07:25:00', '2026-04-22 18:05:00'),
(3, 3, 'Menormalkan drainase dan melanjutkan perapihan area kerja setelah cuaca membaik.', '2026-04-23 07:35:00', '2026-04-23 17:55:00'),
(4, 4, 'Melanjutkan curing beton dan menutup seluruh temuan minor hasil inspeksi.', '2026-04-24 07:20:00', '2026-04-24 18:10:00'),
(5, 5, 'Melanjutkan marking area dan finalisasi elevasi sektor barat.', '2026-04-21 07:15:00', '2026-04-21 17:40:00'),
(6, 6, 'Melanjutkan galian saluran dan pemasangan material pendukung pada zona timur.', '2026-04-22 07:18:00', '2026-04-22 17:58:00'),
(7, 7, 'Melanjutkan perbaikan akses kerja dan penguatan area yang terdampak hujan.', '2026-04-23 07:22:00', '2026-04-23 17:50:00'),
(8, 8, 'Menuntaskan finishing area dan penataan akhir gudang material.', '2026-04-24 07:10:00', '2026-04-24 18:00:00');

INSERT INTO `ReportOvertimes` (`id`, `daily_report_id`, `is_enabled`, `start_time`, `end_time`, `summary_text`, `created_at`, `updated_at`) VALUES
(1, 1, 0, NULL, NULL, 'Tidak ada lembur.', '2026-04-21 07:30:00', '2026-04-21 17:45:00'),
(2, 2, 1, '18:00', '21:00', 'Lembur untuk penyelesaian bekisting dan persiapan pengecoran.', '2026-04-22 07:25:00', '2026-04-22 18:05:00'),
(3, 3, 0, NULL, NULL, 'Tidak ada lembur karena cuaca hujan.', '2026-04-23 07:35:00', '2026-04-23 17:55:00'),
(4, 4, 1, '18:00', '20:30', 'Lembur untuk curing dan inspeksi penutupan pekerjaan.', '2026-04-24 07:20:00', '2026-04-24 18:10:00'),
(5, 5, 0, NULL, NULL, 'Tidak ada lembur.', '2026-04-21 07:15:00', '2026-04-21 17:40:00'),
(6, 6, 1, '18:30', '21:00', 'Lembur untuk pemasangan patok kontrol dan perapihan area galian.', '2026-04-22 07:18:00', '2026-04-22 17:58:00'),
(7, 7, 0, NULL, NULL, 'Tidak ada lembur karena fokus pemulihan area setelah hujan.', '2026-04-23 07:22:00', '2026-04-23 17:50:00'),
(8, 8, 1, '18:00', '20:00', 'Lembur untuk penataan akhir material finishing dan housekeeping.', '2026-04-24 07:10:00', '2026-04-24 18:00:00');

INSERT INTO `ReportPhotos` (`id`, `daily_report_id`, `file_name`, `file_path`, `mime_type`, `file_size`, `caption`, `sort_order`, `created_at`) VALUES
(1, 1, '1776884767_68fac2af484b8de76e6b.jpg', 'Uploads/Reports/1776884767_68fac2af484b8de76e6b.jpg', 'image/jpeg', 170395, 'Dokumentasi 1', 1, '2026-04-21 17:45:00'),
(2, 2, '1776884767_68fac2af484b8de76e6b.jpg', 'Uploads/Reports/1776884767_68fac2af484b8de76e6b.jpg', 'image/jpeg', 170395, 'Dokumentasi 2', 1, '2026-04-22 18:05:00'),
(3, 3, '1776884767_68fac2af484b8de76e6b.jpg', 'Uploads/Reports/1776884767_68fac2af484b8de76e6b.jpg', 'image/jpeg', 170395, 'Dokumentasi 3', 1, '2026-04-23 17:55:00'),
(4, 4, '1776884767_68fac2af484b8de76e6b.jpg', 'Uploads/Reports/1776884767_68fac2af484b8de76e6b.jpg', 'image/jpeg', 170395, 'Dokumentasi 4', 1, '2026-04-24 18:10:00'),
(5, 5, '1776884767_68fac2af484b8de76e6b.jpg', 'Uploads/Reports/1776884767_68fac2af484b8de76e6b.jpg', 'image/jpeg', 170395, 'Dokumentasi 5', 1, '2026-04-21 17:40:00'),
(6, 6, '1776884767_68fac2af484b8de76e6b.jpg', 'Uploads/Reports/1776884767_68fac2af484b8de76e6b.jpg', 'image/jpeg', 170395, 'Dokumentasi 6', 1, '2026-04-22 17:58:00'),
(7, 7, '1776884767_68fac2af484b8de76e6b.jpg', 'Uploads/Reports/1776884767_68fac2af484b8de76e6b.jpg', 'image/jpeg', 170395, 'Dokumentasi 7', 1, '2026-04-23 17:50:00'),
(8, 8, '1776884767_68fac2af484b8de76e6b.jpg', 'Uploads/Reports/1776884767_68fac2af484b8de76e6b.jpg', 'image/jpeg', 170395, 'Dokumentasi 8', 1, '2026-04-24 18:00:00');

INSERT INTO `ReportWorkerUpdates` (`id`, `daily_report_id`, `worker_category_id`, `category_label`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Pelaksana KSO', 8, '2026-04-21 17:45:00', '2026-04-21 17:45:00'),
(2, 1, 2, 'Pelaksana Subkon / Vendor', 6, '2026-04-21 17:45:00', '2026-04-21 17:45:00'),
(3, 1, 4, 'Logistik', 3, '2026-04-21 17:45:00', '2026-04-21 17:45:00'),
(4, 1, 7, 'QA / QC', 2, '2026-04-21 17:45:00', '2026-04-21 17:45:00'),
(5, 2, 1, 'Pelaksana KSO', 10, '2026-04-22 18:05:00', '2026-04-22 18:05:00'),
(6, 2, 2, 'Pelaksana Subkon / Vendor', 7, '2026-04-22 18:05:00', '2026-04-22 18:05:00'),
(7, 2, 4, 'Logistik', 3, '2026-04-22 18:05:00', '2026-04-22 18:05:00'),
(8, 2, 12, 'Tukang', 5, '2026-04-22 18:05:00', '2026-04-22 18:05:00'),
(9, 3, 1, 'Pelaksana KSO', 6, '2026-04-23 17:55:00', '2026-04-23 17:55:00'),
(10, 3, 3, 'Gudang', 2, '2026-04-23 17:55:00', '2026-04-23 17:55:00'),
(11, 3, 4, 'Logistik', 2, '2026-04-23 17:55:00', '2026-04-23 17:55:00'),
(12, 3, 6, 'HSE', 2, '2026-04-23 17:55:00', '2026-04-23 17:55:00'),
(13, 4, 1, 'Pelaksana KSO', 7, '2026-04-24 18:10:00', '2026-04-24 18:10:00'),
(14, 4, 5, 'Peralatan', 3, '2026-04-24 18:10:00', '2026-04-24 18:10:00'),
(15, 4, 7, 'QA / QC', 3, '2026-04-24 18:10:00', '2026-04-24 18:10:00'),
(16, 4, 9, 'Mekanik & Elektrikal', 2, '2026-04-24 18:10:00', '2026-04-24 18:10:00'),
(17, 5, 4, 'Logistik', 3, '2026-04-21 17:40:00', '2026-04-21 17:40:00'),
(18, 5, 6, 'HSE', 2, '2026-04-21 17:40:00', '2026-04-21 17:40:00'),
(19, 5, 8, 'Survey', 4, '2026-04-21 17:40:00', '2026-04-21 17:40:00'),
(20, 5, 11, 'Pekerja Harian', 6, '2026-04-21 17:40:00', '2026-04-21 17:40:00'),
(21, 6, 1, 'Pelaksana KSO', 5, '2026-04-22 17:58:00', '2026-04-22 17:58:00'),
(22, 6, 8, 'Survey', 3, '2026-04-22 17:58:00', '2026-04-22 17:58:00'),
(23, 6, 10, 'Pekerja Subkon / Vendor', 7, '2026-04-22 17:58:00', '2026-04-22 17:58:00'),
(24, 6, 12, 'Tukang', 4, '2026-04-22 17:58:00', '2026-04-22 17:58:00'),
(25, 7, 3, 'Gudang', 2, '2026-04-23 17:50:00', '2026-04-23 17:50:00'),
(26, 7, 4, 'Logistik', 2, '2026-04-23 17:50:00', '2026-04-23 17:50:00'),
(27, 7, 6, 'HSE', 3, '2026-04-23 17:50:00', '2026-04-23 17:50:00'),
(28, 7, 11, 'Pekerja Harian', 5, '2026-04-23 17:50:00', '2026-04-23 17:50:00'),
(29, 8, 2, 'Pelaksana Subkon / Vendor', 5, '2026-04-24 18:00:00', '2026-04-24 18:00:00'),
(30, 8, 4, 'Logistik', 2, '2026-04-24 18:00:00', '2026-04-24 18:00:00'),
(31, 8, 5, 'Peralatan', 3, '2026-04-24 18:00:00', '2026-04-24 18:00:00'),
(32, 8, 12, 'Tukang', 4, '2026-04-24 18:00:00', '2026-04-24 18:00:00');

INSERT INTO `ReportHeavyEquipmentUsages` (`id`, `daily_report_id`, `heavy_equipment_category_id`, `equipment_label`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Dump Truck', 2, '2026-04-21 17:45:00', '2026-04-21 17:45:00'),
(2, 1, 2, 'Excavator', 1, '2026-04-21 17:45:00', '2026-04-21 17:45:00'),
(3, 2, 2, 'Excavator', 1, '2026-04-22 18:05:00', '2026-04-22 18:05:00'),
(4, 2, 4, 'Loader', 1, '2026-04-22 18:05:00', '2026-04-22 18:05:00'),
(5, 3, 1, 'Dump Truck', 1, '2026-04-23 17:55:00', '2026-04-23 17:55:00'),
(6, 3, 5, 'Vibroroller', 1, '2026-04-23 17:55:00', '2026-04-23 17:55:00'),
(7, 4, 4, 'Loader', 1, '2026-04-24 18:10:00', '2026-04-24 18:10:00'),
(8, 4, 6, 'Hyab Crane', 1, '2026-04-24 18:10:00', '2026-04-24 18:10:00'),
(9, 5, 1, 'Dump Truck', 1, '2026-04-21 17:40:00', '2026-04-21 17:40:00'),
(10, 5, 7, 'Crane', 1, '2026-04-21 17:40:00', '2026-04-21 17:40:00'),
(11, 6, 2, 'Excavator', 1, '2026-04-22 17:58:00', '2026-04-22 17:58:00'),
(12, 6, 8, 'Boring Machine', 1, '2026-04-22 17:58:00', '2026-04-22 17:58:00'),
(13, 7, 1, 'Dump Truck', 1, '2026-04-23 17:50:00', '2026-04-23 17:50:00'),
(14, 7, 4, 'Loader', 1, '2026-04-23 17:50:00', '2026-04-23 17:50:00'),
(15, 8, 5, 'Vibroroller', 1, '2026-04-24 18:00:00', '2026-04-24 18:00:00'),
(16, 8, 6, 'Hyab Crane', 1, '2026-04-24 18:00:00', '2026-04-24 18:00:00');

SET FOREIGN_KEY_CHECKS = 1;
