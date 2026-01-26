<?php
/**
 * Template header commun - OPTIMISÉ
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/navigation_helper.php';

// Génération automatique de la navigation SI non définie
if (!isset($breadcrumbs) || !isset($body_class)) {
    $nav = getNavigation($_SERVER['SCRIPT_FILENAME']);
    
    if (!isset($breadcrumbs)) $breadcrumbs = $nav['breadcrumbs'];
    
    if (!isset($body_class)) {
        $body_class = $nav['theme'];
    } elseif (!preg_match('/section-/', $body_class)) {
        $body_class = $nav['theme'] . ' ' . $body_class;
    }
}

$page_title = $page_title ?? APP_NAME;
$body_class = $body_class ?? '';
$load_schema = $load_schema ?? false;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS modulaires -->
    <link rel="stylesheet" href="<?= asset('css/reset.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/variables.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/animations.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/layout.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/flipcards.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/schema.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/breadcrumb.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/theme.css') ?>">
</head>

<body class="<?= htmlspecialchars($body_class) ?>">

<!-- Background décoratif -->
<div class="animated-bg">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>
</div>
<div class="particles" id="particles"></div>

<!-- Theme toggle -->
<button class="theme-toggle" aria-label="Changer le thème">🌙</button>

<!-- Breadcrumb -->
<?php if (!empty($breadcrumbs)): ?>
<nav class="breadcrumb-nav">
    <?php foreach ($breadcrumbs as $i => $crumb): 
        if ($i > 0) echo '<span class="breadcrumb-separator">›</span>';
        
        $isLast = ($i === count($breadcrumbs) - 1);
        
        if (!$isLast): ?>
            <a href="<?= htmlspecialchars($crumb['link']) ?>" class="breadcrumb-link">
                <?= htmlspecialchars($crumb['title']) ?>
            </a>
        <?php else: ?>
            <span class="breadcrumb-current"><?= htmlspecialchars($crumb['title']) ?></span>
        <?php endif; 
    endforeach; ?>
</nav>
<?php endif; ?>

<!-- DEBUG PANEL - À RETIRER EN PRODUCTION -->
<?php if (DEBUG_MODE): ?>
<div style="position:fixed;bottom:10px;left:10px;background:#000;color:#0f0;padding:10px;font-family:monospace;z-index:9999;font-size:11px;border-radius:8px;max-width:350px;line-height:1.6;">
    <strong style="color:#ff0;">🐛 DEBUG MODE</strong><br>
    <strong>Context:</strong> <?= NavigationHelper::getCurrentContext() ?? '<span style="color:#f00;">null</span>' ?><br>
    <strong>GET[from]:</strong> <?= isset($_GET['from']) ? htmlspecialchars($_GET['from']) : '<span style="color:#888;">not set</span>' ?><br>
    <strong>Path:</strong> <?= htmlspecialchars($_SERVER['SCRIPT_NAME']) ?><br>
    <strong>Referer:</strong> <?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars(basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH))) : '<span style="color:#888;">none</span>' ?>
</div>
<?php endif; ?>
