<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<?= view('Components/PageHeader', [
    'eyebrow' => 'Resume Sebelum Submit',
    'title' => 'Checklist Pengisian',
    'subtitle' => 'Pastikan semua komponen laporan sudah sesuai sebelum final submit.',
    'actionHref' => base_url('reports/edit/' . $bundle['report']['id']),
    'actionLabel' => 'Ubah Draft',
    'actionIcon' => 'edit',
]) ?>

<section class="MetricCard isAccent">
    <span class="MetricLabel">Progress Checklist</span>
    <strong><?= esc((string) $summary['doneCount']) ?>/<?= esc((string) $summary['totalCount']) ?> lengkap</strong>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Checklist Done</h2>
        <span><?= esc($bundle['report']['report_code']) ?></span>
    </div>
    <div class="ChecklistList">
        <?php foreach ($summary['items'] as $item) : ?>
            <div class="ChecklistItem <?= $item['done'] ? 'isDone' : 'isMissing' ?>">
                <span><?= esc($item['label']) ?></span>
                <strong><?= $item['done'] ? '✓' : '✕' ?></strong>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Ringkasan Singkat</h2>
        <span>Preview data</span>
    </div>
    <div class="DetailList">
        <div><span>Tanggal</span><strong><?= esc(date('d M Y', strtotime($bundle['report']['report_date']))) ?></strong></div>
        <div><span>Pelaksana</span><strong><?= esc($bundle['worker']['full_name']) ?></strong></div>
        <div><span>Lokasi</span><strong><?= esc($bundle['location']['area_label'] . ' - ' . $bundle['location']['current_location']) ?></strong></div>
        <div><span>Cuaca</span><strong><?= esc($bundle['report']['weather_code']) ?></strong></div>
        <div><span>Foto</span><strong><?= esc((string) count($bundle['photos'])) ?> file</strong></div>
    </div>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Import PDF</h2>
        <span>Siap setelah submit final</span>
    </div>
    <p class="InfoText">Setelah submit, laporan akan menghasilkan ringkasan WhatsApp dan PDF terstruktur beserta dokumentasi foto.</p>
</section>

<form method="post" action="<?= base_url('reports/submit/' . $bundle['report']['id']) ?>">
    <?= csrf_field() ?>
    <div class="StickyActionBar">
        <a href="<?= base_url('reports/edit/' . $bundle['report']['id']) ?>" class="GhostButton isIconOnly" aria-label="Kembali ke edit draft" title="Kembali ke edit draft"><?= trace_icon('back') ?></a>
        <button type="submit" class="PrimaryButton">Submit Final</button>
    </div>
</form>
<?= $this->endSection() ?>
