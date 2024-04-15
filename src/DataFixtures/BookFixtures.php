<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 100; $i++) {
            $post = new Book();
            $post->setTitle($faker->words(4,true))
            ->setState(mt_rand(0,2) === 1 ? Book::STATES[0] : Book::STATES[1]);
            $manager->persist($post);
        }
        $manager->flush();
    }
}
