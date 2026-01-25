<?php
/**
 * Page d'accueil de VetoHub
 */

$page_title = "VetoHub - Formation Vétérinaire";
$body_class = "index-page home-page";

include 'header.php';
require_once 'components_helper.php';

// Configuration des sections principales
$sections = [
	[
        'icon_img' => getIcon('oeil'),
        'title' => 'Lésions Oculaires',
        'description' => 'Atlas complet des pathologies ophtalmologiques vétérinaires avec cas cliniques',
        'link' => 'lesions_ocuaires/index.php'
    ],
    [
        'icon_img' => getIcon('evaluation'),
        'title' => 'Se Tester',
        'description' => 'QCM et cas cliniques interactifs pour évaluer vos connaissances',
        'link' => 'se_tester/index.php'
    ],
    [
        'icon_img' => getIcon('dysendocrinie'),
        'title' => 'Dysendocrinies',
        'description' => 'Guide pratique des troubles endocriniens chez les animaux domestiques',
        'link' => 'dysendocrinies/index.php'
    ],
    [
        'icon_img' => getIcon('physiopathologie'),
        'title' => 'Mécanismes Physiopathologiques',
        'description' => 'Exploration des mécanismes sous-jacents aux pathologies vétérinaires',
        'link' => 'mecanismes_physiopathologiques/index.php'
    ]
];
?>

<div class="header">
    <h1>🐾 VetoHub</h1>
    <p>Plateforme de formation pour vétérinaires et étudiants</p>
</div>

<div class="container">
    <?php foreach ($sections as $section): ?>
        <?= renderBubble($section) ?>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>
