<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public const ACTOR_NUMBERS = 25;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::ACTOR_NUMBERS; $i++) {
            $actor = new Actor();
            $actor->setName($faker->firstName());
            $actor->addFilm($this->getReference('film_' . $faker->numberBetween(0, FilmFixtures::FILM_NUMBERS - 1)));
            $actor->setSlug(strtolower($this->slugger->slug($actor->getName())));

            
            $manager->persist($actor);
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
