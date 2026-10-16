### Veuillez m'excuser pour le retard de mon rendu du TP1. J'ai été malade pendant deux jours et je n'étais pas à jour dans mon travail. Je pensais également que le TP1 était à rendre pour vendredi 18h, comme le TP2.

# TP1 - Hackathon : mise en place de l'ORM (Object Relational Mapping)

## Prérequis
- PHP 8.5, Composer, Symfony CLI
- MariaDB 13.0 (compatible MySQL), Doctrine ORM, DoctrineFixturesBundle

## Installation

Création du projet : `composer create-project symfony/skeleton Hackathon`

```bash
git clone https://github.com/SoulstimeFR/Hackathon.git && cd Hackathon
composer install
```

Base de données et utilisateur (depuis `sudo mariadb`) :

```sql
CREATE DATABASE Hackathon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER '[utilisateur]'@'localhost' IDENTIFIED BY '[mot_de_passe]';
GRANT ALL PRIVILEGES ON Hackathon.* TO '[utilisateur]'@'localhost';
FLUSH PRIVILEGES;
```

Fichier `.env.local` (non versionné) :

```
DATABASE_URL="mysql://[utilisateur]:[mot_de_passe]@127.0.0.1:3306/Hackathon?serverVersion=mariadb-13.0.2&charset=utf8mb4"
```

Création des tables et du jeu d'essai :

```bash
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

## Entités et relations

Entités : Hackathon, Organisateur, Projet, Participant, Inscription, Equipe.

- Hackathon N—N Organisateur
- Hackathon 1—N Projet
- Hackathon 1—N Inscription
- Participant 1—N Inscription
- Equipe 1—N Inscription
- Projet 1—N Equipe
- Equipe N—1 Inscription (responsable de l'équipe)

## Test d'interrogation

```bash
php bin/console dbal:run-sql "SELECT i.num, p.nom, h.ville, e.nom AS equipe FROM inscription i JOIN participant p ON i.participant_id = p.id JOIN hackathon h ON i.hackathon_id = h.id LEFT JOIN equipe e ON i.equipe_id = e.id"
```

![Résultat de la requête](docs/dbal-test.png)

## Difficultés rencontrées
- Apprentissage d'une toute nouvelle technologie
- L'assistant de création de projet de PhpStorm générait un projet vide : le projet a été créé en ligne de commande. MySQL n'étant plus dans les dépôts d'Arch Linux, MariaDB a été utilisé.
- Les références croisées entre `Equipe` (responsable) et `Inscription` (équipe) bloquaient la purge des fixtures : ajout de `ON DELETE SET NULL` sur ces deux clés étrangères.

# TP 2 - Application Web : Response HTTP en mode Client/Serveur

## Prérequis
- PHP 8.5, Composer, Symfony CLI
- MariaDB 13.0 (compatible MySQL), Doctrine, Twig

## Commande de base pour gérer la logique applicative
Composants intervenant dans le cycle de vie d'une requête/réponse HTTP :
Request → Router (route) → Controller → Response (HTML via Twig, ou JSON).

```bash
php bin/console make:controller HackathonController
php bin/console debug:router
symfony server:start -d --no-tls
```

Routes créées dans `src/Controller/HackathonController.php` :
- `/hackathons` : liste des hackathons au format HTML (template Twig)
- `/api/hackathons` : liste des hackathons au format JSON

## Test d'interrogation de l'application web
URL requêtée (HTML) :

```bash
http://localhost:8000/hackathons
```

URL requêtée (JSON) :

```bash
http://localhost:8000/api/hackathons
```

Résultat (extrait) :

```
[{"id":12,"theme":"D\u00e9veloppement","lieu":"Lyc\u00e9e La Colini\u00e8re","ville":"Nantes","dateHeureDebut":"2026-11-20 09:00:00","dateHeureFin":"2026-11-21 18:00:00"}]
```

![ImageSite](docs/imgsite.png)

## Difficultés rencontrées

- Le test des routes ne renvoyait aucune donnée : une migration non exécutée (table de jointure `hackathon_organisateur` absente) bloquait `doctrine:fixtures:load`. Corrigé en exécutant les migrations avant de recharger les fixtures.
