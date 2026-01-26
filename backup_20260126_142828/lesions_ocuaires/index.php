<?php
/**
 * Page Lésions Oculaires avec schéma interactif
 */

$page_title = "Lésions Oculaires - VetoHub";
$body_class = "structure-page";
$load_schema = true;

include __DIR__ . '/../header.php';
require_once __DIR__ . '/../components_helper.php';

// Configuration des structures
$structures = [
    ['id' => 'cornee', 'label' => 'Cornée'],
    ['id' => 'retine', 'label' => 'Rétine'],
    ['id' => 'nerf-optique', 'label' => 'Nerf optique'],
    ['id' => 'sclere', 'label' => 'Sclère']
];
?>

<div class="header" style="margin-top: 120px;">
    <h1>Lésions Oculaires</h1>
    <p>Explorez interactivement les lésions oculaires en médecine vétérinaire</p>
</div>

<div class="schema-container">
    <div class="svg-container">
        <div class="svg-wrapper" id="eyeSchema"></div>
    </div>

    <div class="info-panel">
        <h2 class="info-panel-title">Lésions Oculaires</h2>
        <?php foreach ($structures as $structure): ?>
            <div class="structure-item" data-id="<?= $structure['id'] ?>">
                <?= $structure['label'] ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="tooltip" class="tooltip"></div>

<?php include __DIR__ . '/../footer.php'; ?>
