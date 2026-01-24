/* utils.js - Fonctions utilitaires globales */

/**
 * Navigation vers une page
 * @param {string} page - Chemin de la page
 */
window.navigateTo = function(page) {
    window.location.href = page;
};

/**
 * Attend que le DOM soit chargé
 * @param {Function} callback - Fonction à exécuter
 */
window.onDOMReady = function(callback) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', callback);
    } else {
        callback();
    }
};

/**
 * Debounce une fonction
 * @param {Function} func - Fonction à debouncer
 * @param {number} wait - Délai en ms
 */
window.debounce = function(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};
