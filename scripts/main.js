/* main.js - Script principal d'initialisation */

/**
 * Initialisation globale de l'application
 */
document.addEventListener('DOMContentLoaded', () => {
    // Initialiser le thème
    if (typeof initTheme === 'function') {
        initTheme();
        
        const toggleButton = document.querySelector('.theme-toggle');
        if (toggleButton && typeof toggleTheme === 'function') {
            toggleButton.addEventListener('click', toggleTheme);
        }
    }

    // Initialiser les particules
    if (typeof initParticles === 'function') {
        initParticles();
    }

    // Charger le schéma si présent
    const eyeSchemaWrapper = document.getElementById('eyeSchema');
    if (eyeSchemaWrapper && typeof loadEyeSchema === 'function') {
        loadEyeSchema();
    }
    
    console.log('VetoHub initialisé avec succès');
});
