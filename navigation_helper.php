<?php
/**
 * Système de navigation dynamique pour VetoHub
 * Génère automatiquement les breadcrumbs et thèmes selon la provenance
 */

class NavigationHelper {
    
    /**
     * Configuration de la structure du site
     */
    private static $siteStructure = [
        'index.php' => [
            'title' => '🏠 Accueil',
            'theme' => null
        ],
        
        'a_propos.php' => [
            'title' => 'À propos',
            'theme' => 'structure-page',
            'parent' => 'index.php'
        ],
        
        'remerciments.php' => [
            'title' => 'Remerciements',
            'theme' => 'structure-page',
            'parent' => 'index.php'
        ],
        
        'lesions_ocuaires/index.php' => [
            'title' => 'Lésions Oculaires',
            'theme' => 'section-lesions-oculaires',
            'parent' => 'index.php'
        ],
        
        'dysendocrinies/index.php' => [
            'title' => 'Dysendocrinies',
            'theme' => 'section-dysendocrinies',
            'parent' => 'index.php'
        ],
        
        'mecanismes_physiopathologiques/index.php' => [
            'title' => 'Mécanismes Physiopathologiques',
            'theme' => 'section-mecanismes',
            'parent' => 'index.php'
        ],
        
        'se_tester/index.php' => [
            'title' => 'Se Tester',
            'theme' => 'section-se-tester',
            'parent' => 'index.php'
        ],
        
        'dysendocrinies/hypothyroidie/index.php' => [
            'title' => 'Hypothyroïdie',
            'theme' => 'section-dysendocrinies',
            'parent' => 'dysendocrinies/index.php'
        ],
        
        'mecanismes_physiopathologiques/hyperlipidemie/index.php' => [
            'title' => 'Hyperlipidémie',
            'theme' => 'section-mecanismes',
            'parent' => 'mecanismes_physiopathologiques/index.php'
        ],
        
        'dysendocrinies/hypothyroidie/chambre_anterieure/index.php' => [
            'title' => 'Chambre Antérieure',
            'theme' => null,
            'parents' => [
                'dysendocrinies' => 'dysendocrinies/hypothyroidie/index.php',
                'mecanismes' => 'mecanismes_physiopathologiques/hyperlipidemie/index.php'
            ],
            'default_parent' => 'dysendocrinies'
        ],
        
        'lesions_ocuaires/cornee/index.php' => [
            'title' => 'Cornée',
            'theme' => 'section-lesions-oculaires',
            'parent' => 'lesions_ocuaires/index.php'
        ],
        
        'lesions_ocuaires/cornee/keratite_corneenne/index.php' => [
            'title' => 'Kératite Cornéenne',
            'theme' => 'section-lesions-oculaires',
            'parent' => 'lesions_ocuaires/cornee/index.php'
        ]
    ];
    
    /**
     * Détecte le contexte de navigation
     */
    public static function detectContext() {
        // 1. Paramètre GET
        if (isset($_GET['from'])) {
            return $_GET['from'];
        }
        
        // 2. Analyser le referer
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
            if (strpos($referer, 'dysendocrinies') !== false) return 'dysendocrinies';
            if (strpos($referer, 'mecanismes') !== false) return 'mecanismes';
            if (strpos($referer, 'lesions') !== false) return 'lesions';
        }
        
        // 3. Chemin actuel
        $currentPath = $_SERVER['SCRIPT_NAME'];
        if (strpos($currentPath, 'dysendocrinies') !== false) return 'dysendocrinies';
        if (strpos($currentPath, 'mecanismes') !== false) return 'mecanismes';
        if (strpos($currentPath, 'lesions') !== false) return 'lesions';
        
