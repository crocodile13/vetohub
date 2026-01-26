<?php
/**
 * Page Mécanismes Physiopathologiques
 */

$page_title = "Mécanismes Physiopathologiques - VetoHub";
$body_class = "section-mecanismes structure-page";

include '../header.php';
require_once '../components_helper.php';

// Configuration des mécanismes physiopathologiques
$mecanismes = [
    [
        'icon_img' => getIcon('sang'),
        'title' => 'Hyperglycémie',
        'description' => 'Mécanismes de l\'hyperglycémie : conséquences systémiques et oculaires en médecine vétérinaire',
        'link' => 'hyperglycemie/index.php'
    ],
    [
        'icon_img' => getIcon('sang'),
        'title' => 'Hyperlipidémie',
        'description' => 'Hyperlipidémie et dyslipidémies : impacts métaboliques et manifestations oculaires',
        'link' => 'hyperlipidemie/index.php'
    ],
    [
        'icon_img' => getIcon('vaisseaux_sanguins'),
        'title' => 'Hypertension artérielle',
        'description' => 'Hypertension artérielle systémique : physiopathologie et atteintes rétiniennes',
        'link' => 'hypertension_arterielle/index.php'
    ]
];
?>

<?= renderPageHeader('Mécanismes Physiopathologiques', 'Exploration des mécanismes sous-jacents aux pathologies oculaires') ?>

<div class="container">
    <?php foreach ($mecanismes as $mecanisme): ?>
        <?= renderBubble($mecanisme) ?>
    <?php endforeach; ?>
</div>

<?php include '../footer.php'; ?>
