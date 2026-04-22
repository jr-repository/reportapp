<section class="PageHeader">
    <div>
        <p class="Eyebrow"><?= esc($eyebrow ?? 'Report Daily') ?></p>
        <h1><?= esc($title ?? 'Halaman') ?></h1>
        <?php if (! empty($subtitle ?? '')) : ?>
            <p class="PageSubtitle"><?= esc($subtitle) ?></p>
        <?php endif; ?>
    </div>

    <?php if (! empty($actionHref ?? '') && ! empty($actionLabel ?? '')) : ?>
        <a class="SecondaryActionButton" href="<?= esc($actionHref) ?>"><?= esc($actionLabel) ?></a>
    <?php endif; ?>
</section>
