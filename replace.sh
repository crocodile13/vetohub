#!/bin/bash
# Script de migration des chemins relatifs vers chemins absolus
# Usage: bash migrate_paths.sh

set -e  # Arrêt si erreur

echo "🚀 Migration des chemins relatifs → absolus pour VetoHub"
echo "=================================================="

# Couleurs
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Vérification qu'on est dans le bon dossier
if [ ! -f "config.php" ]; then
    echo -e "${RED}❌ Erreur: config.php introuvable${NC}"
    echo "Exécutez ce script depuis la racine de VetoHub"
    exit 1
fi

# Créer un dossier de backup avec timestamp
BACKUP_DIR="backup_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$BACKUP_DIR"
echo -e "${GREEN}✅ Backup créé: $BACKUP_DIR${NC}"

# Copier tous les fichiers PHP dans le backup
find . -name "*.php" -not -path "./backup_*/*" -exec cp --parents {} "$BACKUP_DIR/" \;
echo -e "${GREEN}✅ $(find . -name "*.php" -not -path "./backup_*/*" | wc -l) fichiers PHP sauvegardés${NC}"

echo ""
echo "📝 Début des modifications..."
echo ""

# Compteurs
TOTAL_FILES=0
MODIFIED_FILES=0

# Fonction pour calculer le bon nombre de ../ selon la profondeur
get_config_path() {
    local file_path="$1"
    local depth=$(echo "$file_path" | grep -o "/" | wc -l)
    
    if [ $depth -eq 0 ]; then
        echo "__DIR__ . '/config.php'"
    else
        local ups=""
        for ((i=0; i<depth; i++)); do
            ups="${ups}../"
        done
        echo "__DIR__ . '/${ups}config.php'"
    fi
}

# Parcourir tous les fichiers PHP (sauf config.php et les backups)
while IFS= read -r file; do
    TOTAL_FILES=$((TOTAL_FILES + 1))
    MODIFIED=0
    
    # Calculer le chemin relatif depuis la racine
    REL_PATH="${file#./}"
    
    # Calculer le bon chemin pour config.php
    CONFIG_PATH=$(get_config_path "$REL_PATH")
    
    echo -e "${YELLOW}📄 Traitement: $file${NC}"
    
    # 1. Remplacer les include/require de header.php
    if grep -q "include.*header\.php" "$file" || grep -q "require.*header\.php" "$file"; then
        # Ajouter require_once config.php si pas déjà présent
        if ! grep -q "require_once.*config\.php" "$file"; then
            # Insérer après <?php
            sed -i "0,/<?php/s|<?php|<?php\n/**\n * Configuration requise\n */\nrequire_once $CONFIG_PATH;|" "$file"
            MODIFIED=1
        fi
        
        # Remplacer tous les patterns d'include header.php
        sed -i "s|include.*['\"]\.*/header\.php['\"]|include BASE_PATH . '/header.php'|g" "$file"
        sed -i "s|include.*['\"]header\.php['\"]|include BASE_PATH . '/header.php'|g" "$file"
        sed -i "s|include __DIR__ \. '/\.\..*header\.php'|include BASE_PATH . '/header.php'|g" "$file"
        MODIFIED=1
    fi
    
    # 2. Remplacer les include/require de footer.php
    if grep -q "include.*footer\.php" "$file" || grep -q "require.*footer\.php" "$file"; then
        sed -i "s|include.*['\"]\.*/footer\.php['\"]|include BASE_PATH . '/footer.php'|g" "$file"
        sed -i "s|include.*['\"]footer\.php['\"]|include BASE_PATH . '/footer.php'|g" "$file"
        sed -i "s|include __DIR__ \. '/\.\..*footer\.php'|include BASE_PATH . '/footer.php'|g" "$file"
        MODIFIED=1
    fi
    
    # 3. Remplacer les require_once de components_helper.php
    if grep -q "require_once.*components_helper\.php" "$file"; then
        sed -i "s|require_once.*['\"]\.*/components_helper\.php['\"]|require_once BASE_PATH . '/components_helper.php'|g" "$file"
        sed -i "s|require_once.*['\"]components_helper\.php['\"]|require_once BASE_PATH . '/components_helper.php'|g" "$file"
        sed -i "s|require_once __DIR__ \. '/\.\..*components_helper\.php'|require_once BASE_PATH . '/components_helper.php'|g" "$file"
        MODIFIED=1
    fi
    
    # 4. Remplacer les require_once de navigation_helper.php
    if grep -q "require_once.*navigation_helper\.php" "$file"; then
        sed -i "s|require_once.*['\"]\.*/navigation_helper\.php['\"]|require_once BASE_PATH . '/navigation_helper.php'|g" "$file"
        sed -i "s|require_once.*['\"]navigation_helper\.php['\"]|require_once BASE_PATH . '/navigation_helper.php'|g" "$file"
        sed -i "s|require_once __DIR__ \. '/\.\..*navigation_helper\.php'|require_once BASE_PATH . '/navigation_helper.php'|g" "$file"
        MODIFIED=1
    fi
    
    if [ $MODIFIED -eq 1 ]; then
        MODIFIED_FILES=$((MODIFIED_FILES + 1))
        echo -e "${GREEN}  ✓ Modifié${NC}"
    else
        echo "  ○ Inchangé"
    fi
    
done < <(find . -name "*.php" -not -path "./backup_*/*" -not -name "config.php")

echo ""
echo "=================================================="
echo -e "${GREEN}✅ Migration terminée !${NC}"
echo ""
echo "📊 Rapport:"
echo "   - Fichiers analysés: $TOTAL_FILES"
echo "   - Fichiers modifiés: $MODIFIED_FILES"
echo "   - Backup: $BACKUP_DIR"
echo ""
echo "🧪 Prochaines étapes:"
echo "   1. Testez votre site: https://noel.lanpinet.fr"
echo "   2. Si OK: rm -rf $BACKUP_DIR"
echo "   3. Si KO: bash restore_backup.sh $BACKUP_DIR"
echo ""

# Créer un script de restauration automatique
cat > restore_backup.sh <<'RESTORE_SCRIPT'
#!/bin/bash
if [ -z "$1" ]; then
    echo "Usage: bash restore_backup.sh <backup_folder>"
    exit 1
fi

if [ ! -d "$1" ]; then
    echo "❌ Dossier de backup introuvable: $1"
    exit 1
fi

echo "🔄 Restauration depuis $1..."
cp -rf "$1"/* .
echo "✅ Restauration terminée"
RESTORE_SCRIPT

chmod +x restore_backup.sh

echo -e "${YELLOW}💡 Script de restauration créé: ./restore_backup.sh${NC}"
