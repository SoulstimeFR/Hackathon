<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['inscription:read', 'participant:read', 'hackathon:read', 'equipe:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['inscription:read', 'participant:read', 'hackathon:read', 'equipe:read'])]
    private ?int $num = null;

    #[ORM\Column]
    #[Groups(['inscription:read', 'participant:read', 'hackathon:read', 'equipe:read'])]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(length: 255)]
    #[Groups(['inscription:read', 'participant:read', 'hackathon:read', 'equipe:read'])]
    private ?string $competence = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['inscription:read'])]
    private ?Hackathon $hackathon = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['inscription:read'])]
    private ?Participant $participant = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    #[Groups(['inscription:read'])]
    private ?Equipe $equipe = null;

    /**
     * @var Collection<int, Equipe>
     */
    #[ORM\OneToMany(targetEntity: Equipe::class, mappedBy: 'responsable')]
    private Collection $equipes;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCompetence(): ?string
    {
        return $this->competence;
    }

    public function setCompetence(string $competence): static
    {
        $this->competence = $competence;

        return $this;
    }

    public function getHackathon(): ?Hackathon
    {
        return $this->hackathon;
    }

    public function setHackathon(?Hackathon $hackathon): static
    {
        $this->hackathon = $hackathon;

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): static
    {
        $this->participant = $participant;

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    /**
     * @return Collection<int, Equipe>
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): static
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes->add($equipe);
            $equipe->setResponsable($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): static
    {
        if ($this->equipes->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getResponsable() === $this) {
                $equipe->setResponsable(null);
            }
        }

        return $this;
    }
}
