<?php

namespace App\DataFixtures;

use App\Entity\Hackathon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HackathonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $h = new Hackathon();
        $h->setDateHeureDebut(new \DateTimeImmutable('2026-11-20 09:00'));
        $h->setDateHeureFin(new \DateTimeImmutable('2026-11-21 18:00'));
        $h->setLieu('Lycée La Colinière');
        $h->setVille('Nantes');
        $h->setTheme('Intelligence artificielle');
        $manager->persist($h);

        $manager->flush();
    }
}
