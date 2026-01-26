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
