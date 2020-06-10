<?php

namespace App\DataFixtures;

use App\Entity\Avis;
use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //Create 5 faker category
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->sentence($nbWords = 2, $variableNbWords = true));

            $manager->persist($category);

            //Create 25 faker Books
            for ($j = 0; $j < mt_rand(4, 6); $j++) {

                $book = new Book();

                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                $book->setTitle($faker->sentence($nbWords = 3, $variableNbWords = true))
                    ->setIsbn(strval($faker->isbn10))
                    ->setDescription($content)
                    ->setPrice($faker->numberBetween($min = 10, $max = 40))
                    ->setStock($faker->numberBetween($min = 1, $max = 30))
                    ->setYear($faker->numberBetween($min = 1940, $max = 2020))
                    ->setImage($faker->imageUrl())
                    ->addCategory($category);
                $manager->persist($book);

                for ($k = 0; $k < mt_rand(4, 10); $k++) {
                    $avis = new Avis();

                    $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                    $avis->setClient($faker->name)
                        ->setContent($content)
                        ->setNote($faker->numberBetween($min = 0, $mac = 5))
                        ->setCreatedAt($faker->dateTime())
                        ->setBook($book);
                    $manager->persist($avis);
                }
            }
        }

        $manager->flush();
    }
}
