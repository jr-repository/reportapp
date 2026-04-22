<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<section class="AuthScreen">
    <div class="AuthBrand">
        <div class="BrandMark">RD</div>
        <div>
            <p class="Eyebrow">PWA Mobile Laporan Harian</p>
            <h1>Masuk ke Report Daily</h1>
            <p>Pelaporan lapangan yang rapi, seragam, dan siap dibagikan ke WhatsApp.</p>
        </div>
    </div>

    <div class="GlassCard">
        <form method="post" action="<?= base_url('login') ?>" class="StackForm">
            <?= csrf_field() ?>
            <label class="FieldBlock">
                <span>Email / Username</span>
                <input type="text" name="login" value="<?= esc(old('login')) ?>" placeholder="Masukkan email atau username" required>
            </label>

            <label class="FieldBlock">
                <span>Password</span>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </label>

            <button type="submit" class="PrimaryButton">Login</button>
        </form>
    </div>

    <div class="AuthFooterCard">
        <span>Belum punya akun?</span>
        <a href="<?= base_url('register') ?>">Daftar sebagai Supervisor / Pelaksana</a>
    </div>
</section>
<?= $this->endSection() ?>
