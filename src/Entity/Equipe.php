<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['equipe:read', 'projet:read', 'inscription:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['equipe:read', 'projet:read', 'inscription:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['equipe:read', 'projet:read', 'inscription:read'])]
    private ?string $lienPrototype = null;

    #[ORM\ManyToOne(inversedBy: 'equipes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['equipe:read'])]
    private ?Projet $projet = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'equipe')]
    #[Groups(['equipe:read'])]
    private Collection $inscriptions;

    #[ORM\ManyToOne(inversedBy: 'equipes')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    #[Groups(['equipe:read'])]
    private ?Inscription $responsable = null;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLienPrototype(): ?string
    {
        return $this->lienPrototype;
    }

    public function setLienPrototype(?string $lienPrototype): static
    {
        $this->lienPrototype = $lienPrototype;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setEquipe($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getEquipe() === $this) {
                $inscription->setEquipe(null);
            }
        }

        return $this;
    }

    public function getResponsable(): ?Inscription
    {
        return $this->responsable;
    }

    public function setResponsable(?Inscription $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }
}
