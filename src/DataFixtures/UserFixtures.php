<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
            ->setRoles(['ROLE_USER'])
            ->setPassword($faker->password)
            ->setFirstName($faker->firstName)
            ->setLastName($faker->lastName)
            ->setAddress($faker->address)
            ->setCity($faker->city)
            ->setZipCode($faker->postcode)
            ->setTelephone($faker->randomNumber(9))
            ->setBirthdate($faker->dateTime('now'))
            ->setStripeId($faker->randomNumber(9));
            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail('admin@admin.com')
        ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
        ->setPassword('admin')
        ->setFirstName('admin')
        ->setLastName('admin')
        ->setAddress('admin')
        ->setCity('admin')
        ->setZipCode('69420')
        ->setTelephone('0000000000')
        ->setBirthdate($faker->dateTime('now'))
        ->setStripeId(000000000);

        $manager->persist($admin);

        $manager->flush();
    }
}
