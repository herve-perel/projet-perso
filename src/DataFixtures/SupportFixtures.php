<?php

namespace App\DataFixtures;

use App\Entity\Support;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SupportFixtures extends Fixture
{
    public const SUPPORTS = [
        'DVD',
        'VHS',
        'Blu ray',
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::SUPPORTS as $key => $supportFormat) {
            $support = new Support();
            $support->setFormat($supportFormat);
            $this->addReference('support_' . $key, $support);
            $manager->persist($support);
        }
        $manager->flush();
    }
}
