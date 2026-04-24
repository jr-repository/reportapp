<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<section class="AuthScreen isLoginShowcase">
    <div class="LoginCard">
        <div class="LoginHero">
            <div class="LoginHeroBrand">
                <img src="<?= trace_logo_url() ?>" alt="<?= esc(trace_app_name()) ?>" class="BrandLogo">
                <strong><?= esc(trace_app_name()) ?></strong>
                <span><?= esc(trace_app_tagline()) ?></span>
            </div>
            <div class="LoginHeroWave"></div>
        </div>

        <div class="LoginFormPanel GlassCard">
            <div class="CardHeading isAuth isCentered">
                <h2>Welcome Back</h2>
                <span>Masuk ke akun Anda</span>
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

            <div class="AuthDivider"><span>OR</span></div>

            <div class="AuthFooterInline">
                <span>Belum punya akun?</span>
                <a href="<?= base_url('register') ?>">Sign Up</a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
