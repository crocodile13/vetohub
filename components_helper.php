<?php
/**
 * Helpers pour générer des composants HTML réutilisables
 */

/**
 * Génère une bubble cliquable avec fallback sur première lettre
 */
function renderBubble($data) {
    $iconImg = $data['icon_img'] ?? null;
    $title = htmlspecialchars($data['title'] ?? '');
    $description = htmlspecialchars($data['description'] ?? '');
    $link = htmlspecialchars($data['link'] ?? '#');
    
    $firstLetter = strtoupper(mb_substr($title, 0, 1));
    
    ob_start();
    ?>
    <div class="bubble" onclick="navigateTo('<?= $link ?>')">
        <div class="glow"></div>
        <div class="icon-wrapper">
            <div class="icon-shadow"></div>
            <div class="icon-content">
                <?php if ($iconImg): ?>
                    <img src="<?= htmlspecialchars($iconImg) ?>" alt="<?= $title ?>" 
                         onerror="this.outerHTML='<div class=&quot;icon-letter-fallback&quot;><?= $firstLetter ?></div>';">
                <?php else: ?>
                    <div class="icon-letter-fallback"><?= $firstLetter ?></div>
                <?php endif; ?>
            </div>
        </div>
        <h2 class="bubble-title"><?= $title ?></h2>
        <p class="bubble-description"><?= $description ?></p>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Génère une flip card
 */
function renderFlipCard($data) {
    $type = $data['type'] ?? 'image';
    $frontContent = $data['front'] ?? '';
    $backContent = $data['back'] ?? '';
    $classes = $data['classes'] ?? '';
    
    ob_start();
    ?>
    <div class="flip-card <?= $type === 'text' ? 'text-card' : '' ?> <?= $classes ?>">
        <div class="glow"></div>
        <div class="flip-card-inner">
            <div class="flip-card-front">
                <?php if ($type === 'image'): ?>
                    <img src="<?= $frontContent ?>" alt="Image">
                <?php else: ?>
                    <?= $frontContent ?>
                <?php endif; ?>
            </div>
            <div class="flip-card-back">
                <?= $backContent ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Génère un header de page
 */
function renderPageHeader($title, $subtitle = '') {
    $title = htmlspecialchars($title);
    $subtitle = htmlspecialchars($subtitle);
    
    ob_start();
    ?>
    <div class="header" style="margin-top: 120px;">
        <h1><?= $title ?></h1>
        <?php if ($subtitle): ?>
            <p><?= $subtitle ?></p>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
