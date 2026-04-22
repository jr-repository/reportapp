<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<section class="ProfileHeroCard">
    <div class="ProfileHeroAvatar"><?= esc(strtoupper(substr((string) ($currentUser['full_name'] ?? 'U'), 0, 1))) ?></div>
    <h1><?= esc($currentUser['full_name'] ?? '-') ?></h1>
    <p><?= esc($currentUser['role_name'] ?? '-') ?></p>
</section>

<section class="InfoCard">
    <div class="DetailList">
        <div><span>Nama</span><strong><?= esc($currentUser['full_name'] ?? '-') ?></strong></div>
        <div><span>Role</span><strong><?= esc($currentUser['role_name'] ?? '-') ?></strong></div>
        <div><span>Email</span><strong><?= esc($currentUser['email'] ?? '-') ?></strong></div>
        <div><span>Username</span><strong><?= esc($currentUser['username'] ?? '-') ?></strong></div>
    </div>
    <form method="post" action="<?= base_url('logout') ?>" class="LogoutBlock">
        <?= csrf_field() ?>
        <button type="submit" class="PrimaryButton">Logout</button>
    </form>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Endpoint API JWT</h2>
        <span>Untuk akses mobile process / integrasi</span>
    </div>
    <div class="DetailList">
        <div><span>Issue Token</span><strong>/api/auth/token</strong></div>
        <div><span>Refresh Token</span><strong>/api/auth/refresh</strong></div>
        <div><span>Status Hari Ini</span><strong>/api/reports/today</strong></div>
    </div>
</section>
<?= $this->endSection() ?>
