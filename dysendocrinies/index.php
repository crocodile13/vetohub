<?php
/**
 * Page Dysendocrinies
 */

$page_title = "Dysendocrinies - VetoHub";
$body_class = "section-dysendocrinies structure-page";

include '../header.php';
require_once '../components_helper.php';

// Configuration des dysendocrinies
$dysendocrinies = [
    [
        'icon_img' => getIcon('diabete'),
        'title' => 'Diabète sucré',
        'description' => 'Diabète sucré en vétérinaire : étiologies, diagnostic et gestion thérapeutique',
        'link' => 'diabete_sucre/index.php'
    ],
    [
        'icon_img' => getIcon('thyroide'),
        'title' => 'Hypothyroïdie',
        'description' => 'Hypothyroïdie chez les animaux : signes cliniques, diagnostic et traitements hormonaux',
        'link' => 'hypothyroidie/index.php'
    ],
    [
        'icon_img' => getIcon('thyroide'),
        'title' => 'Hyperthyroïdie',
        'description' => 'Hyperthyroïdie féline et canine : manifestations et options thérapeutiques',
        'link' => 'hyperthyroidie/index.php'
    ],
    [
        'icon_img' => getIcon('reins'),
        'title' => 'Hyperadrénocorticisme',
        'description' => 'Maladie de Cushing : hyperadrénocorticisme spontané et iatrogène en vétérinaire',
        'link' => 'hyperadrenocorticisme/index.php'
    ],
    [
        'icon_img' => getIcon('reins'),
        'title' => 'Phéochromocytome',
        'description' => 'Phéochromocytome surrénalien : tumeur rare, diagnostic et prise en charge',
        'link' => 'pheochromocytome/index.php'
    ],
    [
        'icon_img' => getIcon('reins'),
        'title' => 'Hyperaldostéronisme',
        'description' => 'Hyperaldostéronisme primaire : syndrome de Conn chez le chat et le chien',
        'link' => 'hyperaldosteronisme/index.php'
    ]
];
?>

<?= renderPageHeader('Dysendocrinies', 'Dysendocrinies associées') ?>

<div class="container">
    <?php foreach ($dysendocrinies as $item): ?>
        <?= renderBubble($item) ?>
    <?php endforeach; ?>
</div>

<?php include '../footer.php'; ?>
