<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<?php
$latestReport = $homeData['latestReport'] ?? null;
$menuItems = [
    ['label' => 'Input Laporan', 'desc' => 'Form lengkap', 'href' => base_url('reports/create'), 'icon' => 'document'],
    ['label' => 'Lokasi', 'desc' => 'Area kerja', 'href' => base_url('reports/create#section-location'), 'icon' => 'pin'],
    ['label' => 'Dokumentasi', 'desc' => 'Upload foto', 'href' => base_url('reports/create#section-photo'), 'icon' => 'camera'],
    ['label' => 'Pekerja', 'desc' => 'Jumlah personel', 'href' => base_url('reports/create#section-worker'), 'icon' => 'team'],
    ['label' => 'Realisasi', 'desc' => 'Progress kerja', 'href' => base_url('reports/create#section-worker'), 'icon' => 'clipboard'],
    ['label' => 'Alat Berat', 'desc' => 'Usage unit', 'href' => base_url('reports/create#section-heavy'), 'icon' => 'truck'],
    ['label' => 'Alat Ringan', 'desc' => 'Tool summary', 'href' => base_url('reports/create#section-heavy'), 'icon' => 'tool'],
    ['label' => 'Material', 'desc' => 'Bahan kerja', 'href' => base_url('reports/create#section-material'), 'icon' => 'box'],
    ['label' => 'Kendala', 'desc' => 'Hambatan kerja', 'href' => base_url('reports/create#section-obstacle'), 'icon' => 'alert'],
    ['label' => 'Review', 'desc' => 'Checklist submit', 'href' => $latestReport ? base_url('reports/detail/' . $latestReport['id']) : base_url('reports/create'), 'icon' => 'check'],
];

$renderMenuIcon = static function (string $name): string {
    return match ($name) {
        'document' => '<svg viewBox="0 0 24 24"><path d="M8 3.5h6l4 4V20H8z"/><path d="M14 3.5V8h4"/></svg>',
        'pin' => '<svg viewBox="0 0 24 24"><path d="M12 21s6-5.4 6-11a6 6 0 1 0-12 0c0 5.6 6 11 6 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>',
        'camera' => '<svg viewBox="0 0 24 24"><path d="M4 8h3l1.5-2h7L17 8h3v10H4z"/><circle cx="12" cy="13" r="3.2"/></svg>',
        'team' => '<svg viewBox="0 0 24 24"><circle cx="9" cy="9" r="3"/><circle cx="17" cy="10" r="2.5"/><path d="M4.5 19c1.2-2.8 3.4-4.2 6-4.2 2.5 0 4.7 1.4 5.8 4.2"/><path d="M15 16.5c.9-.9 2-1.4 3.4-1.4 1.5 0 2.8.7 3.6 2"/></svg>',
        'clipboard' => '<svg viewBox="0 0 24 24"><rect x="6" y="5" width="12" height="16" rx="2"/><path d="M9 5.5h6"/><path d="M9 11h6"/><path d="M9 15h4"/></svg>',
        'truck' => '<svg viewBox="0 0 24 24"><path d="M3 7h11v8H3z"/><path d="M14 10h3l3 3v2h-6z"/><circle cx="7" cy="18" r="1.8"/><circle cx="17" cy="18" r="1.8"/></svg>',
        'tool' => '<svg viewBox="0 0 24 24"><path d="m14 5 5 5"/><path d="m12 7 5 5"/><path d="M3 21l8-8"/><path d="m13 5 6 6"/></svg>',
        'box' => '<svg viewBox="0 0 24 24"><path d="M4 7.5 12 4l8 3.5"/><path d="M4 7.5V16l8 4 8-4V7.5"/><path d="M12 20V11"/></svg>',
        'alert' => '<svg viewBox="0 0 24 24"><path d="M12 4 3 20h18L12 4Z"/><path d="M12 9v4"/><circle cx="12" cy="16.5" r="1"/></svg>',
        default => '<svg viewBox="0 0 24 24"><path d="m5 12 5 5 9-9"/></svg>',
    };
};
?>

