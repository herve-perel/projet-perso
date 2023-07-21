<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        'Epouvante',
        'Horreur',
        'Gore',
        'Drame',
        'Policier',
        'Science-fiction',
        'Comique'
    ];
    public function load(ObjectManager $manager): void
    {

        foreach (self::CATEGORIES as $key => $categoryData) {
            $category = new Category();
            $category->setName($categoryData);
            $this->addReference('category_' . $key, $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
