# Mon projet

Projet réalisé par :
- Ordi Dimbi
- Tracy Ngembo




Je veux développer une application web complète de gestion scolaire.

L’application doit permettre de gérer :
- les élèves
- les classes
- les options
- les enseignants
- les finances (paiement des frais scolaires)
- les notes
- les utilisateurs

Technologies obligatoires :
- PHP
- MySQL
- HTML
- CSS
- JavaScript
- Bootstrap pour le design

Architecture du projet :
- dossier /config (connexion base de données)
- dossier /pages
- dossier /assets (css, js, images)
- dossier /includes (header, footer, menu)

Base de données MySQL avec les tables suivantes :
- utilisateurs
- eleves
- classes
- options
- enseignants
- paiements
- notes
- cours

Chaque page doit être générée avec :
- code propre
- design professionnel
- formulaire fonctionnel
- connexion avec MySQL
- validation des données
- messages de succès ou d'erreur

Génère le code complet pour les pages suivantes :

1. Page de connexion (login.php)
- authentification utilisateur
- session PHP

2. Tableau de bord (dashboard.php)
- statistiques :
  - nombre d'élèves
  - nombre de classes
  - finances totales
  - enseignants

3. Gestion des élèves
- liste_eleves.php
- ajouter_eleve.php
- modifier_eleve.php
- supprimer_eleve.php

Champs élève :
- matricule
- nom
- postnom
- prenom
- sexe
- date_naissance
- adresse
- parent
- telephone
- classe
- option

4. Gestion des classes
- liste_classes.php
- ajouter_classe.php
- modifier_classe.php
- supprimer_classe.php

5. Gestion des options
- liste_options.php
- ajouter_option.php
- modifier_option.php
- supprimer_option.php

6. Gestion des enseignants
- liste_enseignants.php
- ajouter_enseignant.php
- modifier_enseignant.php
- supprimer_enseignant.php

Champs :
- nom
- telephone
- cours
- classe

7. Gestion financière
- liste_paiements.php
- ajouter_paiement.php

Champs paiement :
- eleve
- montant
- type_frais
- date_paiement

8. Gestion des notes
- ajouter_note.php
- liste_notes.php
- calcul automatique de la moyenne

Champs :
- eleve
- cours
- note

9. Gestion des utilisateurs
- liste_utilisateurs.php
- ajouter_utilisateur.php

Champs :
- nom
- email
- mot_de_passe
- role

Design souhaité :
- interface moderne
- menu latéral (sidebar)
- tableau avec DataTables
- responsive

Sécurité :
- protection contre injection SQL
- utilisation de PDO
- validation des formulaires

Je veux que tu génères :
- la structure du projet
- le script SQL de la base de données
- chaque fichier avec le code complet
- explication de chaque page