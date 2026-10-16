<?php

namespace App\DataFixtures;

use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $p = new Projet();
        $p->setDescription('Application de covoiturage pour étudiants.');
        $p->setRetenu(true);
        $manager->persist($p);

        $manager->flush();
    }
}
