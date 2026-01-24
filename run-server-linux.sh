#!/bin/bash

# Moldu's script for test

# Lancer un serveur PHP sur 127.0.0.1:8088

# Vérification que PHP est installé
if ! command -v php >/dev/null 2>&1; then
    echo "❌ PHP n'est pas installé"
    exit 1
fi

# Lancement du serveur
echo "🚀 Serveur PHP démarré sur http://127.0.0.1:8088"
echo "   Appuyez sur Ctrl+C pour arrêter"
php -S 127.0.0.1:8088
