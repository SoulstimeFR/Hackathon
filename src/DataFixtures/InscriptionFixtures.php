<?php

namespace App\DataFixtures;

use App\Entity\Inscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InscriptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $i = new Inscription();
        $i->setNum(1);
        $i->setDate(new \DateTimeImmutable('2026-10-01 14:30'));
        $i->setCompetence('Développement web');
        $manager->persist($i);

        $manager->flush();
    }
}
