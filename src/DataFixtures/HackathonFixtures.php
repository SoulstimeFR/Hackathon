<?php

namespace App\DataFixtures;

use App\Entity\Hackathon;
use App\Entity\Organisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HackathonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $h = new Hackathon();
        $h->setDateHeureDebut(new \DateTimeImmutable('2026-11-20 09:00'));
        $h->setDateHeureFin(new \DateTimeImmutable('2026-11-21 18:00'));
        $h->setLieu('Lycée La Colinière');
        $h->setVille('Nantes');
        $h->setTheme('Intelligence artificielle');
        $h->addOrganisateur($this->getReference('organisateur_1', Organisateur::class));
        $manager->persist($h);
        $this->addReference('hackathon_1', $h);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [OrganisateurFixtures::class];
    }
}
