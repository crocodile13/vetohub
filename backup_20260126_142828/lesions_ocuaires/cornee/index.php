<?php
/**
 * Page Lésions de la Cornée
 */

$page_title = "Lésions de la Cornée - VetoHub";
$body_class = "section-lesions-oculaires structure-page";

include '../../header.php';
require_once '../../components_helper.php';

// Configuration des lésions cornéennes
$lesions = [
    [
        'icon' => '👁️',
        'title' => 'Kératite Cornéenne',
        'description' => 'Inflammation de la cornée : étiologies, signes cliniques et approches thérapeutiques en vétérinaire',
        'link' => 'keratite_corneenne/index.php'
    ],
    [
        'icon' => '👁️',
        'title' => 'Ulcère Cornéen',
        'description' => 'Lésions ulcératives de la cornée : diagnostic, complications et traitements chez les animaux',
        'link' => 'ulcere_corneen/index.php'
    ],
    [
        'icon' => '👁️',
        'title' => 'Arc Cornéen Lipidique',
        'description' => 'Dépôts lipidiques en arc sur la cornée : causes métaboliques et gestion en pratique vétérinaire',
        'link' => 'arc_corneen_lipidique/index.php'
    ],
    [
        'icon' => '👁️',
        'title' => 'Kératopathie Lipidique',
        'description' => 'Accumulation de lipides dans la cornée : présentation clinique et options thérapeutiques',
        'link' => 'keratopathie_lipidique/index.php'
    ]
];
?>

<?= renderPageHeader('Lésions de la Cornée', 'Atlas des pathologies cornéennes en ophtalmologie vétérinaire') ?>

<div class="container">
    <?php foreach ($lesions as $lesion): ?>
        <?= renderBubble($lesion) ?>
    <?php endforeach; ?>
</div>

<?php include '../../footer.php'; ?>
