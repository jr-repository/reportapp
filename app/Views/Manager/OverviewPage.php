<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<?= view('Components/PageHeader', [
    'eyebrow' => 'Manager View',
    'title' => 'Trend & Rekap',
    'subtitle' => 'Ringkasan progres pelaporan dan cuaca kerja dalam tampilan ringkas.',
]) ?>

<section class="StatGrid">
    <?php foreach ($overview['trend'] as $item) : ?>
        <article class="MetricCard">
            <span class="MetricLabel"><?= esc(date('d M', strtotime($item['report_date']))) ?></span>
            <strong><?= esc((string) $item['total_report']) ?> laporan</strong>
        </article>
    <?php endforeach; ?>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Distribusi Cuaca</h2>
        <span>30 hari terakhir</span>
    </div>
    <div class="TagList">
        <?php foreach ($overview['weatherSummary'] as $item) : ?>
            <span class="DataTag"><?= esc($item['weather_code']) ?> : <?= esc((string) $item['total']) ?></span>
        <?php endforeach; ?>
    </div>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Laporan Terbaru</h2>
        <span>10 data</span>
    </div>
    <div class="StatusList">
        <?php foreach ($reports as $report) : ?>
            <div class="ReportCard">
                <div>
                    <strong><?= esc($report['worker_name']) ?></strong>
                    <p><?= esc(date('d M Y', strtotime($report['report_date']))) ?> • <?= esc($report['status']) ?></p>
                </div>
                <a href="<?= base_url('reports/detail/' . $report['id']) ?>" class="InlineAction">Detail</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
