<?php

namespace App\DataFixtures;

use App\Entity\Hackathon;
use App\Entity\Inscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Participant;
use App\Entity\Equipe;

class InscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $equipe = $this->getReference('equipe_1', Equipe::class);

        $i = new Inscription();
        $i->setNum(1);
        $i->setDate(new \DateTimeImmutable('2026-10-01 14:30'));
        $i->setCompetence('Développement web');
        $i->setHackathon($this->getReference('hackathon_1', Hackathon::class));
        $i->setParticipant($this->getReference('participant_1', Participant::class));
        $i->setEquipe($equipe);
        $manager->persist($i);

        $equipe->setResponsable($i);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [HackathonFixtures::class, ParticipantFixtures::class, EquipeFixtures::class];
    }
}
