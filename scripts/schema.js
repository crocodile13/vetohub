/* schema.js - Navigation contextuelle intelligente et sécurisée */

const SCHEMA_CONFIG = {
    structures: {
        "retine": { name: "Rétine", classes: ["cls-1"], color: "--c-retine" },
        "humeur-vitree": { name: "Humeur vitrée (corps vitré)", classes: ["cls-54","cls-37","cls-58","cls-53","cls-27","cls-35","cls-44","cls-10","cls-5"], color: "--c-humeur-vitree" },
        "cornee": { name: "Cornée", classes: ["cls-7"], color: "--c-cornee" },
        "nerf-optique": { name: "Nerf optique", classes: ["cls-9","cls-28","cls-39"], color: "--c-nerf-optique" },
        "chambre-anterieure": { name: "Chambre antérieure / Humeur aqueuse", classes: ["cls-52","cls-57","cls-30","cls-62","cls-47","cls-2","cls-15"], color: "--c-chambre-anterieure" },
        "macula": { name: "Macula", classes: ["cls-24","cls-4","cls-16"], color: "--c-macula" },
        "pupille": { name: "Pupille", classes: ["cls-21"], color: "--c-pupille" },
        "choroide": { name: "Choroïde", classes: ["cls-61","cls-13"], color: "--c-choroide" },
        "iris": { name: "Iris", classes: ["cls-23","cls-31","cls-36","cls-62"], color: "--c-iris" },
        "muscle-orbiculaire": { name: "Muscle orbiculaire", classes: ["cls-29","cls-32","cls-33","cls-49","cls-51","cls-6","cls-43","cls-45","cls-22","cls-19","cls-20"], color: "--c-muscle-orbiculaire" },
        "corps-ciliaires": { name: "Corps ciliaires et Zonule", classes: ["cls-12","cls-18","cls-59","cls-50","cls-41","cls-34","cls-26"], color: "--c-corps-ciliaires" },
        "cristallin": { name: "Cristallin", classes: ["cls-25","cls-42","cls-46","cls-11"], color: "--c-cristallin" },
        "veine": { name: "Veine", classes: ["cls-48"], color: "--c-veine" },
        "artere": { name: "Artère", classes: ["cls-55"], color: "--c-artere" },
        "sclere": { name: "Sclère", classes: ["cls-56"], color: "--c-sclere" },
        "papille": { name: "Papille (tête du nerf optique)", classes: ["cls-40","cls-60"], color: "--c-papille" }
    },
    navigationStructures: ['cornee', 'retine', 'nerf-optique', 'sclere', 'chambre-anterieure'],
    underlyingStructures: ['macula', 'papille', 'choroide'],
    
    // Routes contextuelles : mapping structure → page par contexte
    contextualRoutes: {
        'chambre-anterieure': {
            'dysendocrinies': 'dysendocrinies/hypothyroidie/chambre_anterieure/index.php',
            'mecanismes': 'dysendocrinies/hypothyroidie/chambre_anterieure/index.php',
            'default': 'dysendocrinies/hypothyroidie/chambre_anterieure/index.php'
        },
        'cornee': {
            'lesions': 'lesions_ocuaires/cornee/index.php',
            'default': 'cornee/index.php'
        },
        'retine': {
            'lesions': 'lesions_ocuaires/retine/index.php',
            'default': 'retine/index.php'
        },
        'nerf-optique': {
            'lesions': 'lesions_ocuaires/nerf_optique/index.php',
            'default': 'nerf_optique/index.php'
        },
        'sclere': {
            'lesions': 'lesions_ocuaires/sclere/index.php',
            'default': 'sclere/index.php'
        }
    }
};

class EyeSchema {
    constructor() {
        this.elements = {};
        this.svgWrapper = null;
        this.tooltip = null;
        this.mousePos = { x: 0, y: 0 };
        this.currentContext = this.detectContext();
    }

