<?php
/**
 * Page Kératite Cornéenne
 */

$page_title = "Kératite Cornéenne - VetoHub";
$body_class = "section-lesions-oculaires structure-page";
$breadcrumbs = [
    ['title' => 'Accueil', 'link' => '../../../index.php'],
    ['title' => 'Lésions Oculaires', 'link' => '../../index.php'],
    ['title' => 'Cornée', 'link' => '../index.php'],
    ['title' => 'Kératite Cornéenne']
];

include '../../../header.php';
require_once '../../../components_helper.php';

// Flashcards avec images
$imageCards = [
    [
        'type' => 'image',
        'front' => getIllustration('cornee_depolie'),
        'back' => '<p>Cornée dépolie</p>'
    ],
    [
        'type' => 'image',
        'front' => getIllustration('neovascularisation'),
        'back' => '<p>Néovascularisation superficielle</p>'
    ],
    [
        'type' => 'image',
        'front' => getIllustration('melanose_corneenne'),
        'back' => '<p>Mélanose cornéenne</p>'
    ],
    [
        'type' => 'image',
        'front' => getIllustration('oedeme_corneen'),
        'back' => '<p>Œdème cornéen</p>'
    ]
];

// Flashcards texte
$textCards = [
    [
        'type' => 'text',
        'classes' => 'dysendocrinies-card',
        'front' => '<h3>Dysendocrinies associées ?</h3>',
        'back' => '<ul>
            <li>Diabète sucré</li>
            <li>Hypothyroïdie</li>
            <li>Hyperadrénocorticisme</li>
        </ul>'
    ],
    [
        'type' => 'text',
        'classes' => 'mecanismes-card',
        'front' => '<h3>Mécanismes physiopathologiques</h3>',
        'back' => '<p>Hyperglycémie engendre : polyneuropathie, altération du film lacrymal…</p>
                   <p>Pas les mêmes mécanismes pour Cushing et hypothyroïdie.</p>'
    ]
];
?>

<?= renderPageHeader('Kératite Cornéenne', 'Inflammation de la cornée en ophtalmologie vétérinaire : étiologies, signes cliniques et traitements') ?>

<div class="flip-card-container">
    <?php foreach ($imageCards as $card): ?>
        <?= renderFlipCard($card) ?>
    <?php endforeach; ?>
</div>

<div class="flip-card-container text-cards">
    <?php foreach ($textCards as $card): ?>
        <?= renderFlipCard($card) ?>
    <?php endforeach; ?>
</div>

<?php include '../../../footer.php'; ?>
