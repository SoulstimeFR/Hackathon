<?php

namespace App\Entity;

use App\Repository\HackathonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HackathonRepository::class)]
class Hackathon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateHeureDebut = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateHeureFin = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $theme = null;

    /**
     * @var Collection<int, Organisateur>
     */
    #[ORM\ManyToMany(targetEntity: Organisateur::class, inversedBy: 'hackathons')]
    private Collection $organisateurs;

    public function __construct()
    {
        $this->organisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeureDebut(): ?\DateTimeImmutable
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeImmutable $dateHeureDebut): static
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDateHeureFin(): ?\DateTimeImmutable
    {
        return $this->dateHeureFin;
    }

    public function setDateHeureFin(\DateTimeImmutable $dateHeureFin): static
    {
        $this->dateHeureFin = $dateHeureFin;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection<int, Organisateur>
     */
    public function getOrganisateurs(): Collection
    {
        return $this->organisateurs;
    }

    public function addOrganisateur(Organisateur $organisateur): static
    {
        if (!$this->organisateurs->contains($organisateur)) {
            $this->organisateurs->add($organisateur);
        }

        return $this;
    }

    public function removeOrganisateur(Organisateur $organisateur): static
    {
        $this->organisateurs->removeElement($organisateur);

        return $this;
    }
}
