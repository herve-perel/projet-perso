<?php

namespace App\DataFixtures;

use App\Entity\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FilmFixtures extends Fixture
{
    public const FILM_NUMBER = 25;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::FILM_NUMBER; $i++) {

            $film = new Film();
            $film->setTitle($faker->word());
            $film->setYear($faker->year());
            $film->setSynopsis($faker->paragraphs(3, true));
            $film->setCategory($faker->word());
            $film->setPoster($faker->numberBetween(1, 10));
          
            $this->addReference('film_' . $i, $film);
           
            
            $manager->persist($film);
        }

        $manager->flush();
    }
}