    /**
     * Détection robuste du contexte depuis plusieurs sources
     */
    detectContext() {
        // 1. Contexte passé par PHP (priorité max)
        if (window.CURRENT_CONTEXT && window.CURRENT_CONTEXT.trim()) {
            return window.CURRENT_CONTEXT.trim();
        }
        
        // 2. Paramètre URL
        const urlParams = new URLSearchParams(window.location.search);
        const fromParam = urlParams.get('from');
        if (fromParam && this.isValidContext(fromParam)) {
            return fromParam;
        }
        
        // 3. Déduire du chemin actuel
        const path = window.location.pathname;
        const validContexts = ['dysendocrinies', 'mecanismes', 'lesions', 'se_tester'];
        for (const ctx of validContexts) {
            if (path.includes(ctx)) {
                return ctx;
            }
        }
        
        return null;
    }

    /**
     * Valide qu'un contexte est légitime
     */
    isValidContext(context) {
        const valid = ['dysendocrinies', 'mecanismes', 'lesions', 'se_tester'];
        return valid.includes(context);
    }

    async load() {
        const wrapper = document.getElementById('eyeSchema');
        this.tooltip = document.getElementById('tooltip');
        
        if (!wrapper || !this.tooltip) {
            console.warn('⚠️ Éléments requis manquants');
            return;
        }

        try {
            const svgPath = `${window.BASE_URL || '/'}svg/schema_oeuil.svg`;
            const response = await fetch(svgPath, { cache: "no-store" });
            
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            wrapper.innerHTML = await response.text();
            this.init();
            console.log('✅ Schéma chargé');
        } catch (err) {
            console.error('❌ Erreur chargement schéma:', err);
            wrapper.innerHTML = `<p style='color:#ef4444;padding:2rem;text-align:center;'>⚠️ Erreur de chargement du schéma</p>`;
        }
    }

    init() {
        this.svgWrapper = document.querySelector('.svg-wrapper');
        if (!this.svgWrapper) {
            console.error('❌ SVG wrapper introuvable');
            return;
        }

        this.collectElements();
        this.cloneUnderlyingStructures();
        this.attachEvents();
        this.initSidePanel();

        const areaCount = document.querySelectorAll('.clickable-area').length;
        console.log(`✅ ${areaCount} zones interactives`);
        console.log(`📍 Contexte: ${this.currentContext || 'aucun'}`);
    }

    collectElements() {
        Object.entries(SCHEMA_CONFIG.structures).forEach(([id, config]) => {
            this.elements[id] = [];
            
            config.classes.forEach(className => {
                document.querySelectorAll(`.${className}`).forEach(el => {
                    if (!this.svgWrapper.contains(el)) return;
                    
                    el.classList.add('clickable-area');
                    el.dataset.structureId = id;
                    el.style.pointerEvents = 'all';
                    this.elements[id].push(el);
                });
            });
        });
    }

    cloneUnderlyingStructures() {
        SCHEMA_CONFIG.underlyingStructures.forEach(id => {
            (this.elements[id] || []).forEach(original => {
                try {
                    const clone = original.cloneNode(true);
                    clone.style.cssText = 'fill:transparent;stroke:none;pointer-events:all';
                    original.parentNode.appendChild(clone);
                    this.elements[id].push(clone);
                } catch (e) { 
                    console.warn(`⚠️ Impossible de cloner ${id}`);
                }
            });
        });
    }

    attachEvents() {
        Object.values(this.elements).flat().forEach(el => {
            const id = el.dataset.structureId;
            const group = this.elements[id] || [];
            const config = SCHEMA_CONFIG.structures[id];

            el.addEventListener('mouseenter', e => {
                this.mousePos = { x: e.clientX, y: e.clientY };
                this.showTooltip(config);
                this.highlight(group, id);
            });

            el.addEventListener('mousemove', e => {
                this.mousePos = { x: e.clientX, y: e.clientY };
                this.updateTooltipPosition();
            });
            
            el.addEventListener('mouseleave', () => {
                this.hideTooltip();
                this.unhighlight(group, id);
            });
            
            if (SCHEMA_CONFIG.navigationStructures.includes(id)) {
                el.addEventListener('click', () => this.navigate(id));
            }
        });
    }

    showTooltip(config) {
        if (!config) return;

        this.tooltip.textContent = config.name;
        
        const color = getComputedStyle(document.documentElement)
            .getPropertyValue(config.color).trim() || '#2563eb';
        
        this.tooltip.style.background = `linear-gradient(135deg, ${color}f0, rgba(30,41,59,0.95))`;
        this.tooltip.style.borderColor = `${color}80`;
        this.tooltip.classList.add('visible');

        this.updateTooltipPosition();
    }

