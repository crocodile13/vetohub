/* theme.js - Gestion du thème clair/sombre */

/**
 * Change le thème entre clair et sombre
 */
function toggleTheme() {
    const html = document.documentElement;
    const button = document.querySelector('.theme-toggle');
    
    if (!button) return;

    if (html.classList.contains('light')) {
        html.classList.replace('light', 'dark');
        localStorage.setItem('theme', 'dark');
        button.textContent = '☀️';
    } else {
        html.classList.replace('dark', 'light');
        localStorage.setItem('theme', 'light');
        button.textContent = '🌙';
    }
}

/**
 * Initialise le thème au chargement
 */
function initTheme() {
    const savedTheme = localStorage.getItem('theme');
    const html = document.documentElement;
    const button = document.querySelector('.theme-toggle');
    
    if (!button) return;

    if (savedTheme === 'dark') {
        html.classList.add('dark');
        html.classList.remove('light');
        button.textContent = '☀️';
    } else if (savedTheme === 'light') {
        html.classList.add('light');
        html.classList.remove('dark');
        button.textContent = '🌙';
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        html.classList.add('dark');
        html.classList.remove('light');
        button.textContent = '☀️';
    } else {
        html.classList.add('light');
        html.classList.remove('dark');
        button.textContent = '🌙';
    }
}

// Export pour utilisation globale
window.toggleTheme = toggleTheme;
window.initTheme = initTheme;
