<?php

namespace App\DataFixtures;

use App\Entity\State;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $states = ["Excellent état", "Bon état", "État moyen" , "Mauvais etat" ];

        for ($i = 0; $i<4; $i++) {
            $state = new State();
            $state->setName($states[$i]);
            $manager->persist($state);
        }

        $manager->flush();
    }
}
