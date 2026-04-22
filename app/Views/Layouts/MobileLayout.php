<!doctype html>
<html lang="id">
<head>
    <?php
    $cssVersion = @filemtime(FCPATH . 'Assets/Css/MobileApp.css') ?: time();
    $jsVersion = @filemtime(FCPATH . 'Assets/Js/MobileApp.js') ?: time();
    $swVersion = @filemtime(FCPATH . 'service-worker.js') ?: time();
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0f766e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="description" content="<?= esc($pageTitle ?? 'Report Daily Mobile PWA') ?>">
    <title><?= esc(($pageTitle ?? 'Report Daily') . ' | ' . ($appName ?? 'Report Daily')) ?></title>
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <link rel="icon" href="<?= base_url('Assets/Icons/AppIcon.svg') ?>" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?= base_url('Assets/Icons/AppIcon-192.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('Assets/Css/MobileApp.css?v=' . $cssVersion) ?>">
</head>
<body class="MobileBody <?= esc($pageClass ?? '') ?>">
    <div class="AmbientBackground"></div>
    <div class="DeviceWrap">
        <div class="MobileFrame">
            <?php if (($isAuthenticated ?? false) === true) : ?>
                <?= view('Components/TopBar', ['currentUser' => $currentUser ?? null]) ?>
            <?php endif; ?>

            <main class="MobileShell">
                <?= view('Components/FlashMessage') ?>
                <?= $this->renderSection('content') ?>
            </main>

            <?php if (($isAuthenticated ?? false) === true) : ?>
                <?= view('Components/BottomNavigation', ['items' => $bottomNavigation ?? [], 'currentUriPath' => $currentUriPath ?? '']) ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        window.baseUrl = '<?= base_url('/') ?>';
        window.appAssetVersion = '<?= esc((string) max($cssVersion, $jsVersion, $swVersion)) ?>';
    </script>
    <script src="<?= base_url('Assets/Js/MobileApp.js?v=' . $jsVersion) ?>"></script>
</body>
</html>
