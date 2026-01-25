<?php
/**
 * Système de navigation dynamique pour VetoHub - SÉCURISÉ ET CORRIGÉ
 * FIX: Utilise des liens absolus pour éviter les bugs de liens relatifs
 */

class NavigationHelper {
    
    private static $siteStructure = [
        'index.php' => ['title' => '🏠 Accueil', 'theme' => null],
        'a_propos.php' => ['title' => 'À propos', 'theme' => 'structure-page', 'parent' => 'index.php'],
        'remerciments.php' => ['title' => 'Remerciements', 'theme' => 'structure-page', 'parent' => 'index.php'],
        'lesions_ocuaires/index.php' => ['title' => 'Lésions Oculaires', 'theme' => 'section-lesions-oculaires', 'parent' => 'index.php'],
        'dysendocrinies/index.php' => ['title' => 'Dysendocrinies', 'theme' => 'section-dysendocrinies', 'parent' => 'index.php'],
        'mecanismes_physiopathologiques/index.php' => ['title' => 'Mécanismes Physiopathologiques', 'theme' => 'section-mecanismes', 'parent' => 'index.php'],
        'se_tester/index.php' => ['title' => 'Se Tester', 'theme' => 'section-se-tester', 'parent' => 'index.php'],
        'dysendocrinies/hypothyroidie/index.php' => ['title' => 'Hypothyroïdie', 'theme' => 'section-dysendocrinies', 'parent' => 'dysendocrinies/index.php'],
        'mecanismes_physiopathologiques/hyperlipidemie/index.php' => ['title' => 'Hyperlipidémie', 'theme' => 'section-mecanismes', 'parent' => 'mecanismes_physiopathologiques/index.php'],
        'dysendocrinies/hypothyroidie/chambre_anterieure/index.php' => [
            'title' => 'Chambre Antérieure',
            'theme' => null,
            'parents' => [
                'dysendocrinies' => 'dysendocrinies/hypothyroidie/index.php',
                'mecanismes' => 'mecanismes_physiopathologiques/hyperlipidemie/index.php'
            ],
            'default_parent' => 'dysendocrinies'
        ],
        'lesions_ocuaires/cornee/index.php' => ['title' => 'Cornée', 'theme' => 'section-lesions-oculaires', 'parent' => 'lesions_ocuaires/index.php'],
        'lesions_ocuaires/cornee/keratite_corneenne/index.php' => ['title' => 'Kératite Cornéenne', 'theme' => 'section-lesions-oculaires', 'parent' => 'lesions_ocuaires/cornee/index.php']
    ];
    
    private static $themes = [
        'dysendocrinies' => 'section-dysendocrinies',
        'mecanismes' => 'section-mecanismes',
        'lesions' => 'section-lesions-oculaires',
        'se_tester' => 'section-se-tester'
    ];
    
    // LISTE BLANCHE des contextes valides
    private static $validContexts = ['dysendocrinies', 'mecanismes', 'lesions', 'se_tester'];
    
    /**
     * Sanitize et valide un contexte
     */
    private static function sanitizeContext($context) {
        if (empty($context)) return null;
        
        // Supprimer tout ce qui n'est pas alphanumérique ou underscore
        $context = preg_replace('/[^a-z0-9_]/i', '', $context);
        
        // Vérifier que c'est dans la liste blanche
        return in_array($context, self::$validContexts, true) ? $context : null;
    }
    
    /**
     * Sanitize un chemin de fichier
     */
    private static function sanitizePath($path) {
        // Supprimer les tentatives de path traversal
        $path = str_replace(['../', '..\\', '../', '..\\'], '', $path);
        
        // Ne garder que les caractères valides pour un chemin
        $path = preg_replace('/[^a-zA-Z0-9\/_.-]/', '', $path);
        
        // Normaliser les slashes
        $path = str_replace('\\', '/', $path);
        
        // Supprimer les slashes multiples
        $path = preg_replace('#/+#', '/', $path);
        
        return trim($path, '/');
    }
    
