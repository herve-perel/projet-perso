<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture
{
    public const ACTOR_NUMBER = 25;
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create();

        for ($i = 0; $i < self::ACTOR_NUMBER; $i++) {
            $actor = new Actor();
            $actor->setName($faker->text(10));

            $manager->persist($actor);
        }

        $manager->flush();
    }
}
