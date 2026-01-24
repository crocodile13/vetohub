<?php
/**
 * Page Chambre Antérieure - Hypothyroïdie
 */

$page_title = "Chambre Antérieure - Hypothyroïdie - VetoHub";
$body_class = "section-dysendocrinies structure-page";
$breadcrumbs = [
    ['title' => 'Accueil', 'link' => '../../../index.php'],
    ['title' => 'Dysendocrinies', 'link' => '../../index.php'],
    ['title' => 'Hypothyroïdie', 'link' => '../index.php'],
    ['title' => 'Chambre Antérieure']
];

include '../../../header.php';
require_once '../../../components_helper.php';

// Flashcards avec image
$imageCards = [
    [
        'type' => 'image',
        'front' => getIllustration('humeur_aqueuse_lipide'),
        'back' => '<p>Humeur aqueuse chargée de lipide</p>'
    ]
];

// Flashcards texte
$textCards = [
    [
        'type' => 'text',
        'classes' => 'mecanismes-card',
        'front' => '<h3>Mécanismes physiopathologiques</h3>',
        'back' => '<p>L\'hypothyroïdie induit une hyperlipidémie par diminution du métabolisme lipidique et augmentation de la synthèse hépatique de cholestérol.</p>
                   <p>Cette dyslipidémie entraîne une accumulation de lipides dans l\'humeur aqueuse, provoquant une opacification de la chambre antérieure.</p>
                   <p>La réduction du métabolisme cellulaire affecte également la fonction de la barrière hémato-aqueuse.</p>'
    ],
    [
        'type' => 'text',
        'classes' => 'dysendocrinies-card',
        'front' => '<h3>Dysendocrinies associées</h3>',
        'back' => '<ul>
            <li>Diabète sucré</li>
            <li>Hyperadrénocorticisme</li>
        </ul>'
    ]
];
?>

<?= renderPageHeader('Chambre Antérieure', 'Manifestations de l\'hypothyroïdie au niveau de la chambre antérieure : accumulation lipidique et mécanismes associés') ?>

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
