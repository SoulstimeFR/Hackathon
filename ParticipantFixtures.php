<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HackathonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $p = new Participant();
        $p->setNom('Martin');
        $p->setPrenom('Lucie');
        $p->setEmail('lucie.martin@example.com');
        $p->setTelephone('0601020304');
        $p->setDateNaissance(new \DateTimeImmutable('2004-05-12'));
        $p->setLienPortefolio('https://lucie-martin.example');
        $manager->persist($p);

        $manager->flush();
    }
}
