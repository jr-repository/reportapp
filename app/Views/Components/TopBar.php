<header class="TopBar">
    <a href="<?= base_url('/') ?>" class="TopBarBrand">
        <span class="TopBarBrandIcon">
            <img src="<?= trace_logo_url() ?>" alt="<?= esc(trace_app_name()) ?>">
        </span>
        <span>
            <strong><?= esc(trace_app_name()) ?></strong>
            <small><?= esc($currentUser['role_name'] ?? trace_app_tagline()) ?></small>
        </span>
    </a>

    <div class="TopBarActions">
        <a href="<?= base_url('profile') ?>" class="ProfileChip" aria-label="Buka profil">
            <?= trace_icon('profile') ?>
        </a>

        <form method="post" action="<?= base_url('logout') ?>" class="LogoutForm">
            <?= csrf_field() ?>
            <button type="submit" class="IconButton" aria-label="Logout">
                <?= trace_icon('logout') ?>
            </button>
        </form>
    </div>
</header>
