<?php
/**
 * Template footer commun à toutes les pages
 */
require_once __DIR__ . '/config.php';
?>
<footer class="footer">
    <div style="margin-bottom: 15px;">
        <p style="font-size: 1rem; margin-bottom: 8px;">
            <strong><?= APP_NAME ?></strong> - <?= APP_TAGLINE ?>
        </p>
        <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 12px;">
            Projet de thèse de doctorat vétérinaire<br>
            <strong><?= APP_AUTHOR ?></strong> - <?= APP_INSTITUTION ?>
        </p>
    </div>
    <p style="font-size: 0.9rem;">
        © <?= date('Y') ?> <?= APP_NAME ?> - Tous droits réservés |
        <a href="<?= BASE_URL ?>a_propos.php" style="color: #6366f1; text-decoration: none;">À propos</a> |
        <a href="<?= BASE_URL ?>remerciments.php" style="color: #6366f1; text-decoration: none;">Remerciements</a>
    </p>
</footer>

<!-- Configuration globale pour JS -->
<script>
    window.BASE_URL = <?= json_encode(BASE_URL) ?>;
</script>

<!-- Scripts modulaires -->
<script src="<?= asset('scripts/utils.js') ?>" defer></script>
<script src="<?= asset('scripts/theme.js') ?>" defer></script>
<script src="<?= asset('scripts/particles.js') ?>" defer></script>
<?php if ($load_schema ?? false): ?>
<script src="<?= asset('scripts/schema.js') ?>" defer></script>
<?php endif; ?>
<script src="<?= asset('scripts/main.js') ?>" defer></script>

</body>
</html>
