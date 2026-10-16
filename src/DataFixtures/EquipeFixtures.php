<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $e = new Equipe();
        $e->setNom('Les Codeurs');
        $e->setLienPrototype('https://prototype.example/codeurs');
        $manager->persist($e);

        $manager->flush();
    }
}
