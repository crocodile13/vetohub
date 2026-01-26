<?php
/**
 * Page de remerciements
 */

$page_title = "Remerciements - VetoHub";
$body_class = "structure-page";
$breadcrumbs = [
    ['title' => 'Accueil', 'link' => 'index.php'],
    ['title' => 'Remerciements']
];

include 'header.php';
require_once 'components_helper.php';

// Configuration des cartes de remerciements
$thanksCards = [
    ['front' => '<h3>🎓 Direction de thèse</h3>', 'back' => '<p>Mes sincères remerciements à mon directeur/ma directrice de thèse pour son encadrement, ses conseils avisés et son soutien tout au long de ce projet.</p><p>Votre expertise et votre disponibilité ont été essentielles à la réalisation de ce travail.</p>'],
    ['front' => '<h3>🏥 ' . APP_INSTITUTION . '</h3>', 'back' => '<p>Un grand merci à l\'ENVA pour la formation d\'excellence qu\'elle dispense et pour avoir permis la réalisation de ce projet de thèse.</p><p>Merci également à l\'ensemble du corps enseignant pour leur transmission de savoir et leur passion.</p>'],
    ['front' => '<h3>👨‍⚕️ Service d\'Ophtalmologie</h3>', 'back' => '<p>Merci à toute l\'équipe du service d\'ophtalmologie vétérinaire pour leur accueil, leur pédagogie et le partage de leur expérience clinique.</p><p>Les cas cliniques présentés sur cette plateforme sont le fruit de votre expertise quotidienne.</p>'],
    ['front' => '<h3>📚 Contributeurs scientifiques</h3>', 'back' => '<p>Merci à tous les praticiens et chercheurs qui ont contribué à la validation scientifique des contenus de VetoHub.</p><p>Votre relecture attentive et vos suggestions ont grandement enrichi cette plateforme.</p>'],
    ['front' => '<h3>🖼️ Ressources visuelles</h3>', 'back' => '<p>Merci aux photographes, illustrateurs et services d\'imagerie qui ont permis l\'utilisation de leurs ressources visuelles.</p><p>Les images illustrant les différentes pathologies sont essentielles à la dimension pédagogique de VetoHub.</p>'],
    ['front' => '<h3>💻 Développement technique</h3>', 'back' => '<p>Un remerciement particulier pour l\'assistance technique dans le développement de cette plateforme interactive.</p><p>Votre expertise a permis de transformer une vision pédagogique en une réalité numérique accessible.</p>'],
    ['front' => '<h3>👨‍👩‍👧‍👦 Famille et proches</h3>', 'back' => '<p>Merci à ma famille et à mes proches pour leur soutien indéfectible durant toutes ces années d\'études.</p><p>Votre patience, vos encouragements et votre confiance ont été des piliers essentiels de ma réussite.</p>'],
    ['front' => '<h3>🐾 Promotion vétérinaire</h3>', 'back' => '<p>Merci à mes camarades de promotion pour ces années d\'études partagées, pour l\'entraide et les moments de convivialité.</p><p>C\'est ensemble que nous avons grandi professionnellement et humainement.</p>'],
    ['front' => '<h3>🐕 Patients à quatre pattes</h3>', 'back' => '<p>Enfin, une pensée particulière pour tous les animaux qui, par leur confiance et leur résilience, nous permettent d\'apprendre et de progresser.</p><p>C\'est pour améliorer leurs soins que nous nous formons chaque jour.</p>']
];
?>

<?= renderPageHeader('Remerciements', 'Aux personnes qui ont rendu ce projet possible') ?>

<div class="flip-card-container text-cards">
    <?php foreach ($thanksCards as $card): ?>
        <?= renderFlipCard(array_merge($card, ['type' => 'text'])) ?>
    <?php endforeach; ?>
</div>

<?php include 'footer.php'; ?>
