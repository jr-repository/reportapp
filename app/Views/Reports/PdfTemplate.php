<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #102a43; }
        h1, h2 { margin: 0 0 8px; }
        .Header { padding: 18px; background: #0f766e; color: #fff; border-radius: 12px; }
        .Section { margin-top: 18px; padding: 14px; border: 1px solid #d9e2ec; border-radius: 12px; }
        .Label { font-weight: bold; width: 180px; vertical-align: top; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 4px 0; }
        .Tag { display: inline-block; padding: 6px 10px; background: #ecfeff; border-radius: 999px; margin: 0 8px 8px 0; }
        .Photo { width: 47%; margin: 0 2% 10px 0; display: inline-block; }
        .Photo img { width: 100%; border-radius: 12px; }
        pre { white-space: pre-wrap; font-size: 11px; background: #f8fafc; padding: 12px; border-radius: 12px; }
    </style>
</head>
<body>
    <div class="Header">
        <h1>Laporan Harian Lapangan</h1>
        <div><?= esc($bundle['report']['report_code']) ?> • <?= esc(date('d F Y', strtotime($bundle['report']['report_date']))) ?></div>
    </div>

    <div class="Section">
        <h2>Identitas</h2>
        <table>
            <tr><td class="Label">Supervisor / Pelaksana</td><td><?= esc($bundle['worker']['full_name']) ?></td></tr>
            <tr><td class="Label">Cuaca</td><td><?= esc($bundle['report']['weather_code']) ?></td></tr>
            <tr><td class="Label">Lokasi</td><td><?= esc($bundle['location']['area_label'] . ' - ' . $bundle['location']['current_location']) ?></td></tr>
            <tr><td class="Label">Reason</td><td><?= esc($bundle['location']['reason']) ?></td></tr>
        </table>
    </div>

    <div class="Section">
        <h2>Update Pekerja</h2>
        <?php foreach ($bundle['workerUpdates'] as $item) : ?>
            <span class="Tag"><?= esc($item['category_label']) ?> : <?= esc((string) $item['quantity']) ?></span>
        <?php endforeach; ?>
    </div>

    <div class="Section">
        <h2>Realisasi Pekerjaan</h2>
        <p><?= nl2br(esc($bundle['report']['realization_summary'])) ?></p>
    </div>

    <div class="Section">
        <h2>Alat Berat</h2>
        <?php foreach ($bundle['heavyEquipment'] as $item) : ?>
            <span class="Tag"><?= esc($item['equipment_label']) ?> : <?= esc((string) $item['quantity']) ?></span>
        <?php endforeach; ?>
        <p><strong>Alat Kerja Ringan:</strong> <?= esc($bundle['tool']['summary_text']) ?></p>
        <p><strong>Material & Bahan:</strong> <?= esc($bundle['material']['summary_text']) ?></p>
    </div>

    <div class="Section">
        <h2>Kendala dan Rencana Esok</h2>
        <p><strong>Bentuk:</strong> <?= esc($bundle['obstacle']['obstacle_shape']) ?></p>
        <p><strong>Penyebab:</strong> <?= esc($bundle['obstacle']['obstacle_cause']) ?></p>
        <p><strong>Dampak:</strong> <?= esc($bundle['obstacle']['obstacle_impact']) ?></p>
        <p><strong>Catatan:</strong> <?= esc($bundle['obstacle']['additional_note']) ?></p>
        <p><strong>Rencana Esok:</strong> <?= esc($bundle['tomorrow']['summary_text']) ?></p>
        <?php if ((int) $bundle['overtime']['is_enabled'] === 1) : ?>
            <p><strong>Lembur:</strong> <?= esc($bundle['overtime']['start_time']) ?> - <?= esc($bundle['overtime']['end_time']) ?></p>
        <?php endif; ?>
    </div>

    <div class="Section">
        <h2>Dokumentasi Pekerjaan</h2>
        <?php foreach ($bundle['photos'] as $photo) :
            $photoPath = 'file://' . str_replace(' ', '%20', FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $photo['file_path']));
            ?>
            <div class="Photo">
                <img src="<?= esc($photoPath) ?>" alt="Dokumentasi">
            </div>
        <?php endforeach; ?>
    </div>

    <div class="Section">
        <h2>Ringkasan WhatsApp</h2>
        <pre><?= esc($bundle['report']['whatsapp_summary']) ?></pre>
    </div>
</body>
</html>
