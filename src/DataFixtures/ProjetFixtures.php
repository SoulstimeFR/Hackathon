<?php

namespace App\DataFixtures;

use App\Entity\Hackathon;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $p = new Projet();
        $p->setDescription('Application de covoiturage pour étudiants.');
        $p->setRetenu(true);
        $p->setHackathon($this->getReference('hackathon_1', Hackathon::class));
        $manager->persist($p);
        $this->addReference('projet_1', $p);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [HackathonFixtures::class];
    }
}