    /**
     * Valide qu'un chemin existe dans la structure du site
     */
    private static function isValidPath($path) {
        // Vérifier dans la structure connue
        if (isset(self::$siteStructure[$path])) {
            return true;
        }
        
        // Vérifier que le fichier existe physiquement
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
        if (file_exists($fullPath) && is_file($fullPath)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Détecte le contexte de navigation - SÉCURISÉ ET OPTIMISÉ
     */
    public static function detectContext() {
        // 1. Paramètre GET (priorité absolue)
        if (isset($_GET['from'])) {
            $context = self::sanitizeContext($_GET['from']);
            if ($context) {
                if (DEBUG_MODE) error_log("Context détecté via GET: $context");
                return $context;
            }
        }
        
        // 2. Referer (deuxième priorité)
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
            if ($referer) {
                // Priorité : chercher le contexte le plus spécifique en premier
                foreach (self::$validContexts as $ctx) {
                    if (strpos($referer, $ctx) !== false) {
                        if (DEBUG_MODE) error_log("Context détecté via Referer: $ctx");
                        return $ctx;
                    }
                }
            }
        }
        
        // 3. Chemin actuel (dernière priorité)
        $currentPath = self::sanitizePath($_SERVER['SCRIPT_NAME'] ?? '');
        
        // Compter combien de contextes sont dans le chemin
        $matchingContexts = [];
        foreach (self::$validContexts as $ctx) {
            if (strpos($currentPath, $ctx) !== false) {
                $matchingContexts[] = $ctx;
            }
        }
        
        // Si un seul contexte trouvé, c'est clair
        if (count($matchingContexts) === 1) {
            if (DEBUG_MODE) error_log("Context détecté via path: {$matchingContexts[0]}");
            return $matchingContexts[0];
        }
        
        // Si plusieurs contextes, prendre le plus profond (dernier dans le chemin)
        if (count($matchingContexts) > 1) {
            $deepest = null;
            $deepestPos = -1;
            
            foreach ($matchingContexts as $ctx) {
                $pos = strrpos($currentPath, $ctx);
                if ($pos > $deepestPos) {
                    $deepestPos = $pos;
                    $deepest = $ctx;
                }
            }
            
            if (DEBUG_MODE) error_log("Context détecté via path (multiple, deepest): $deepest");
            return $deepest;
        }
        
        if (DEBUG_MODE) error_log("Aucun context détecté");
        return null;
    }
    
    /**
     * Construit le breadcrumb - CORRIGÉ : utilise des liens ABSOLUS
     */
    public static function buildBreadcrumb($currentFile, $context = null) {
        // Sanitize le contexte
        $context = self::sanitizeContext($context ?? self::detectContext());
        
        if (DEBUG_MODE && $context) {
            error_log("🔍 Building breadcrumb with context: $context");
        }
        
        // Sanitize et valider le chemin du fichier
        $currentPath = self::sanitizePath(
            str_replace($_SERVER['DOCUMENT_ROOT'], '', $currentFile)
        );
        
        // Limiter la profondeur de récursion pour éviter les DoS
        static $recursionDepth = 0;
        if ($recursionDepth > 10) {
            return [];
        }
        $recursionDepth++;
        
        $pageConfig = self::$siteStructure[$currentPath] ?? null;
        if (!$pageConfig) {
            $recursionDepth--;
            return self::buildFallbackBreadcrumb($currentPath);
        }
        
        // Déterminer le parent - SÉCURISÉ
        $parentPath = null;
        if (isset($pageConfig['parents'])) {
            $parentPath = $pageConfig['parents'][$context] 
                       ?? $pageConfig['parents'][$pageConfig['default_parent']] 
                       ?? null;
            
            if (DEBUG_MODE) {
                error_log("📍 Page with multiple parents. Context: $context, Chosen parent: " . ($parentPath ?? 'none'));
            }
        } else {
            $parentPath = $pageConfig['parent'] ?? null;
        }
        
        // Valider le chemin parent
        if ($parentPath && !self::isValidPath($parentPath)) {
            $parentPath = null;
        }
        
        // Récursion si parent existe
        $breadcrumb = $parentPath 
            ? self::buildBreadcrumb($_SERVER['DOCUMENT_ROOT'] . '/' . $parentPath, $context)
            : [];
        
        $recursionDepth--;
        
        // ✨ FIX PRINCIPAL : Utiliser un lien ABSOLU depuis BASE_URL
        $link = BASE_URL . $currentPath;
        
        // Ajouter le paramètre from si on est dans un contexte et qu'il doit être préservé
        if ($context && self::shouldPreserveBreadcrumbContext($currentPath, $context)) {
            $link .= '?from=' . urlencode($context);
        }
        
        $breadcrumb[] = [
            'title' => htmlspecialchars($pageConfig['title'], ENT_QUOTES, 'UTF-8'), 
            'link' => htmlspecialchars($link, ENT_QUOTES, 'UTF-8')
        ];
        
        return $breadcrumb;
    }
    
    /**
     * Construit un breadcrumb de secours - SIMPLIFIÉ
     */
    private static function buildFallbackBreadcrumb($path) {
        // Sanitize le chemin
        $path = self::sanitizePath($path);
        
        $parts = array_filter(explode('/', dirname($path)));
        
        $breadcrumb = [[
            'title' => htmlspecialchars('🏠 Accueil', ENT_QUOTES, 'UTF-8'),
            'link' => htmlspecialchars(BASE_URL . 'index.php', ENT_QUOTES, 'UTF-8')
        ]];
        
        $currentPath = '';
        foreach ($parts as $part) {
            // Sanitize chaque partie du chemin
            $part = preg_replace('/[^a-zA-Z0-9_-]/', '', $part);
            
            $currentPath .= $part . '/';
            
            $breadcrumb[] = [
                'title' => htmlspecialchars(ucfirst(str_replace('_', ' ', $part)), ENT_QUOTES, 'UTF-8'),
                'link' => htmlspecialchars(BASE_URL . $currentPath . 'index.php', ENT_QUOTES, 'UTF-8')
            ];
        }
        
        return $breadcrumb;
    }
    
    /**
     * Détermine si on doit préserver le contexte dans l'URL
     */
    public static function shouldPreserveBreadcrumbContext($currentPath, $context) {
        if (!$context) return false;
        
        $pageConfig = self::$siteStructure[$currentPath] ?? null;
        
        // Si la page a plusieurs parents possibles, préserver le contexte
        if ($pageConfig && isset($pageConfig['parents'])) {
            return true;
        }
        
        // Si on navigue dans un contexte différent de la structure physique
        $pathContexts = [];
        if (strpos($currentPath, 'dysendocrinies') !== false) $pathContexts[] = 'dysendocrinies';
        if (strpos($currentPath, 'mecanismes') !== false) $pathContexts[] = 'mecanismes';
        if (strpos($currentPath, 'lesions') !== false) $pathContexts[] = 'lesions';
        if (strpos($currentPath, 'se_tester') !== false) $pathContexts[] = 'se_tester';
        
        // Si le contexte actuel ne correspond pas au chemin physique, préserver
        if (!empty($pathContexts) && !in_array($context, $pathContexts, true)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Détermine le thème - SÉCURISÉ
     */
    public static function getTheme($currentFile, $context = null) {
        $context = self::sanitizeContext($context ?? self::detectContext());
        $currentPath = self::sanitizePath(
            str_replace($_SERVER['DOCUMENT_ROOT'], '', $currentFile)
        );
        
        $pageConfig = self::$siteStructure[$currentPath] ?? null;
        
        // Thème défini dans la config
        if ($pageConfig && !empty($pageConfig['theme'])) {
            // Sanitize le thème (whitelist)
            $theme = $pageConfig['theme'];
            $validThemes = array_merge(
                array_values(self::$themes),
                ['structure-page', 'index-page']
            );
            return in_array($theme, $validThemes, true) ? $theme : 'structure-page';
        }
        
        // Déduire du contexte
        return self::$themes[$context] ?? 'structure-page';
    }
    
    /**
     * Génère un lien avec contexte - SÉCURISÉ
     */
    public static function contextLink($targetPath, $context = null) {
        // Sanitize le chemin
        $targetPath = self::sanitizePath($targetPath);
        
        // Sanitize le contexte
        $context = self::sanitizeContext($context ?? self::detectContext());
        
        // Utiliser un lien absolu
        $link = BASE_URL . $targetPath;
        
        if ($context) {
            $link .= '?from=' . urlencode($context);
        }
        
        return htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Retourne le contexte actuel (pour JS)
     */
    public static function getCurrentContext() {
        return self::sanitizeContext(self::detectContext());
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
