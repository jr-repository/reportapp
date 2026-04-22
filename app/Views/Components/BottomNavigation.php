<?php
$renderIcon = static function (string $name): string {
    return match ($name) {
        'house' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10.5V20h13V10.5"/></svg>',
        'document' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 3.5h6l4 4V20H8z"/><path d="M14 3.5V8h4"/></svg>',
        'user' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.8-3.4 5-5 8-5s6.2 1.6 8 5"/></svg>',
        'chart' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 18V9"/><path d="M12 18V5"/><path d="M19 18v-7"/><path d="M3.5 20h17"/></svg>',
        default => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 18V9"/><path d="M12 18V5"/><path d="M19 18v-7"/><path d="M3.5 20h17"/></svg>',
    };
};
?>

<nav class="BottomNavigation">
    <?php foreach ($items as $item) :
        $targetPath = trim((string) parse_url((string) $item['href'], PHP_URL_PATH), '/');
        $isActive   = $currentUriPath === $targetPath || ($targetPath === '' && $currentUriPath === '');
        ?>
        <a class="BottomNavItem <?= $isActive ? 'isActive' : '' ?>" href="<?= esc($item['href']) ?>">
            <span class="BottomNavIcon"><?= $renderIcon((string) $item['icon']) ?></span>
            <span><?= esc($item['label']) ?></span>
        </a>
    <?php endforeach; ?>
</nav>
