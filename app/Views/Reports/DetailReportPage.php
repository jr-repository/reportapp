<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<?= view('Components/PageHeader', [
    'eyebrow' => 'Detail Laporan',
    'title' => $bundle['worker']['full_name'],
    'subtitle' => 'Laporan tanggal ' . date('d F Y', strtotime($bundle['report']['report_date'])),
    'actionHref' => base_url('reports/pdf/' . $bundle['report']['id']),
    'actionLabel' => 'Buka PDF',
]) ?>

<section class="SuccessCard">
    <div class="SuccessIcon">✓</div>
    <strong><?= esc($bundle['report']['status']) === 'Submitted' ? 'Laporan berhasil dikirim' : 'Draft tersimpan' ?></strong>
    <p><?= esc($bundle['report']['report_code']) ?></p>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Identitas</h2>
        <span><?= esc($bundle['report']['weather_code']) ?></span>
    </div>
    <div class="DetailList">
        <div><span>Pelaksana</span><strong><?= esc($bundle['worker']['full_name']) ?></strong></div>
        <div><span>Area</span><strong><?= esc($bundle['location']['area_label']) ?></strong></div>
        <div><span>Lokasi</span><strong><?= esc($bundle['location']['current_location']) ?></strong></div>
        <div><span>Created By</span><strong><?= esc($bundle['report']['creator_name']) ?></strong></div>
    </div>
    <?php if ($bundle['location']['reason'] !== '') : ?>
        <p class="InfoText"><?= esc($bundle['location']['reason']) ?></p>
    <?php endif; ?>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Update Pekerja</h2>
        <span><?= esc((string) count($bundle['workerUpdates'])) ?> item</span>
    </div>
    <div class="TagList">
        <?php foreach ($bundle['workerUpdates'] as $item) : ?>
            <span class="DataTag"><?= esc($item['category_label']) ?> : <?= esc((string) $item['quantity']) ?></span>
        <?php endforeach; ?>
    </div>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Realisasi Pekerjaan</h2>
        <span>Resume</span>
    </div>
    <p class="RichText"><?= nl2br(esc($bundle['report']['realization_summary'])) ?></p>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Alat Berat</h2>
        <span><?= esc((string) count($bundle['heavyEquipment'])) ?> item</span>
    </div>
    <div class="TagList">
        <?php foreach ($bundle['heavyEquipment'] as $item) : ?>
            <span class="DataTag"><?= esc($item['equipment_label']) ?> : <?= esc((string) $item['quantity']) ?></span>
        <?php endforeach; ?>
    </div>
    <p class="RichText"><?= nl2br(esc($bundle['tool']['summary_text'])) ?></p>
    <p class="RichText"><?= nl2br(esc($bundle['material']['summary_text'])) ?></p>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Kendala & Rencana</h2>
        <span>Lapangan</span>
    </div>
    <div class="DetailList">
        <div><span>Bentuk</span><strong><?= esc($bundle['obstacle']['obstacle_shape']) ?></strong></div>
        <div><span>Penyebab</span><strong><?= esc($bundle['obstacle']['obstacle_cause']) ?></strong></div>
        <div><span>Dampak</span><strong><?= esc($bundle['obstacle']['obstacle_impact']) ?></strong></div>
    </div>
    <?php if ($bundle['obstacle']['additional_note'] !== '') : ?>
        <p class="RichText"><?= nl2br(esc($bundle['obstacle']['additional_note'])) ?></p>
    <?php endif; ?>
    <p class="RichText"><?= nl2br(esc($bundle['tomorrow']['summary_text'])) ?></p>
    <?php if ((int) $bundle['overtime']['is_enabled'] === 1) : ?>
        <p class="InfoText">Lembur: <?= esc($bundle['overtime']['start_time']) ?> - <?= esc($bundle['overtime']['end_time']) ?></p>
    <?php endif; ?>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Dokumentasi</h2>
        <span><?= esc((string) count($bundle['photos'])) ?> foto</span>
    </div>
    <div class="PhotoPreviewGrid">
        <?php foreach ($bundle['photos'] as $photo) : ?>
            <img src="<?= base_url($photo['file_path']) ?>" alt="Foto laporan">
        <?php endforeach; ?>
    </div>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Ringkasan WhatsApp</h2>
        <button type="button" class="InlineAction" data-copy-target="WhatsAppSummary">Copy</button>
    </div>
    <pre id="WhatsAppSummary" class="SummaryBox"><?= esc($bundle['report']['whatsapp_summary'] ?: 'Ringkasan WhatsApp akan terbentuk setelah submit final.') ?></pre>
</section>

<?php if ($bundle['report']['status'] !== 'Submitted') : ?>
    <div class="StickyActionBar">
        <a href="<?= base_url('reports/edit/' . $bundle['report']['id']) ?>" class="GhostButton">Edit Draft</a>
        <form method="post" action="<?= base_url('reports/submit/' . $bundle['report']['id']) ?>">
            <?= csrf_field() ?>
            <button type="submit" class="PrimaryButton">Submit Final</button>
        </form>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
