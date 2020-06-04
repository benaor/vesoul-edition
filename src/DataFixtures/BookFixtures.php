<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 25; $i++) {

            $book = new Book();
            $book->setTitle($faker->sentence($nbWords = 3, $variableNbWords = true))
                ->setIsbn(strval($faker->isbn10))
                ->setDescription($faker->sentence($nbWords = 6, $variableNbWords = true))
                ->setPrice($faker->numberBetween($min = 10, $max = 40))
                ->setStock($faker->numberBetween($min = 1, $max = 30))
                ->setYear($faker->numberBetween($min = 1940, $max = 2020))
                ->setImage('https://picsum.photos/640/480');

            $manager->persist($book);
           
        }
        
        $manager->flush();
    }
}
