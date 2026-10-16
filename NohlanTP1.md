# TP1 - Hackathon : mise en place de l'ORM (Object Relational Mapping)

## Prérequis
- PHP 8.5, Composer, Symfony CLI
- MariaDB (compatible MySQL), Doctrine ORM, DoctrineFixturesBundle

## Installation

Création du projet (déjà fait) : `symfony new Hackathon --webapp`

```bash
git clone https://github.com/SoulstimeFR/Hackathon.git && cd Hackathon
composer install
```

Base et utilisateur (depuis `sudo mariadb`) :

```sql
CREATE DATABASE Hackathon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'user_hack'@'localhost' IDENTIFIED BY '[mot_de_passe]';
GRANT ALL PRIVILEGES ON Hackathon.* TO 'user_hack'@'localhost';
FLUSH PRIVILEGES;
```

Fichier `.env.local` (non versionné) :

```
DATABASE_URL="mysql://user_hack:[mot_de_passe]@127.0.0.1:3306/Hackathon?serverVersion=mariadb-[version]&charset=utf8mb4"
```

Tables et jeu d'essai :

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

## Test d'interrogation

```bash
php bin/console dbal:run-sql "SELECT h.ville, o.nom FROM hackathon h JOIN hackathon_organisateur ho ON ho.hackathon_id = h.id JOIN organisateur o ON o.id = ho.organisateur_id"
```

![Résultat de la requête](docs/dbal-test.png)

## Difficultés rencontrées
L'assistant de PhpStorm créait un projet vide : projet créé en ligne de commande. MariaDB utilisé car MySQL n'est plus dans les dépôts d'Arch Linux. Bundle de fixtures à installer (`composer require --dev orm-fixtures`).
