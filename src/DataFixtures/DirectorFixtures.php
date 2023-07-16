<?php

namespace App\DataFixtures;

use App\Entity\Director;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DirectorFixtures extends Fixture implements DependentFixtureInterface
{
    public const DIRECTOR_NUMBERS = 25;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::DIRECTOR_NUMBERS; $i++) {
            $director = new Director();
            $director->setName($faker->firstName());
            $director->addFilm($this->getReference('film_' . $faker->numberBetween(0, FilmFixtures::FILM_NUMBERS - 1)));

            $manager->persist($director);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            FilmFixtures::class,
        ];
    }
}
