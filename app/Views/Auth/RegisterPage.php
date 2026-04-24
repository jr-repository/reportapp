<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<section class="AuthScreen">
    <div class="AuthBrand">
        <img src="<?= trace_logo_url() ?>" alt="<?= esc(trace_app_name()) ?>" class="BrandLogo">
        <p class="Eyebrow">Register Akun Lapangan</p>
        <h1><?= esc(trace_app_name()) ?></h1>
        <p class="AuthTagline"><?= esc(trace_app_tagline()) ?></p>
        <p>Akun self-register akan masuk sebagai role Supervisor / PIC / Pelaksana.</p>
    </div>

    <div class="GlassCard">
        <div class="CardHeading isAuth">
            <h2>Buat Akun Baru</h2>
            <span>Self registration</span>
        </div>
        <form method="post" action="<?= base_url('register') ?>" class="StackForm">
            <?= csrf_field() ?>
            <label class="FieldBlock">
                <span>Nama Lengkap</span>
                <input type="text" name="fullName" value="<?= esc(old('fullName')) ?>" required>
            </label>

            <label class="FieldBlock">
                <span>Email</span>
                <input type="email" name="email" value="<?= esc(old('email')) ?>" required>
            </label>

            <label class="FieldBlock">
                <span>Username</span>
                <input type="text" name="username" value="<?= esc(old('username')) ?>" required>
            </label>

            <label class="FieldBlock">
                <span>Nomor HP</span>
                <input type="text" name="phone" value="<?= esc(old('phone')) ?>" placeholder="Opsional">
            </label>

            <label class="FieldBlock">
                <span>Password</span>
                <input type="password" name="password" required>
            </label>

            <button type="submit" class="PrimaryButton">Buat Akun</button>
        </form>
    </div>

    <div class="AuthFooterCard">
        <span>Sudah punya akun?</span>
        <a href="<?= base_url('login') ?>">Kembali ke login</a>
    </div>
</section>
<?= $this->endSection() ?>
