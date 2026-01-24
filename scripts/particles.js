/* particles.js - Gestion des particules décoratives */

/**
 * Initialise les particules décoratives
 */
function initParticles() {
    const particlesContainer = document.getElementById('particles');
    
    if (!particlesContainer) return;

    // Nombre de particules
    const particleCount = 25;

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        
        // Position et animation aléatoires
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDuration = (Math.random() * 12 + 12) + 's';
        particle.style.animationDelay = Math.random() * 6 + 's';
        
        particlesContainer.appendChild(particle);
    }
}

// Export pour utilisation globale
window.initParticles = initParticles;
