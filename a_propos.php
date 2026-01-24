<?php
/**
 * Page À propos de VetoHub
 */

$page_title = "À propos - VetoHub";
$body_class = "structure-page";
$breadcrumbs = [
    ['title' => 'Accueil', 'link' => 'index.php'],
    ['title' => 'À propos']
];

include 'header.php';
require_once 'components_helper.php';

// Configuration des cartes
$aboutCards = [
    [
        'type' => 'text',
        'front' => '<h3>🎓 Origine du projet</h3>',
        'back' => '<p>VetoHub est né dans le cadre de la thèse de doctorat vétérinaire de <strong>' . APP_AUTHOR . '</strong>, réalisée à ' . APP_INSTITUTION . '.</p>
                   <p>Ce projet vise à faciliter l\'apprentissage et la compréhension des pathologies vétérinaires grâce à des outils interactifs et visuels.</p>'
    ],
    [
        'type' => 'text',
        'front' => '<h3>🎯 Objectifs pédagogiques</h3>',
        'back' => '<ul>
            <li>Fournir un atlas visuel complet des lésions oculaires</li>
            <li>Faciliter la compréhension des dysendocrinies</li>
            <li>Proposer des outils d\'auto-évaluation interactifs</li>
            <li>Expliquer les mécanismes physiopathologiques</li>
        </ul>'
    ],
    [
        'type' => 'text',
        'front' => '<h3>💡 Approche innovante</h3>',
        'back' => '<p>VetoHub utilise des technologies web modernes pour créer une expérience d\'apprentissage immersive :</p>
                   <ul>
                       <li>Schémas anatomiques interactifs</li>
                       <li>Cartes à retourner (flashcards)</li>
                       <li>Navigation intuitive et responsive</li>
                       <li>Mode clair/sombre pour le confort visuel</li>
                   </ul>'
    ],
    [
        'type' => 'text',
        'front' => '<h3>🔬 Contenu scientifique</h3>',
        'back' => '<p>Tous les contenus présentés sur VetoHub sont basés sur des références scientifiques vétérinaires actualisées et validées par des experts du domaine.</p>
                   <p>La plateforme est régulièrement mise à jour pour refléter les dernières avancées en médecine vétérinaire.</p>'
    ],
    [
        'type' => 'text',
        'front' => '<h3>👥 Public cible</h3>',
        'back' => '<ul>
            <li>Étudiants vétérinaires en formation initiale</li>
            <li>Vétérinaires praticiens souhaitant actualiser leurs connaissances</li>
            <li>Internes et résidents en ophtalmologie vétérinaire</li>
            <li>Auxiliaires spécialisés vétérinaires (ASV)</li>
        </ul>'
    ],
    [
        'type' => 'text',
        'front' => '<h3>📧 Contact</h3>',
        'back' => '<p>Pour toute question, suggestion ou remarque concernant VetoHub, n\'hésitez pas à nous contacter.</p>
                   <p><strong>Email :</strong> ' . APP_EMAIL . '</p>
                   <p>Vos retours nous aident à améliorer continuellement la plateforme.</p>'
    ]
];
?>

<?= renderPageHeader('À propos de VetoHub', 'Plateforme éducative pour vétérinaires et étudiants vétérinaires') ?>

<div class="flip-card-container text-cards">
    <?php foreach ($aboutCards as $card): ?>
        <?= renderFlipCard($card) ?>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>
