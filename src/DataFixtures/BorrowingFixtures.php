<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Borrowing;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use App\Repository\BorrowingRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BorrowingFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserRepository $userRepository, private BookRepository $bookRepository)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $books = $this->bookRepository->findAll();
        $users = $this->userRepository->findAll();




        for ($i = 0; $i < 30; $i++) {
            $book = $faker->randomElement($books);
            $isReturned = random_int(0, 1);
            $borrowingDate = $faker->dateTimeBetween('-2 month', 'now');
            $expectedReturnDate = new \DateTime($borrowingDate->format('Y-m-d H:i:s'));
            $expectedReturnDate->modify('+6 day');
            if ($isReturned) {
                $dayOffset = random_int(0, 10);
                $finalReturnDate =  new \DateTime($borrowingDate->format('Y-m-d H:i:s'));
                $finalReturnDate->modify("+$dayOffset day");
                $book->setAvailable(true);
            } else {
                $finalReturnDate = null;
                $book->setAvailable(false);
            }
            $borrowing = new Borrowing();
            $borrowing->setBorrowingDate($borrowingDate)
                ->setExpectedReturnDate($expectedReturnDate)
                ->setFinalReturnDate($finalReturnDate)
                ->setProlongated(false)
                ->setUser($faker->randomElement($users))
                ->setBook($book);
            $manager->persist($borrowing);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            BookFixtures::class,
            UserFixtures::class,
        ];
    }
}
