<?php

namespace App\DataFixtures;

use App\Entity\Organisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrganisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $o = new Organisateur();
        $o->setStatut('Association');
        $o->setNom('Digital Nantes');
        $o->setSiteweb('https://digital-nantes.example');
        $o->setEmail('contact@digital-nantes.example');
        $manager->persist($o);

        $manager->flush();
    }
}
