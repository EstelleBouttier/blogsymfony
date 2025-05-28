<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $arrayCategories = [
            1 =>[
                'title' => 'cinéma',
                'slug' => 'cinema',
                'parent' => [
                    1 => [
                        'title' => 'Fantastique',
                        'slug' => 'fantastique'
                    ],
                    2 => [
                        'title' => 'Horreur',
                        'slug' => 'horreur'
                    ]
                ]
            ],
            2 =>[
                'title' => 'théâtre',
                'slug' => 'theatre',
                'parent' => [
                    1 => [
                        'title' => 'Tragédie',
                        'slug' => 'tragédie'
                    ],
                    2 => [
                        'title' => 'Burlesque',
                        'slug' => 'burlesque'
                    ]
                ]
            ]
        ];

        foreach ($arrayCategories as $item) {
            $categories = new Categories;
            $categories->setName($item['title']);
            $categories->setSlug($item['slug']);
            $categories->setParent(null);

            $manager->persist($categories);

            foreach ($item['parent'] as $key => $value) {
                $tata = new Categories;
                $tata->setName($value['title']);
                $tata->setSlug($value['slug']);
                $tata->setParent($categories);

                $manager->persist($tata);
            }
        }

        $manager->flush(); //flush = pousse la donnée dans la BDD
    }
}
