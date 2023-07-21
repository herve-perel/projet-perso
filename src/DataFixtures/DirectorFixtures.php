<?php

namespace App\DataFixtures;

use App\Entity\Director;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class DirectorFixtures extends Fixture implements DependentFixtureInterface
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public const DIRECTOR_NUMBERS = 25;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::DIRECTOR_NUMBERS; $i++) {
            $director = new Director();
            $director->setName($faker->firstName());
            $director->setBio($faker->paragraph(5, true));
            $director->addFilm($this->getReference('film_' . $faker->numberBetween(0, FilmFixtures::FILM_NUMBERS - 1)));
            $director->setSlug(strtolower($this->slugger->slug($director->getName())));
            $director->setPoster('tsukamoto.jpg');
            copy(
                __DIR__ . '/director/tsukamoto.jpg',
                'public/uploads/images/directors/tsukamoto.jpg'
            );

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
