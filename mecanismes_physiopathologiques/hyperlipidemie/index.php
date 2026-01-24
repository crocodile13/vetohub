<?php
/**
 * Page Hyperlipidémie avec schéma interactif
 */

$page_title = "Hyperlipidémie - VetoHub";
$body_class = "section-mecanismes structure-page";
$load_schema = true;
$breadcrumbs = [
    ['title' => 'Accueil', 'link' => '../../index.php'],
    ['title' => 'Mécanismes Physiopathologiques', 'link' => '../index.php'],
    ['title' => 'Hyperlipidémie']
];

include __DIR__ . '/../../header.php';
require_once __DIR__ . '/../../components_helper.php';

// Configuration des structures affectées par l'hyperlipidémie
$structures = [
    ['id' => 'chambre-anterieure', 'label' => 'Chambre antérieure'],
    ['id' => 'cornee', 'label' => 'Cornée'],
    ['id' => 'retine', 'label' => 'Rétine']
];
?>

<div class="header" style="margin-top: 120px;">
    <h1>Hyperlipidémie</h1>
    <p>Manifestations oculaires de l'hyperlipidémie en médecine vétérinaire</p>
</div>

<div class="schema-container">
    <div class="svg-container">
        <div class="svg-wrapper" id="eyeSchema"></div>
    </div>

    <div class="info-panel">
        <h2 style="margin-bottom:1.6rem; color:#d1d5db;">Structures affectées</h2>
        <?php foreach ($structures as $structure): ?>
            <div class="structure-item" data-id="<?= $structure['id'] ?>">
                <?= $structure['label'] ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="tooltip" class="tooltip"></div>

<?php include __DIR__ . '/../../footer.php'; ?>
