<?php
/**
 * Page Hypothyroïdie avec schéma interactif
 */

$page_title = "Hypothyroïdie - VetoHub";
$body_class = "section-dysendocrinies structure-page";
$load_schema = true;

include __DIR__ . '/../../header.php';
require_once __DIR__ . '/../../components_helper.php';

// Configuration des structures pour l'hypothyroïdie
$structures = [
    ['id' => 'chambre-anterieure', 'label' => 'Chambre antérieure'],
    ['id' => 'cornee', 'label' => 'Cornée'],
    ['id' => 'conjonctive', 'label' => 'Conjonctive'],
    ['id' => 'nerf-optique', 'label' => 'Nerf optique'],
    ['id' => 'retine', 'label' => 'Rétine']
];
?>

<div class="header" style="margin-top: 120px;">
    <h1>Hypothyroïdie</h1>
    <p>Manifestations oculaires de l'hypothyroïdie en médecine vétérinaire</p>
</div>

<div class="schema-container">
    <div class="svg-container">
        <div class="svg-wrapper" id="eyeSchema"></div>
    </div>

    <div class="info-panel">
        <h2 class="info-panel-title">Structures affectées</h2>
        <?php foreach ($structures as $structure): ?>
            <div class="structure-item" data-id="<?= $structure['id'] ?>">
                <?= $structure['label'] ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="tooltip" class="tooltip"></div>

<?php include __DIR__ . '/../../footer.php'; ?>