<section class="WelcomeBanner">
    <div class="WelcomeBannerContent">
        <p class="Eyebrow isLight">Dashboard Mobile</p>
        <h1>Halo, <?= esc($currentUser['full_name'] ?? '-') ?></h1>
        <p>Pelaporan lapangan yang lebih rapi, kecil, padat, dan nyaman dipakai di layar Android.</p>
        <div class="WelcomeBannerMeta">
            <span><?= esc(date('d M Y', strtotime($homeData['today']))) ?></span>
            <span><?= esc((string) $homeData['submittedCount']) ?> selesai</span>
        </div>
    </div>
    <a href="<?= base_url('reports/create') ?>" class="PrimaryButton isCompact">Isi Hari Ini</a>
</section>

<section class="CompactStatGrid">
    <article class="MiniMetricCard">
        <span class="MetricLabel">Sudah Isi Hari Ini</span>
        <strong><?= esc((string) $homeData['submittedCount']) ?></strong>
    </article>
    <article class="MiniMetricCard">
        <span class="MetricLabel">Belum Isi</span>
        <strong><?= esc((string) $homeData['pendingCount']) ?></strong>
    </article>
</section>

<section class="CarouselSection">
    <div class="CardHeading">
        <h2>Banner & Info</h2>
        <span>Swipe horizontal</span>
    </div>
    <div class="BannerCarousel" id="BannerCarousel">
        <article class="BannerSlide isOne">
            <div>
                <small>Summary Harian</small>
                <strong>Format laporan seragam dan cepat dibagikan ke WhatsApp.</strong>
            </div>
        </article>
        <article class="BannerSlide isTwo">
            <div>
                <small>Monitoring Admin</small>
                <strong>Filter laporan per tanggal, user, dan status dengan tampilan mobile.</strong>
            </div>
        </article>
        <article class="BannerSlide isThree">
            <div>
                <small>Manager View</small>
                <strong>Lihat trend progres dan monitoring disiplin pengisian laporan.</strong>
            </div>
        </article>
    </div>
    <div class="CarouselDots" id="CarouselDots">
        <span class="isActive"></span><span></span><span></span>
    </div>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Quick Summary</h2>
        <span>Snapshot terbaru</span>
    </div>
    <?php if ($latestReport !== null) : ?>
        <div class="CompactHighlightCard">
            <div>
                <strong><?= esc($latestReport['full_name']) ?></strong>
                <p><?= esc(character_limiter($latestReport['realization_summary'], 88)) ?></p>
            </div>
            <a href="<?= base_url('reports/detail/' . $latestReport['id']) ?>" class="InlineAction">Detail</a>
        </div>
    <?php else : ?>
        <p class="InfoText">Belum ada laporan final yang masuk.</p>
    <?php endif; ?>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Icon Menu</h2>
        <span>Scroll vertical</span>
    </div>
    <div class="QuickMenuScroller">
        <div class="QuickMenuGrid isCompact">
            <?php foreach ($menuItems as $item) : ?>
                <a href="<?= esc($item['href']) ?>" class="QuickMenuCard isCompact">
                    <span class="QuickMenuIcon"><?= $renderMenuIcon($item['icon']) ?></span>
                    <strong><?= esc($item['label']) ?></strong>
                    <small><?= esc($item['desc']) ?></small>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Leaderboard Performance</h2>
        <span>30 hari terakhir</span>
    </div>
    <div class="StatusList isCompact">
        <?php foreach ($homeData['leaderboard'] as $index => $item) : ?>
            <div class="StatusItem isCompact">
                <div>
                    <strong>#<?= $index + 1 ?> <?= esc($item['full_name']) ?></strong>
                    <p><?= esc((string) $item['total_report']) ?> laporan terkirim</p>
                </div>
                <span class="StatusBadge isDone">Top</span>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Status Pengisian Hari Ini</h2>
        <span>Siapa yang sudah dan belum isi</span>
    </div>
    <div class="StatusList isCompact">
        <?php foreach ($homeData['statusBoard'] as $item) : ?>
            <div class="StatusItem isCompact">
                <div>
                    <strong><?= esc($item['name']) ?></strong>
                    <p><?= esc($item['status']) ?></p>
                </div>
                <span class="StatusBadge <?= $item['done'] ? 'isDone' : 'isPending' ?>"><?= $item['done'] ? 'Done' : 'Pending' ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
