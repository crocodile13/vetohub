<?php
/**
 * Système de navigation DYNAMIQUE pour VetoHub
 * Convention over Configuration - Inférence automatique de la structure
 */

class NavigationHelper {
    
    // ========================================
    // CONFIGURATION MINIMALE - Cas spéciaux uniquement
    // ========================================
    
    /**
     * Pages avec PLUSIEURS PARENTS possibles (cas rare)
     * C'est le SEUL endroit où il faut configurer manuellement
     */
    private static $multiParentPages = [
        'dysendocrinies/hypothyroidie/chambre_anterieure/index.php' => [
            'title' => 'Chambre Antérieure', // Optionnel, sinon inféré du dossier
            'parents' => [
                'dysendocrinies' => 'dysendocrinies/hypothyroidie/index.php',
                'mecanismes' => 'mecanismes_physiopathologiques/hyperlipidemie/index.php'
            ],
            'default_context' => 'dysendocrinies'
        ]
        // Ajouter d'autres pages multi-parents ici si besoin
    ];
    
    /**
     * Titres personnalisés (optionnel)
     * Si absent, le titre est généré depuis le nom du dossier
     */
    private static $customTitles = [
        'index.php' => '🏠 Accueil',
        'a_propos.php' => 'À propos',
        'remerciments.php' => 'Remerciements',
        'lesions_ocuaires' => 'Lésions Oculaires',
        'dysendocrinies' => 'Dysendocrinies',
        'mecanismes_physiopathologiques' => 'Mécanismes Physiopathologiques',
        'se_tester' => 'Se Tester',
        'hypothyroidie' => 'Hypothyroïdie',
        'hyperlipidemie' => 'Hyperlipidémie',
        'cornee' => 'Cornée',
        'keratite_corneenne' => 'Kératite Cornéenne'
    ];
    
    /**
     * Mapping contexte → thème CSS
     */
    private static $contextThemes = [
        'dysendocrinies' => 'section-dysendocrinies',
        'mecanismes' => 'section-mecanismes',
        'lesions' => 'section-lesions-oculaires',
        'se_tester' => 'section-se-tester'
    ];
    
    /**
     * Sections racines (pour détecter le contexte)
     */
    private static $rootSections = [
        'dysendocrinies',
        'mecanismes_physiopathologiques' => 'mecanismes', // mapping dossier → contexte
        'lesions_ocuaires' => 'lesions',
        'se_tester'
    ];
    
    // ========================================
    // MÉTHODES DYNAMIQUES
    // ========================================
    
    /**
     * Détecte le contexte de navigation
     */
    public static function detectContext() {
        // 1. Paramètre GET (priorité absolue)
        if (isset($_GET['from'])) {
            $context = self::sanitizeContext($_GET['from']);
            if ($context) {
                if (DEBUG_MODE) error_log("📍 Context détecté via GET: $context");
                return $context;
            }
        }
        
        // 2. Referer
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
            if ($referer) {
                $context = self::extractContextFromPath($referer);
                if ($context) {
                    if (DEBUG_MODE) error_log("📍 Context détecté via Referer: $context");
                    return $context;
                }
            }
        }
        
        // 3. Chemin actuel
        $currentPath = $_SERVER['SCRIPT_NAME'] ?? '';
        $context = self::extractContextFromPath($currentPath);
        
        if (DEBUG_MODE && $context) {
            error_log("📍 Context détecté via path: $context");
        }
        
