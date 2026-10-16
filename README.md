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
GRANT ALL PRIVILEGES ON Hackathon.* TO 'user_hack'@'localhost';
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
- Equipe N—1 Inscription

## Test d'interrogation

```bash
php bin/console dbal:run-sql "SELECT i.num, p.nom, h.ville, e.nom AS equipe FROM inscription i JOIN participant p ON i.participant_id = p.id JOIN hackathon h ON i.hackathon_id = h.id LEFT JOIN equipe e ON i.equipe_id = e.id"
```

![Résultat de la requête](docs/dbal-test.png)

## Difficultés rencontrées
L'assistant de création de projet de PhpStorm générait un projet vide : le projet a été créé en ligne de commande. MySQL n'étant plus dans les dépôts d'Arch Linux, MariaDB a été utilisé.
Les références croisées entre `Equipe` (responsable) et `Inscription` (équipe) bloquaient la purge des fixtures : ajout de `ON DELETE SET NULL` sur ces deux clés étrangères.
