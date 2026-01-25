<?php
/**
 * Template header commun à toutes les pages
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/navigation_helper.php';

// Génération automatique de la navigation SI elle n'est pas définie manuellement
if (!isset($breadcrumbs) || !isset($body_class)) {
    $nav = getNavigation($_SERVER['SCRIPT_FILENAME']);
    
    // Utiliser les valeurs auto-générées seulement si non définies
    if (!isset($breadcrumbs)) {
        $breadcrumbs = $nav['breadcrumbs'];
    }
    
    if (!isset($body_class)) {
        $body_class = $nav['theme'];
    } else {
        // Si body_class existe mais ne contient pas de thème de section, l'ajouter
        if (!preg_match('/section-/', $body_class)) {
            $body_class = $nav['theme'] . ' ' . $body_class;
        }
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
    
    <!-- Fix mode sombre flipcards - OPAQUE -->
    <style>
        html.dark .flip-card-front {
            background-color: #2d3748 !important;
            color: #f1f5f9 !important;
        }
        
        html.dark .flip-card-front * {
            color: #f1f5f9 !important;
        }
        
        html.dark .flip-card-back {
            background-color: #343e50 !important;
            color: #f1f5f9 !important;
        }
        
        html.dark .flip-card-back * {
            color: #f1f5f9 !important;
        }
        
        html.dark .dysendocrinies-card .flip-card-front {
            background-color: #374151 !important;
        }
        
        html.dark .dysendocrinies-card .flip-card-back {
            background-color: #374151 !important;
        }
        
        html.dark .mecanismes-card .flip-card-front {
            background-color: #2d3748 !important;
        }
        
        html.dark .mecanismes-card .flip-card-back {
            background-color: #343e50 !important;
        }
    </style>
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

<!-- Breadcrumb unique et contextuel -->
<?php if (!empty($breadcrumbs)): ?>
<nav class="breadcrumb-nav">
    <?php foreach ($breadcrumbs as $i => $crumb): 
        if ($i > 0) echo '<span class="breadcrumb-separator">›</span>';
        
        // Le dernier élément n'est jamais cliquable (page actuelle)
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
