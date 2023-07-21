<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FilmFixtures extends Fixture implements DependentFixtureInterface
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
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
            $film->setCategory($this->getReference('category_' . $faker->numberBetween(0, 6)));
            $film->setPoster('machete.jpg');
            copy(
                __DIR__ . '/poster/machete.jpg',
                'public/uploads/images/posters/machete.jpg'
            );
            $film->setSlug(strtolower($this->slugger->slug($film->getTitle())));
            $this->addReference('film_' . $i, $film);

            $manager->persist($film);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
