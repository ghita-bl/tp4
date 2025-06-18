# Inpt Edu. Gestionnaire de PFE – Web Application (Étudiant/Admin)

Un projet PHP – back-end dynamique pour gérer du contenu étudiant et administrateur.

## 🧭 Table des matières

- [Aperçu](#aperçu)
- [Fonctionnalités](#fonctionnalités)
- [Structure du projet](#structure-du-projet)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Contribuer](#contribuer)
- [Licence](#licence)
- [Contact](#contact)

## Aperçu

Ce projet fournit une plateforme web avec deux rôles :

- **Admin** : ajout, modification et suppression de contenus (pages, fichiers, images…) via un back-office.
- **Étudiant** : consultation des contenus et recherche via une interface publique.

## Fonctionnalités

- Authentification basique pour les administrateurs
- Interface d'administration (CRUD)
- Recherche côté public via `search.php`
- Uploads de fichiers et images (`uploads/`)
- Organisation claire en dossiers (`admin`, `etudiant`, `includes`, `pages`)

## Structure du projet


tp4/
├── admin/          # Pages de gestion Back‑office
├── etudiant/       # Pages publiques côté étudiant
├── includes/       # Code partagé (header, footer, utils…)
├── pages/          # Pages front-end
├── style/          # CSS
├── images/         # Images statiques
├── uploads/        # Contenus uploadés
├── search.php      # Script de recherche publique
└── README.md       # Ce fichier


## Installation

1. Clonez le dépôt :
   \`\`\`bash
   git clone https://github.com/ghita-bl/tp4.git
   cd tp4
   \`\`\`

2. Configurez un serveur local (Apache/Nginx + PHP 7.x+ + MySQL ou SQLite).

3. Créez la base de données :
   \`\`\`sql
   CREATE DATABASE tp4_db;
   \`\`\`

4. Importez la structure / données (fichier SQL à créer / ajuster).

5. Copiez le fichier de configuration :
   \`\`\`bash
   cp includes/config.sample.php includes/config.php
   \`\`\`
   puis éditez vos identifiants DB, chemins, etc.

6. Assurez-vous que les dossiers \`uploads/\` et \`style/\` sont accessibles en écriture :
   \`\`\`bash
   chmod -R 755 uploads/
   \`\`\`

## Configuration

Le fichier \`includes/config.php\` contient :

- Informations de connexion BD
- Variables de chemin / URL
- Paramètres spécifiques au projet

## Utilisation

### Admin

1. Accédez à : \`http://localhost/tp4/admin/login.php\`
2. Identifiez-vous (user / pass admin)
3. Gérez les contenus (ajouter, modifier, supprimer)

### Étudiant / Public

- Visitez : \`http://localhost/tp4/etudiant/index.php\`  
- Utilisez la page \`search.php\` pour chercher du contenu

## Contribuer

1. Forkez le projet
2. Créez une branche : \`git checkout -b feature/mon-idee\`
3. Faites vos modifications et committez (\`git commit -am 'Ajout fonctionnalité X'\`)
4. Poussez votre branche (\`git push origin feature/mon-idee\`)
5. Ouvrez une Pull Request

Merci pour vos contributions !

## Licence

Ce projet est sous licence **MIT** – voir le fichier [LICENSE](LICENSE) pour plus de détails.

## Contact

Pour toute question, bug ou suggestion :

- Github : ([https://github.com/ghita-bl](https://github.com/ghita-bl/tp4.git))
