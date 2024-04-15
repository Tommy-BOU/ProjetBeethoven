<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use App\Repository\StateRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private StateRepository $stateRepository){

    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $states = $this->stateRepository->findAll();

        for($i = 0; $i < 100; $i++) {
            $book = new Book();
            $book->setTitle($faker->words(4,true))
            ->setAuthor($faker->name)
            ->setPublicationYear($faker->year)
            ->setSummary($faker->sentence(10))
            ->setImage($faker->imageUrl(640, 480, 'books', true))
            ->setAvailable($faker->boolean)
            ->setGlobalRating(0)
            ->setState($faker->randomElement($states));
            $manager->persist($book);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StateFixtures::class,
        ];
    }
}
