<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $e = new Equipe();
        $e->setNom('Les Codeurs');
        $e->setLienPrototype('https://prototype.example/codeurs');
        $e->setProjet($this->getReference('projet_1', Projet::class));
        $manager->persist($e);
        $this->addReference('equipe_1', $e);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProjetFixtures::class];
    }
}
