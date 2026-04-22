<?php
$initial = strtoupper(substr((string) ($currentUser['full_name'] ?? 'U'), 0, 1));
?>

<header class="TopBar">
    <a href="<?= base_url('/') ?>" class="TopBarBrand">
        <span class="TopBarBrandIcon">RD</span>
        <span>
            <strong>Report Daily</strong>
            <small><?= esc($currentUser['role_name'] ?? 'User') ?></small>
        </span>
    </a>

    <div class="TopBarActions">
        <a href="<?= base_url('profile') ?>" class="ProfileChip" aria-label="Buka profil">
            <span class="ProfileAvatar"><?= esc($initial) ?></span>
        </a>

        <form method="post" action="<?= base_url('logout') ?>" class="LogoutForm">
            <?= csrf_field() ?>
            <button type="submit" class="IconButton" aria-label="Logout">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 8l4 4-4 4"/><path d="M19 12H9"/><path d="M13 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7"/></svg>
            </button>
        </form>
    </div>
</header>
