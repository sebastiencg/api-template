<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Dicton;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();


        for ($i= 0 ; $i< 4 ;$i++){
            $author = new Author();
            $author->setname($faker->lastName);
            $manager->persist($author);
            $random=rand(10,500);
            for($u= 0 ; $u< $random ;$u++){


                $dicton = new Dicton();
                $dicton->setContent("faker text");
                $dicton->setCreatedAt($faker->dateTimeBetween('-5 years', ''));
                $dicton->setAuthor($author);
                $manager->persist($dicton);
            }
        }
        $manager->flush();
    }
}
