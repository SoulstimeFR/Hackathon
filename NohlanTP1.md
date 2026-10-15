# TP1 - Hackathon: mise en place de l'ORM (Object Relational Mapping)

## Prérequis
- PHP 8.5.10 , Composer, Symfony CLI
- MariaDB 13.0.2 (compatible MySQL)

## Installation

```bash
git clone https://github.com/SoulstimeFR/Hackathon.git
cd ~/PhpstormProjects/Hackathon/
composer install
```

Créer la base et l'utilisateur (depuis `sudo mariadb`) :

```sql
CREATE DATABASE Hackathon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'jeanpierre'@'localhost' IDENTIFIED BY 'mdp';
GRANT ALL PRIVILEGES ON Hackathon.* TO 'jeanpierre'@'localhost';
FLUSH PRIVILEGES;
```

Créer un fichier `.env.local` avec :

```
DATABASE_URL="mysql://jeanpierre:mdp@127.0.0.1:3306/Hackathon?serverVersion=mariadb-13.0.2&charset=utf8mb4"
```
Valeurs à adapter selon votre configuration

En option : créer la base si celle-ci n'existe pas (nécessite un compte ayant le droit de créer des bases)
```bash
php bin/console doctrine:database:create
```

## Entités

Les relations ne sont pas gérées dans ce TP.

| Entité | Attributs principaux |
|---|---|
| Hackathon | dateHeureDebut, dateHeureFin, lieu, ville, theme |
| Organisateur | statut, nom, siteweb, email |
| Projet | description, retenu |
| Participant | nom, prenom, email, telephone, dateNaissance, lienPortefolio |
| Inscription | num, date, competence |
| Equipe | nom, lienPrototype |

## Fixtures

Une classe de fixtures par entité dans `src/DataFixtures/` (par exemple `HackathonFixtures`), avec 3 lignes de données chacune.

## Base de données et jeux d'essai (fixtures)
Générer et appliquer les migrations, puis charger le jeu d'essai :

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

## Test d'interrogation

Requête :

```bash
php bin/console dbal:run-sql "SELECT * FROM equipe LIMIT 5"
```

Résultat (extrait) :

```
[soul@moon-cell Hackathon]$ php bin/console dbal:run-sql "SELECT * FROM equipe LIMIT 5"

                                                                                                                        
 [OK] The query yielded an empty result set.                                                                            
```

## Difficultés rencontrées
L'assistant de création de projet de PhpStorm générait un projet vide : le projet a été créé avec `composer create-project symfony/skeleton`.
Le bundle de fixtures n'était pas installé (`composer require --dev orm-fixtures`).
MySQL n'étant plus dans les dépôts d'Arch Linux (ma distro), MariaDB a été utilisé à la place.
