# TP4 : API – Méthodes GET et sérialisation des objets

## Prérequis
- PHP 8.5, Composer, Symfony CLI
- MariaDB 13.0 (compatible MySQL), Doctrine ORM 3.7
```
symfony/serializer 8.1
symfony/property-access 8.1
symfony/property-info 8.1
(déjà présents : doctrine/orm, doctrine-bundle, doctrine-fixtures-bundle)
```

## Problème : références circulaires
Les relations introduites au TP3 créent des boucles lors de la sérialisation, par exemple :
`Hackathon → inscriptions → Inscription → hackathon → inscriptions → …`

Erreur obtenue (sérialisation d'un `Hackathon` sans groupes) :

```
Symfony\Component\Serializer\Exception\CircularReferenceException: A circular reference has been detected when serializing the object of class "App\Entity\Hackathon" (configured limit: 1).
```

## Personnalisation de la sérialisation
Solution retenue : les **groupes de sérialisation** (`#[Groups]`), un groupe de lecture par entité (`<entité>:read`).
Règle appliquée pour casser les boucles : les attributs simples d'une entité appartiennent à son propre groupe **et** aux groupes des entités qui la référencent ; ses relations n'appartiennent qu'à son propre groupe. Ainsi, en lisant un `Hackathon`, on voit ses inscriptions (attributs simples) mais pas `inscription.hackathon`, et la boucle s'arrête.

```php
// src/Entity/Equipe.php
#[ORM\Column(length: 100)]
#[Groups(['equipe:read', 'projet:read', 'inscription:read'])]
private ?string $nom = null;

#[ORM\ManyToOne(inversedBy: 'equipes')]
#[ORM\JoinColumn(nullable: false)]
#[Groups(['equipe:read'])]
private ?Projet $projet = null;
```

### Tableau à compléter
| Entité | Groupe(s) | Attributs exposés | Relations exposées |
|---|---|---|---|
| Hackathon | `hackathon:read` | id, dateHeureDebut, dateHeureFin, lieu, ville, theme | organisateurs, projets, inscriptions (attributs simples uniquement) |
| Organisateur | `organisateur:read` | id, statut, nom, siteweb, email | hackathons |
| Participant | `participant:read` | id, nom, prenom, email, telephone, dateNaissance, lienPortfolio | inscriptions |
| Projet | `projet:read` | id, description, retenu | hackathon, equipes |
| Equipe | `equipe:read` | id, nom, lienPrototype | projet, inscriptions, responsable |
| Inscription | `inscription:read` | id, num, date, competence | hackathon, participant, equipe |

Le côté inverse `Inscription::$equipes` (équipes dont l'inscription est responsable) n'est volontairement pas exposé.

## Endpoints GET

| Méthode | URL | Description | Groupe | Codes retour |
|---|---|---|---|---|
| GET | `/api/hackathons` | Liste des hackathons | `hackathon:read` | 200 |
| GET | `/api/hackathons/{id}` | Détail d'un hackathon | `hackathon:read` | 200 / 404 |
| GET | `/api/organisateurs` | Liste des organisateurs | `organisateur:read` | 200 |
| GET | `/api/organisateurs/{id}` | Détail d'un organisateur | `organisateur:read` | 200 / 404 |
| GET | `/api/participants` | Liste des participants | `participant:read` | 200 |
| GET | `/api/participants/{id}` | Détail d'un participant | `participant:read` | 200 / 404 |
| GET | `/api/projets` | Liste des projets | `projet:read` | 200 |
| GET | `/api/projets/{id}` | Détail d'un projet | `projet:read` | 200 / 404 |
| GET | `/api/equipes` | Liste des équipes | `equipe:read` | 200 |
| GET | `/api/equipes/{id}` | Détail d'une équipe | `equipe:read` | 200 / 404 |
| GET | `/api/inscriptions` | Liste des inscriptions | `inscription:read` | 200 |
| GET | `/api/inscriptions/{id}` | Détail d'une inscription | `inscription:read` | 200 / 404 |

Extrait de contrôleur :

```php
#[Route('/api/hackathons', name: 'api_hackathon_')]
final class HackathonApiController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(HackathonRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll(), context: ['groups' => 'hackathon:read']);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id, HackathonRepository $repository): JsonResponse
    {
        $hackathon = $repository->find($id);

        if (null === $hackathon) {
            return $this->json(['error' => 'Hackathon introuvable'], 404);
        }

        return $this->json($hackathon, context: ['groups' => 'hackathon:read']);
    }
}
```

## Tests avec Insomnia

Requête :

```bash
GET http://localhost:8000/api/hackathons
```

Résultat (extrait) :
<!-- TODO : remplacer par la réponse réelle d'Insomnia (les id ci-dessous sont à null car ce résultat vient d'un test de sérialisation sans base de données) -->
```json
[
    {
        "id": null,
        "dateHeureDebut": "2026-11-20T09:00:00+00:00",
        "dateHeureFin": "2026-11-21T18:00:00+00:00",
        "lieu": "Lycée La Colinière",
        "ville": "Nantes",
        "theme": "Développement",
        "organisateurs": [
            {
                "id": null,
                "statut": "Association",
                "nom": "Digital Nantes",
                "siteweb": "https://digital-nantes.example",
                "email": "contact@digital-nantes.example"
            }
        ],
        "projets": [
            {
                "id": null,
                "description": "Application de covoiturage pour étudiants.",
                "retenu": true
            }
        ],
        "inscriptions": [
            {
                "id": null,
                "num": 1,
                "date": "2026-10-01T14:30:00+00:00",
                "competence": "Développement web"
            }
        ]
    }
]
```

Test d'un cas d'erreur (ex. `GET /api/hackathons/9999` → 404) :
<!-- TODO : coller la réponse réelle d'Insomnia (statut 404) -->
```json
{
    "error": "Hackathon introuvable"
}
```

## Difficultés rencontrées
La principale difficulté a été de choisir quels attributs ajouter à quels groupes : il faut que les attributs simples d'une entité soient dans les groupes des entités qui la référencent, mais pas ses relations, sinon la boucle revient. Il faut aussi penser au côté inverse des relations, qui n'apparaît qu'une fois les données chargées depuis la base.

## Ressources
- Moodle : TP4
- https://symfony.com/doc/current/serializer.html