        return $context;
    }
    
    /**
     * Extrait le contexte depuis un chemin
     */
    private static function extractContextFromPath($path) {
        $path = self::sanitizePath($path);
        
        // Chercher la section racine dans le chemin
        foreach (self::$rootSections as $folder => $context) {
            // Si c'est un mapping string → string
            if (is_string($folder)) {
                if (strpos($path, $folder) !== false) {
                    return $context;
                }
            }
            // Si c'est juste une valeur (folder === context)
            else {
                if (strpos($path, $context) !== false) {
                    return $context;
                }
            }
        }
        
        return null;
    }
    
    /**
     * Construit le breadcrumb DYNAMIQUEMENT
     */
    public static function buildBreadcrumb($currentFile, $context = null) {
        $context = self::sanitizeContext($context ?? self::detectContext());
        
        $currentPath = self::sanitizePath(
            str_replace($_SERVER['DOCUMENT_ROOT'], '', $currentFile)
        );
        
        if (DEBUG_MODE) {
            error_log("🔍 Building breadcrumb for: $currentPath | Context: " . ($context ?? 'none'));
        }
        
        // Limiter la récursion
        static $recursionDepth = 0;
        if ($recursionDepth > 10) {
            return [];
        }
        $recursionDepth++;
        
        // Cas spécial : page racine
        if ($currentPath === 'index.php' || $currentPath === '') {
            $recursionDepth--;
            return [[
                'title' => self::getPageTitle($currentPath),
                'link' => BASE_URL . 'index.php'
            ]];
        }
        
        // Vérifier si c'est une page multi-parents
        $parentPath = null;
        if (isset(self::$multiParentPages[$currentPath])) {
            $config = self::$multiParentPages[$currentPath];
            
            // Choisir le parent selon le contexte
            if ($context && isset($config['parents'][$context])) {
                $parentPath = $config['parents'][$context];
            } else {
                $defaultCtx = $config['default_context'] ?? array_key_first($config['parents']);
                $parentPath = $config['parents'][$defaultCtx];
            }
            
            if (DEBUG_MODE) {
                error_log("📍 Multi-parent page. Context: $context → Parent: $parentPath");
            }
        } else {
            // Détecter automatiquement le parent
            $parentPath = self::findParentPath($currentPath);
        }
        
        // Récursion pour construire le breadcrumb complet
        $breadcrumb = [];
        if ($parentPath) {
            $breadcrumb = self::buildBreadcrumb(
                $_SERVER['DOCUMENT_ROOT'] . '/' . $parentPath, 
                $context
            );
        }
        
        $recursionDepth--;
        
        // Ajouter la page actuelle
        $link = BASE_URL . $currentPath;
        
        // Préserver le contexte si nécessaire
        if ($context && self::shouldPreserveContext($currentPath, $context)) {
            $link .= '?from=' . urlencode($context);
        }
        
        $breadcrumb[] = [
            'title' => self::getPageTitle($currentPath),
            'link' => htmlspecialchars($link, ENT_QUOTES, 'UTF-8')
        ];
        
        return $breadcrumb;
    }
    
    /**
     * Trouve automatiquement le parent d'une page
     */
    private static function findParentPath($currentPath) {
        // Retirer le fichier pour obtenir le dossier
        $dir = dirname($currentPath);
        
        // Si on est à la racine
        if ($dir === '.' || $dir === '/') {
            return 'index.php';
        }
        
        // Le parent est le index.php du dossier parent
        $parentDir = dirname($dir);
        
        if ($parentDir === '.' || $parentDir === '/') {
            return 'index.php';
        }
        
        return $parentDir . '/index.php';
    }
    
    /**
     * Obtient le titre d'une page (custom ou généré)
     */
    private static function getPageTitle($path) {
        // Titre custom
        if (isset(self::$customTitles[$path])) {
            return self::$customTitles[$path];
        }
        
        // Vérifier dans multi-parents
        if (isset(self::$multiParentPages[$path]['title'])) {
            return self::$multiParentPages[$path]['title'];
        }
        
        // Générer depuis le nom du dossier/fichier
        $parts = array_filter(explode('/', $path));
        
        // Si c'est un index.php, prendre le nom du dossier
        if (end($parts) === 'index.php') {
            array_pop($parts);
        }
        
        $name = end($parts);
        
        // Vérifier si ce nom a un titre custom
        if (isset(self::$customTitles[$name])) {
            return self::$customTitles[$name];
        }
        
        // Générer un titre lisible
        $name = str_replace(['_', '-'], ' ', $name);
        $name = ucwords($name);
        
        return $name;
    }
    
    /**
     * Détermine si on doit préserver le contexte
     */
    private static function shouldPreserveContext($currentPath, $context) {
        if (!$context) return false;
        
        // Les pages multi-parents doivent toujours préserver le contexte
        if (isset(self::$multiParentPages[$currentPath])) {
            return true;
        }
        
        // Si on navigue dans un contexte différent du chemin physique
        $pathContext = self::extractContextFromPath($currentPath);
        
        if ($pathContext && $pathContext !== $context) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Détermine le thème CSS
     */
    public static function getTheme($currentFile, $context = null) {
        $context = self::sanitizeContext($context ?? self::detectContext());
        
        // Thème depuis le contexte
        if ($context && isset(self::$contextThemes[$context])) {
            return self::$contextThemes[$context];
        }
        
        return 'structure-page';
    }
    
    /**
     * Génère un lien avec contexte
     */
    public static function contextLink($targetPath, $context = null) {
        $targetPath = self::sanitizePath($targetPath);
        $context = self::sanitizeContext($context ?? self::detectContext());
        
        $link = BASE_URL . $targetPath;
        
        if ($context) {
            $link .= '?from=' . urlencode($context);
        }
        
        return htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Retourne le contexte actuel
     */
    public static function getCurrentContext() {
        return self::sanitizeContext(self::detectContext());
    }
    
    // ========================================
    // MÉTHODES UTILITAIRES (sécurité)
    // ========================================
    
    private static function sanitizeContext($context) {
        if (empty($context)) return null;
        
        $context = preg_replace('/[^a-z0-9_]/i', '', $context);
        
        $validContexts = array_merge(
            array_keys(self::$contextThemes),
            array_values(self::$contextThemes)
        );
        
        return in_array($context, $validContexts, true) ? $context : null;
    }
    
    private static function sanitizePath($path) {
        $path = str_replace(['../', '..\\'], '', $path);
        $path = preg_replace('/[^a-zA-Z0-9\/_.-]/', '', $path);
        $path = str_replace('\\', '/', $path);
        $path = preg_replace('#/+#', '/', $path);
        
        return trim($path, '/');
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
