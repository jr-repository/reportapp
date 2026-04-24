<?php
$report = $bundle['report'];
$worker = $bundle['worker'];
$location = $bundle['location'];
$logoPath = trace_logo_path();
$logoSrc = is_file($logoPath) ? 'file://' . str_replace(' ', '%20', $logoPath) : '';
$formatValue = static fn (?string $value): string => trim((string) $value) !== '' ? (string) $value : '-';
$formatDate = static fn (?string $value): string => $value ? date('d F Y', strtotime($value)) : '-';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 26px 24px 28px; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10.5px;
            color: #13243c;
            line-height: 1.55;
        }
        .HeaderTable,
        .MetaTable,
        .DetailTable,
        .ListTable {
            width: 100%;
            border-collapse: collapse;
        }
        .HeaderTable td {
            vertical-align: top;
        }
        .BrandCell {
            width: 82px;
        }
        .BrandLogo {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
        .BrandName {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0.4px;
            color: #17345f;
        }
        .BrandTagline {
            margin: 2px 0 0;
            font-size: 10px;
            color: #5c6b81;
        }
        .ReportTitle {
            margin: 9px 0 0;
            font-size: 14px;
            font-weight: bold;
            color: #b11226;
            text-transform: uppercase;
        }
        .Divider {
            margin: 14px 0 16px;
            border-top: 2px solid #17345f;
            border-bottom: 1px solid #d6deea;
            height: 4px;
        }
        .MetaWrap {
            margin-bottom: 16px;
            border: 1px solid #d6deea;
            background: #f7f9fc;
        }
        .MetaTable td {
            padding: 7px 9px;
            border: 1px solid #d6deea;
        }
        .MetaLabel {
            width: 24%;
            font-weight: bold;
            color: #17345f;
            background: #eef3f9;
        }
        .Section {
            margin-bottom: 16px;
            page-break-inside: avoid;
        }
        .SectionTitle {
            margin: 0 0 8px;
            padding: 7px 10px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #ffffff;
            background: #17345f;
        }
        .DetailTable td {
            padding: 7px 9px;
            border: 1px solid #d6deea;
            vertical-align: top;
        }
        .DetailTable .Label {
            width: 28%;
            font-weight: bold;
            color: #17345f;
            background: #f7f9fc;
        }
        .NarrativeBox {
            padding: 10px 12px;
            border: 1px solid #d6deea;
            background: #fcfdff;
        }
        .ListTable th,
        .ListTable td {
            padding: 7px 8px;
            border: 1px solid #d6deea;
            text-align: left;
            vertical-align: top;
        }
        .ListTable th {
            color: #17345f;
            background: #eef3f9;
            font-weight: bold;
        }
        .Muted {
            color: #607087;
        }
        .PhotoGrid {
            margin: 0 -6px;
            font-size: 0;
        }
        .PhotoCard {
            display: inline-block;
            width: 46.8%;
            margin: 0 6px 12px;
            vertical-align: top;
            page-break-inside: avoid;
        }
        .PhotoFrame {
            border: 1px solid #d6deea;
            background: #f7f9fc;
            padding: 6px;
        }
        .PhotoFrame img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .PhotoCaption {
            margin-top: 5px;
            font-size: 9px;
            color: #607087;
        }
        .FooterNote {
            margin-top: 18px;
            padding-top: 10px;
            border-top: 1px solid #d6deea;
            font-size: 9px;
            color: #607087;
        }
    </style>
</head>
<body>
    <table class="HeaderTable">
        <tr>
            <td class="BrandCell">
                <?php if ($logoSrc !== '') : ?>
                    <img src="<?= esc($logoSrc) ?>" alt="TRACE" class="BrandLogo">
                <?php endif; ?>
            </td>
            <td>
                <p class="BrandName"><?= esc(trace_app_name()) ?></p>
                <p class="BrandTagline"><?= esc(trace_app_tagline()) ?></p>
                <p class="ReportTitle">Laporan Tracking Report & Activity</p>
            </td>
        </tr>
    </table>

    <div class="Divider"></div>

    <div class="MetaWrap">
        <table class="MetaTable">
            <tr>
                <td class="MetaLabel">Nomor Laporan</td>
                <td><?= esc($formatValue($report['report_code'] ?? '')) ?></td>
                <td class="MetaLabel">Tanggal Laporan</td>
                <td><?= esc($formatDate($report['report_date'] ?? null)) ?></td>
            </tr>
            <tr>
                <td class="MetaLabel">Status</td>
                <td><?= esc($formatValue($report['status'] ?? '')) ?></td>
                <td class="MetaLabel">Dibuat Oleh</td>
                <td><?= esc($formatValue($report['creator_name'] ?? '')) ?></td>
            </tr>
        </table>
    </div>

    <div class="Section">
        <p class="SectionTitle">1. Identitas Pekerjaan</p>
        <table class="DetailTable">
            <tr>
                <td class="Label">Supervisor / Pelaksana</td>
                <td><?= esc($formatValue($worker['full_name'] ?? '')) ?></td>
                <td class="Label">Cuaca</td>
                <td><?= esc($formatValue($report['weather_code'] ?? '')) ?></td>
            </tr>
            <tr>
                <td class="Label">Area</td>
                <td><?= esc($formatValue($location['area_label'] ?? '')) ?></td>
                <td class="Label">Lokasi Aktual</td>
                <td><?= esc($formatValue($location['current_location'] ?? '')) ?></td>
            </tr>
            <tr>
                <td class="Label">Keterangan Lokasi</td>
                <td colspan="3"><?= esc($formatValue($location['reason'] ?? '')) ?></td>
            </tr>
        </table>
    </div>

    <div class="Section">
        <p class="SectionTitle">2. Update Personel</p>
        <table class="ListTable">
            <thead>
                <tr>
                    <th style="width: 78%;">Kategori Personel</th>
                    <th style="width: 22%;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($bundle['workerUpdates'] !== []) : ?>
                    <?php foreach ($bundle['workerUpdates'] as $item) : ?>
                        <tr>
                            <td><?= esc($formatValue($item['category_label'] ?? '')) ?></td>
                            <td><?= esc((string) ($item['quantity'] ?? 0)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2" class="Muted">Tidak ada data update pekerja.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="Section">
        <p class="SectionTitle">3. Realisasi Pekerjaan</p>
        <div class="NarrativeBox"><?= nl2br(esc($formatValue($report['realization_summary'] ?? ''))) ?></div>
    </div>

    <div class="Section">
        <p class="SectionTitle">4. Alat Berat, Alat Ringan, dan Material</p>
        <table class="ListTable">
            <thead>
                <tr>
                    <th style="width: 78%;">Kategori Alat Berat</th>
                    <th style="width: 22%;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($bundle['heavyEquipment'] !== []) : ?>
                    <?php foreach ($bundle['heavyEquipment'] as $item) : ?>
                        <tr>
                            <td><?= esc($formatValue($item['equipment_label'] ?? '')) ?></td>
                            <td><?= esc((string) ($item['quantity'] ?? 0)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2" class="Muted">Tidak ada data alat berat.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <table class="DetailTable" style="margin-top: 10px;">
            <tr>
                <td class="Label">Alat Kerja Ringan</td>
                <td><?= esc($formatValue($bundle['tool']['summary_text'] ?? '')) ?></td>
            </tr>
            <tr>
                <td class="Label">Material & Bahan Kerja</td>
                <td><?= esc($formatValue($bundle['material']['summary_text'] ?? '')) ?></td>
            </tr>
        </table>
    </div>

    <div class="Section">
        <p class="SectionTitle">5. Kendala, Rencana Esok, dan Lembur</p>
        <table class="DetailTable">
            <tr>
                <td class="Label">Bentuk Kendala</td>
                <td><?= esc($formatValue($bundle['obstacle']['obstacle_shape'] ?? '')) ?></td>
            </tr>
            <tr>
                <td class="Label">Penyebab Kendala</td>
                <td><?= esc($formatValue($bundle['obstacle']['obstacle_cause'] ?? '')) ?></td>
            </tr>
            <tr>
                <td class="Label">Dampak Pekerjaan</td>
                <td><?= esc($formatValue($bundle['obstacle']['obstacle_impact'] ?? '')) ?></td>
            </tr>
            <tr>
                <td class="Label">Catatan Tambahan</td>
                <td><?= esc($formatValue($bundle['obstacle']['additional_note'] ?? '')) ?></td>
            </tr>
            <tr>
                <td class="Label">Rencana Pekerjaan Esok</td>
                <td><?= esc($formatValue($bundle['tomorrow']['summary_text'] ?? '')) ?></td>
            </tr>
            <tr>
                <td class="Label">Status Lembur</td>
                <td>
                    <?php if ((int) ($bundle['overtime']['is_enabled'] ?? 0) === 1) : ?>
                        <?= esc($formatValue(($bundle['overtime']['start_time'] ?? '-') . ' - ' . ($bundle['overtime']['end_time'] ?? '-'))) ?>
                    <?php else : ?>
                        Tidak ada lembur
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <div class="Section">
        <p class="SectionTitle">6. Dokumentasi Pekerjaan</p>
        <?php if ($bundle['photos'] !== []) : ?>
            <div class="PhotoGrid">
                <?php foreach ($bundle['photos'] as $index => $photo) :
                    $photoPath = 'file://' . str_replace(' ', '%20', FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $photo['file_path']));
                    ?>
                    <div class="PhotoCard">
                        <div class="PhotoFrame">
                            <img src="<?= esc($photoPath) ?>" alt="Dokumentasi <?= esc((string) ($index + 1)) ?>">
                        </div>
                        <div class="PhotoCaption">Dokumentasi <?= esc((string) ($index + 1)) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="NarrativeBox Muted">Dokumentasi foto tidak tersedia pada laporan ini.</div>
        <?php endif; ?>
    </div>

    <div class="Section">
        <p class="SectionTitle">7. Ringkasan WhatsApp</p>
        <div class="NarrativeBox"><?= nl2br(esc($formatValue($report['whatsapp_summary'] ?? ''))) ?></div>
    </div>

    <div class="FooterNote">
        Dokumen ini digenerate otomatis oleh <?= esc(trace_app_brand()) ?> pada <?= esc(date('d F Y H:i')) ?>.
    </div>
</body>
</html>
