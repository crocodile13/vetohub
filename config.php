<?php
/**
 * Configuration centrale de VetoHub OPTIMISÉE
 */

// Configuration
define('BASE_URL', '/');
define('ASSETS_VERSION', time());
define('DEBUG_MODE', false); // Mettre à false en production

// Informations
define('APP_NAME', 'VetoHub');
define('APP_TAGLINE', 'Plateforme éducative vétérinaire');
define('APP_AUTHOR', 'XXXXXXXXX');
define('APP_INSTITUTION', "École Nationale Vétérinaire d'Alfort (ENVA)");
define('APP_EMAIL', 'vetohub@contact.fr');

// Chemins images - Icônes
define('IMG_ICONS', [
    // ORGANS
    'cerveau' => ['images/icones/organs/cerveau.png', 'images/icones/organs/cerveau-humain.png', 'images/icones/organs/organe-cerebral.png'],
    'systeme_nerveux' => ['images/icones/organs/systeme-nerveux.png', 'images/icones/organs/neurone.png', 'images/icones/organs/spinal.png'],
    'thyroide' => ['images/icones/organs/thyroide.png', 'images/icones/organs/glande-thyroide.png'],
    'sang' => ['images/icones/organs/du-sang.png', 'images/icones/organs/cellules-sanguines.png', 'images/icones/organs/erythrocytes.png'],
    'vaisseaux_sanguins' => ['images/icones/organs/vaisseau-sanguin.png', 'images/icones/organs/veines.png'],
    'coeur' => ['images/icones/organs/coeur.png'],
    'estomac' => ['images/icones/organs/estomac.png'],
    'intestin' => ['images/icones/organs/intestin.png', 'images/icones/organs/intestin-grele.png', 'images/icones/organs/intestins.png'],
    'colon' => ['images/icones/organs/colon.png', 'images/icones/organs/gros-intestin.png'],
    'foie' => ['images/icones/organs/foie.png', 'images/icones/organs/organe-du-foie.png'],
    'pancreas' => ['images/icones/organs/pancreas.png'],
    'vesicule_biliaire' => ['images/icones/organs/vesicule-biliaire.png'],
    'poumons' => ['images/icones/organs/poumons.png', 'images/icones/organs/poumons-humains.png'],
    'bronches' => ['images/icones/organs/bronche.png'],
    'diaphragme' => ['images/icones/organs/diaphragme.png'],
    'reins' => ['images/icones/organs/reins.png', 'images/icones/organs/un-rein.png'],
    'vessie' => ['images/icones/organs/vessie.png'],
    'uterus' => ['images/icones/organs/uterus.png'],
    'ovaires' => ['images/icones/organs/ovaire.png', 'images/icones/organs/les-ovaires.png'],
    'testicules' => ['images/icones/organs/testicules.png', 'images/icones/organs/testicule.png'],
    'vagin' => ['images/icones/organs/vagin.png'],
    'spermatozoide' => ['images/icones/organs/spermatozoide.png', 'images/icones/organs/les-spermatozoides.png'],
    'peau' => ['images/icones/organs/peau.png', 'images/icones/organs/epiderme.png', 'images/icones/organs/derme.png', 'images/icones/organs/couches-de-peau.png'],
    'cheveux' => ['images/icones/organs/cheveux.png', 'images/icones/organs/follicule-de-cheveux.png'],
    'os' => ['images/icones/organs/os.png', 'images/icones/organs/des-os.png', 'images/icones/organs/os-humains.png'],
    'crane' => ['images/icones/organs/crane.png', 'images/icones/organs/le-crane.png'],
    'colonne_vertebrale' => ['images/icones/organs/colonne-vertebrale.png'],
    'squelette' => ['images/icones/organs/squelette.png'],
    'os_pelvien' => ['images/icones/organs/os-pelvien.png'],
    'muscles' => ['images/icones/organs/muscle.png', 'images/icones/organs/muscles.png', 'images/icones/organs/biceps.png'],
    'oeil' => ['images/icones/organs/oeil.png', 'images/icones/organs/globe-oculaire.png', 'images/icones/organs/retine.png'],
    'oreille' => ['images/icones/organs/oreille.png', 'images/icones/organs/oreilles.png', 'images/icones/organs/audition.png'],
    'nez' => ['images/icones/organs/nez.png'],
    'bouche' => ['images/icones/organs/bouche.png', 'images/icones/organs/bouche-ouverte.png'],
    'langue' => ['images/icones/organs/langue.png'],
    'dents' => ['images/icones/organs/dent.png', 'images/icones/organs/les-dents.png', 'images/icones/organs/dentier.png'],
    'adn' => ['images/icones/organs/adn.png', 'images/icones/organs/structure-de-ladn.png', 'images/icones/organs/brin-dadn.png'],
    'chromosomes' => ['images/icones/organs/chromosome.png'],
    'mitose' => ['images/icones/organs/mitose.png', 'images/icones/organs/la-division-cellulaire.png'],
    'micro_organismes' => ['images/icones/organs/micro-organisme.png', 'images/icones/organs/probiotique.png'],
    'corps_humain' => ['images/icones/organs/corps-humain.png', 'images/icones/organs/tete.png', 'images/icones/organs/cou.png', 'images/icones/organs/dos.png', 'images/icones/organs/ventre.png', 'images/icones/organs/pied.png', 'images/icones/organs/pieds.png'],
    
    // OTHER
    'diabete' => ['images/icones/other/diabete_sucree.png'],
    'dysendocrinie' => ['images/icones/other/dysendocrinie.png'],
    'physiopathologie' => ['images/icones/other/physiopathologie.png'],
    'evaluation' => ['images/icones/other/evaluation.png', 'images/icones/other/evaluation_alt.png']
]);

// Chemins images - Illustrations
define('IMG_ILLUSTRATIONS', [
    'cornee_depolie' => BASE_URL . 'images/illustrations/cornee_depolie.webp',
    'melanose_corneenne' => BASE_URL . 'images/illustrations/melanose_corneenne.webp',
    'neovascularisation' => BASE_URL . 'images/illustrations/neovascularisation_superficielle.webp',
    'oedeme_corneen' => BASE_URL . 'images/illustrations/oedeme_corneen.webp',
    'humeur_aqueuse_lipide' => BASE_URL . 'images/illustrations/humeur_aqueuse_lipide.webp',
]);

/**
 * Retourne la PREMIÈRE URL EXISTANTE avec BASE_URL - OPTIMISÉE
 */
function getIcon($key) {
    $icons = IMG_ICONS[$key] ?? null;
    if (!$icons) return null;
    
    $iconPaths = is_array($icons) ? $icons : [$icons];
    
    foreach ($iconPaths as $iconPath) {
        if (file_exists(__DIR__ . '/' . ltrim($iconPath, '/'))) {
            return BASE_URL . ltrim($iconPath, '/');
        }
    }
    
    return null;
}

function getIllustration($key) {
    return IMG_ILLUSTRATIONS[$key] ?? '';
}

function asset($path) {
    return BASE_URL . ltrim($path, '/') . '?v=' . ASSETS_VERSION;
}
