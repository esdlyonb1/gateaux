<?php

namespace App\DataFixtures;

use App\Entity\Gateau;
use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create();
        for($i=0;$i<100;$i++){


                $gateau = new Gateau();
                $gateau->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));
                $gateau->setName($faker->name());

                         for($j=0;$j<2;$j++){
                             $ingredient = new Ingredient();
                             $ingredient->setName($faker->name());



                             $gateau->addIngredient($ingredient);
                             $manager->persist($ingredient);
                         }



                $manager->persist($gateau);
             }
               $manager->flush();
    }
}
