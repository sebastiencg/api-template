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
        $faker = Faker\Factory::create('fr_FR');

        for ($i= 0 ; $i< 4 ;$i++){
            $author = new Author();
            $author->setname($faker->lastName);
            $manager->persist($author);
            for($u= 0 ; $u< 10 ;$u++){
                $dictons = new Dicton();
                $dictons->setContent('bla');
                $dictons->setCreatedAt(new \DateTimeImmutable());
                $dictons->setAuthor($author);
                $manager->persist($dictons);
            }
        }
        $manager->flush();
    }
}