        return null;
    }
    
    /**
     * Construit le breadcrumb pour la page actuelle
     */
    public static function buildBreadcrumb($currentFile, $context = null) {
        if (!$context) {
            $context = self::detectContext();
        }
        
        // Normaliser le chemin
        $currentPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $currentFile);
        $currentPath = ltrim($currentPath, '/');
        
        // Récupérer la config
        $pageConfig = self::$siteStructure[$currentPath] ?? null;
        
        if (!$pageConfig) {
            return self::buildFallbackBreadcrumb($currentPath);
        }
        
        // Déterminer le parent
        $parentPath = null;
        if (isset($pageConfig['parents'])) {
            $parentPath = $pageConfig['parents'][$context] 
                       ?? $pageConfig['parents'][$pageConfig['default_parent']] 
                       ?? null;
        } else {
            $parentPath = $pageConfig['parent'] ?? null;
        }
        
        // Construire récursivement
        $breadcrumb = [];
        if ($parentPath) {
            // Calculer le chemin absolu du parent pour la récursion
            $parentAbsPath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($parentPath, '/');
            $breadcrumb = self::buildBreadcrumb($parentAbsPath, $context);
        }
        
        // Calculer le chemin relatif depuis la page actuelle vers cette page
        $currentScriptDir = dirname($_SERVER['SCRIPT_NAME']);
        $targetDir = dirname('/' . $currentPath);
        
        // Nombre de niveaux de profondeur actuelle
        $currentDepth = substr_count(trim($currentScriptDir, '/'), '/');
        
        // Nombre de niveaux de profondeur de la cible
        $targetDepth = substr_count(trim($targetDir, '/'), '/');
        
        // Calculer le chemin relatif
        $upLevels = $currentDepth - $targetDepth;
        $relativePath = ($upLevels > 0 ? str_repeat('../', $upLevels) : '') . basename($currentPath);
        
        // Ajouter la page actuelle
        $breadcrumb[] = [
            'title' => $pageConfig['title'],
            'link' => $relativePath
        ];
        
        return $breadcrumb;
    }
    
    /**
     * Construit un breadcrumb de secours
     */
    private static function buildFallbackBreadcrumb($path) {
        $parts = array_filter(explode('/', dirname($path)));
        $currentDepth = count(array_filter(explode('/', dirname($_SERVER['SCRIPT_NAME']))));
        
        $breadcrumb = [
            [
                'title' => '🏠 Accueil',
                'link' => ($currentDepth > 0 ? str_repeat('../', $currentDepth) : '') . 'index.php'
            ]
        ];
        
        foreach ($parts as $i => $part) {
            $upLevels = $currentDepth - ($i + 1);
            $downPath = implode('/', array_slice($parts, 0, $i + 1));
            
            $breadcrumb[] = [
                'title' => ucfirst(str_replace('_', ' ', $part)),
                'link' => ($upLevels > 0 ? str_repeat('../', $upLevels) : '') . $downPath . '/index.php'
            ];
        }
        
        return $breadcrumb;
    }
    
    /**
     * Détermine le thème selon le contexte
     */
    public static function getTheme($currentFile, $context = null) {
        if (!$context) {
            $context = self::detectContext();
        }
        
        $currentPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $currentFile);
        $currentPath = ltrim($currentPath, '/');
        
        $pageConfig = self::$siteStructure[$currentPath] ?? null;
        
        // Thème défini dans la config
        if ($pageConfig && !empty($pageConfig['theme'])) {
            return $pageConfig['theme'];
        }
        
        // Déduire du contexte
        $themes = [
            'dysendocrinies' => 'section-dysendocrinies',
            'mecanismes' => 'section-mecanismes',
            'lesions' => 'section-lesions-oculaires',
            'se_tester' => 'section-se-tester'
        ];
        
        return $themes[$context] ?? 'structure-page';
    }
    
    /**
     * Génère un lien avec contexte
     */
    public static function contextLink($targetPath, $context = null) {
        if (!$context) {
            $context = self::detectContext();
        }
        
        return $context ? $targetPath . '?from=' . urlencode($context) : $targetPath;
    }
}

/**
 * Fonction helper principale
 */
function getNavigation($currentFile) {
    $context = NavigationHelper::detectContext();
    
    return [
        'breadcrumbs' => NavigationHelper::buildBreadcrumb($currentFile, $context),
        'theme' => NavigationHelper::getTheme($currentFile, $context),
        'context' => $context
    ];
}

/**
 * Fonction pour créer un lien contextuel
 */
function contextLink($path) {
    return NavigationHelper::contextLink($path);
}