    updateTooltipPosition() {
        const offset = 20;
        Object.assign(this.tooltip.style, {
            left: `${this.mousePos.x + offset}px`,
            top: `${this.mousePos.y + offset}px`
        });
    }

    hideTooltip() {
        this.tooltip.classList.remove('visible');
    }

    highlight(group, id) {
        group.forEach(el => el.classList.add('hover-active'));
        this.svgWrapper.classList.add('dimmed');
        
        const panelItem = document.querySelector(`.structure-item[data-id="${id}"]`);
        if (panelItem) panelItem.classList.add('highlighted');
    }

    unhighlight(group, id) {
        group.forEach(el => el.classList.remove('hover-active'));
        this.svgWrapper.classList.remove('dimmed');
        
        const panelItem = document.querySelector(`.structure-item[data-id="${id}"]`);
        if (panelItem) panelItem.classList.remove('highlighted');
    }

    /**
     * Navigation intelligente avec gestion contextuelle
     */
    navigate(id) {
        // Construire l'URL en fonction du contexte
        let targetUrl = this.buildContextualUrl(id);
        
        if (!targetUrl) {
            console.warn(`⚠️ Aucune route pour ${id}`);
            return;
        }
        
        console.log(`🔗 Navigation: ${id} → ${targetUrl}`);
        window.location.href = targetUrl;
    }

    /**
     * Construit l'URL en fonction du contexte actuel
     */
    buildContextualUrl(structureId) {
        const routes = SCHEMA_CONFIG.contextualRoutes[structureId];
        
        if (!routes) {
            // Pas de route spéciale, navigation standard
            const directory = structureId === 'nerf-optique' 
                ? 'nerf_optique' 
                : structureId.replace(/-/g, '_');
            return `${directory}/index.php`;
        }
        
        // Route contextuelle disponible
        let targetPath;
        
        if (this.currentContext && routes[this.currentContext]) {
            targetPath = routes[this.currentContext];
        } else {
            targetPath = routes.default || routes[Object.keys(routes)[0]];
        }
        
        // Calculer le chemin relatif depuis la page actuelle
        const currentPath = window.location.pathname;
        // FIX: Ne pas soustraire 1, on compte le nombre de dossiers à remonter
        const currentDepth = currentPath.split('/').filter(p => p && p !== 'index.php').length;
        
        // Remonter à la racine puis descendre vers la cible
        const upLevels = '../'.repeat(currentDepth);
        let finalUrl = upLevels + targetPath;
        
        // Ajouter le contexte si nécessaire
        if (this.currentContext && this.shouldPreserveContext(structureId)) {
            const separator = finalUrl.includes('?') ? '&' : '?';
            finalUrl += `${separator}from=${encodeURIComponent(this.currentContext)}`;
        }
        
        return finalUrl;
    }

    /**
     * Détermine si on doit préserver le contexte dans l'URL
     */
    shouldPreserveContext(structureId) {
        const routes = SCHEMA_CONFIG.contextualRoutes[structureId];
        
        // Si plusieurs contextes mènent à la même page, préserver le contexte
        if (routes) {
            const uniquePaths = new Set(Object.values(routes));
            return uniquePaths.size === 1 && Object.keys(routes).length > 2; // Plus d'un contexte + default
        }
        
        return false;
    }

    initSidePanel() {
        document.querySelectorAll('.structure-item').forEach(item => {
            const id = item.dataset.id;
            const config = SCHEMA_CONFIG.structures[id];
            
            if (!config) return;

            item.style.borderLeft = `6px solid var(${config.color})`;
            
            item.addEventListener('mouseenter', () => this.highlight(this.elements[id] || [], id));
            item.addEventListener('mouseleave', () => this.unhighlight(this.elements[id] || [], id));
            item.addEventListener('click', () => this.navigate(id));
        });
    }
}

// Initialisation sécurisée
const schema = new EyeSchema();
window.loadEyeSchema = () => schema.load();
window.initSchema = () => schema.init();
