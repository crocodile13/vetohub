# 🐾 VetoHub (POC)

**Plateforme éducative interactive pour vétérinaires et étudiants vétérinaires**

VetoHub est une application web interactive développée dans le cadre d'une thèse de doctorat vétérinaire.

## 📋 Description

VetoHub propose des ressources interactives pour explorer les complications ophtalmologiques dans les dysendocrinopathies en médecine vétérinaire.

4 principales sections sont proposées:
- 👁️ **Lésions Oculaires** : De l'anatomie a la pathologie.
- ⚗️ **Dysendocrinies** : De la pathologie a la lesion.
- 🔬 **Mécanismes Physiopathologiques** : Exploration des processus pathologiques.
- 📝 **Auto-évaluation** : Tester ses connaissances.

## ✨ Fonctionnalités

- **Schémas anatomiques interactifs** avec SVG cliquables
- **Flashcards** pour l'apprentissage actif
- **Mode clair/sombre** pour le confort visuel
- **Navigation intuitive** avec fil d'Ariane
- **Design responsive** adapté à tous les appareils
- **Animations fluides** pour une expérience utilisateur agréable

## 🛠️ Technologies utilisées

- **Frontend** : HTML5, CSS3 (animations et glassmorphism), JavaScript (vanilla)
- **Backend** : PHP 7.4+
- **Assets** : SVG pour les schémas anatomiques, WebP pour les images
- **Architecture** : Modulaire avec séparation CSS/JS par fonctionnalité. 

## 📁 Structure du projet (temps réel, incomplet)

```
├── a_propos.php
├── components_helper.php
├── config.php
├── css/
│   ├── animations.css
│   ├── breadcrumb.css
│   ├── components.css
│   ├── flipcards.css
│   ├── layout.css
│   ├── reset.css
│   ├── schema.css
│   ├── theme.css
│   └── variables.css
├── dysendocrinies/
│   ├── diabete_sucre/
│   │   └── index.php
│   ├── hyperadrenocorticisme/
│   │   └── index.php
│   ├── hyperaldosteronisme/
│   │   └── index.php
│   ├── hyperthyroidie/
│   │   └── index.php
│   ├── hypothyroidie/
│   │   ├── chambre_anterieure/
│   │   │   └── index.php
│   │   └── index.php
│   ├── index.php
│   └── pheochromocytome/
│       └── index.php
├── footer.php
├── .gitignore
├── header.php
├── images/
│   └── illustrations/
│       ├── cornee_depolie.webp
│       ├── humeur_aqueuse_lipide.webp
│       ├── melanose_corneenne.webp
│       ├── neovascularisation_superficielle.webp
│       └── oedeme_corneen.webp
├── index.php
├── lesions_ocuaires/
│   ├── cornee/
│   │   ├── arc_corneen_lipidique/
│   │   │   └── index.php
│   │   ├── index.php
│   │   ├── keratite_corneenne/
│   │   │   └── index.php
│   │   ├── keratopathie_lipidique/
│   │   │   └── index.php
│   │   └── ulcere_corneen/
│   │       └── index.php
│   ├── index.php
│   ├── nerf_optique/
│   │   └── index.php
│   ├── retine/
│   │   └── index.php
│   └── sclere/
│       └── index.php
├── LICENSE
├── LICENSE-SVG.md
├── mecanismes_physiopathologiques/
│   ├── hyperglycemie/
│   │   └── index.php
│   ├── hyperlipidemie/
│   │   └── index.php
│   ├── hypertension_arterielle/
│   │   └── index.php
│   └── index.php
├── README.md
├── remerciments.php
├── run-server-linux.sh
├── run-server-windows.bat
├── scripts/
│   ├── main.js
│   ├── particles.js
│   ├── schema.js
│   ├── theme.js
│   └── utils.js
├── se_tester/
│   └── index.php
├── structure_oeil_shema_complet.html
└── svg/
    └── schema_oeuil.svg
```

## 🚀 Installation

### Prérequis

- **PHP 7.4+**
- Navigateur moderne (Chrome, Firefox, Edge, Safari)

**Vérifier PHP :**
```bash
php -v
```

**Installer PHP si nécessaire :**
- **Debian/Ubuntu** : `sudo apt install php php-cli`
- **Fedora/RHEL** : `sudo dnf install php php-cli`
- **Arch Linux** : `sudo pacman -S php`
- **macOS** : `brew install php`
- **Windows** : Téléchargez depuis [php.net](https://www.php.net/downloads)

### Installation locale pour les moldus

**Option 1 - Avec Git :**
```bash
git clone https://github.com/crocodile13/vetohub.git
cd vetohub
```

**Option 2 - ZIP :**
1. Cliquez sur **"Code"** → **"Download ZIP"**
2. Extrayez l'archive
3. Ouvrez un terminal dans le dossier

### Lancement

**🐧 Linux/macOS :**
```bash
chmod +x run-server-linux.sh
./run-server-linux.sh
```

**🪟 Windows :**
Double-cliquez sur `run-server-windows.bat`

**Accédez à :** http://127.0.0.1:8088

### Configuration

Le fichier `config.php` contient les paramètres de base :
```php
define('BASE_URL', '/');
define('ASSETS_VERSION', '1.0.0');
```

Ajustez `BASE_URL` selon votre configuration (ex: `/vetohub/` si installé dans un sous-dossier).

## 🎨 Personnalisation

### Thème et couleurs

Les couleurs sont définies dans `css/variables.css` :

```css
:root {
    --c-retine: #6366f1;
    --c-cornee: #ec4899;
    /* ... */
}
```

### Ajout de contenu

Pour ajouter une nouvelle pathologie :

1. Créez un dossier dans le module concerné
2. Créez un fichier `index.php` avec les breadcrumbs appropriés
3. Utilisez les composants existants (bubbles, flip-cards, etc.)
4. Ajoutez les images dans `images/illustrations/`

# Licence du projet

Ce projet est réalisé dans le cadre d'une thèse de doctorat vétérinaire.

## Licence générale

Ce projet est sous licence **MPL-2.0** (Mozilla Public License 2.0).  
Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## Exception

**SAUF** le fichier `svg/schema_oeuil.svg` qui est soumis à des restrictions spécifiques.  
Voir [LICENSE-SVG.md](LICENSE-SVG.md) pour les conditions d'utilisation de ce fichier.

## 👥 Équipe

**Contenu scientifique** : XXXXXXX (Doctorante en médecine vétérinaire - ENVA)  
**Développement web** : [@crocodile13](https://github.com/crocodile13) 🐊💻  
**Profs/etc, à completer** : à completer

## 📧 Contact

Pour toute question TECHNIQUE : [Issues GitHub](https://github.com/crocodile13/vetohub/issues)

---

© 2025 VetoHub - Plateforme éducative vétérinaire  
Développé par crocodile13 et beaucoup d'IA lol
