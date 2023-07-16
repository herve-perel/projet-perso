<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FilmFixtures extends Fixture 
{
    public const FILM_NUMBERS = 20;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // $manager->persist($product);

        for ($i = 0; $i < self::FILM_NUMBERS; $i++) {

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
