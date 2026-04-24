<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<section class="AuthScreen">
    <div class="AuthBrand">
        <img src="<?= trace_logo_url() ?>" alt="<?= esc(trace_app_name()) ?>" class="BrandLogo">
        <p class="Eyebrow">Enterprise Mobile Reporting</p>
        <h1><?= esc(trace_app_name()) ?></h1>
        <p class="AuthTagline"><?= esc(trace_app_tagline()) ?></p>
        <p>Masuk ke aplikasi pelaporan harian yang rapi, profesional, dan siap dipakai sebagai PWA di perangkat mobile.</p>
    </div>

    <div class="GlassCard">
        <div class="CardHeading isAuth">
            <h2>Masuk ke Akun</h2>
            <span>Akses cepat & aman</span>
        </div>
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
