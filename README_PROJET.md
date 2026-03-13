# Application de Gestion Scolaire

Une application web complète de gestion scolaire développée en PHP, MySQL, HTML, CSS, JavaScript et Bootstrap.

## Fonctionnalités

- **Gestion des élèves** : Ajout, modification, suppression et liste des élèves
- **Gestion des classes** : Organisation des classes par niveau
- **Gestion des options** : Différentes orientations scolaires
- **Gestion des enseignants** : Informations sur les enseignants et leurs cours
- **Gestion financière** : Suivi des paiements des frais scolaires
- **Gestion des notes** : Saisie des notes et calcul automatique des moyennes
- **Gestion des utilisateurs** : Système d'authentification et gestion des rôles

## Technologies utilisées

- **Backend** : PHP 7+
- **Base de données** : MySQL
- **Frontend** : HTML5, CSS3, JavaScript
- **Framework CSS** : Bootstrap 5
- **Bibliothèques JavaScript** : jQuery, DataTables, Chart.js
- **Sécurité** : PDO, password_hash, sessions PHP

## Structure du projet

```
/
├── config/
│   └── db.php                 # Configuration de la base de données
├── pages/
│   ├── dashboard.php          # Tableau de bord
│   ├── liste_eleves.php       # Liste des élèves
│   ├── ajouter_eleve.php      # Formulaire d'ajout d'élève
│   ├── modifier_eleve.php     # Modification d'élève
│   ├── supprimer_eleve.php    # Suppression d'élève
│   ├── liste_classes.php      # Liste des classes
│   ├── ajouter_classe.php     # Ajout de classe
│   ├── modifier_classe.php    # Modification de classe
│   ├── supprimer_classe.php   # Suppression de classe
│   ├── liste_options.php      # Liste des options
│   ├── ajouter_option.php     # Ajout d'option
│   ├── modifier_option.php    # Modification d'option
│   ├── supprimer_option.php   # Suppression d'option
│   ├── liste_enseignants.php  # Liste des enseignants
│   ├── ajouter_enseignant.php # Ajout d'enseignant
│   ├── modifier_enseignant.php# Modification d'enseignant
│   ├── supprimer_enseignant.php# Suppression d'enseignant
│   ├── liste_paiements.php    # Liste des paiements
│   ├── ajouter_paiement.php   # Ajout de paiement
│   ├── supprimer_paiement.php # Suppression de paiement
│   ├── liste_notes.php        # Liste des notes et moyennes
│   ├── ajouter_note.php       # Ajout de note
│   ├── liste_utilisateurs.php # Liste des utilisateurs
│   ├── ajouter_utilisateur.php# Ajout d'utilisateur
│   └── supprimer_utilisateur.php# Suppression d'utilisateur
├── assets/
│   ├── css/
│   │   └── style.css          # Styles personnalisés
│   ├── js/
│   │   └── script.js          # Scripts JavaScript
│   └── images/                # Images du projet
├── includes/
│   ├── header.php             # En-tête commun
│   └── footer.php             # Pied de page commun
├── database.sql               # Script de création de la BD
├── index.php                  # Page d'accueil (redirection)
├── login.php                  # Page de connexion
└── logout.php                 # Déconnexion
```

## Installation

1. **Cloner ou télécharger le projet**
2. **Configurer la base de données** :
   - Créer une base de données MySQL nommée `gestion_scolaire`
   - Exécuter le script `database.sql` pour créer les tables
3. **Configurer la connexion** :
   - Modifier `config/db.php` avec vos paramètres de base de données
4. **Accéder à l'application** :
   - Ouvrir `index.php` dans votre navigateur
   - Se connecter avec l'utilisateur par défaut : `admin@gestion-scolaire.com` / `password`

## Sécurité

- Utilisation de PDO pour les requêtes préparées
- Hachage des mots de passe avec `password_hash()`
- Protection contre les injections SQL
- Validation des données côté serveur
- Sessions PHP pour l'authentification

## Fonctionnalités principales

### Page de connexion
- Authentification des utilisateurs
- Gestion des sessions

### Tableau de bord
- Statistiques générales (nombre d'élèves, classes, enseignants, finances)
- Graphiques et indicateurs visuels
- Aperçu des paiements récents

### Gestion des élèves
- Formulaire d'ajout avec validation
- Liste avec recherche et tri (DataTables)
- Modification et suppression des élèves
- Champs : matricule, nom, postnom, prénom, sexe, date de naissance, adresse, parent, téléphone, classe, option

### Gestion des classes et options
- CRUD complet pour les classes et options
- Association élèves-classes et élèves-options

### Gestion des enseignants
- Informations des enseignants
- Association avec cours et classes

### Gestion financière
- Saisie des paiements
- Types de frais (inscription, mensualité, matériel, etc.)
- Historique des paiements

### Gestion des notes
- Saisie des notes par élève et cours
- Calcul automatique des moyennes
- Affichage des résultats

### Gestion des utilisateurs
- Système de rôles (admin, enseignant, secrétaire)
- Gestion des comptes utilisateurs

## Design

- Interface moderne et responsive
- Menu latéral de navigation
- Utilisation de Bootstrap pour la mise en page
- Tables interactives avec DataTables
- Graphiques avec Chart.js

## Développement

- Code propre et commenté
- Architecture MVC simplifiée
- Séparation des préoccupations
- Validation côté client et serveur
- Messages d'erreur et de succès

## Auteur

Projet réalisé par :
- Ordi Dimbi
- Tracy Ngembo