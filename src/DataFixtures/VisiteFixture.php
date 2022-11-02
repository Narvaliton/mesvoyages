<?php

namespace App\DataFixtures;

use App\Entity\Visite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VisiteFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //création du faker pour la génération des valeurs aléatoires
        $faker = Factory::create('fr_FR');

        //générations des enregistrements
        for($k = 0; $k < 100; $k++){
            $visite = new Visite();
            $visite->setVille($faker->city)
                    ->setPays($faker->country)
                    ->setNote($faker->numberBetween(0,20))
                    ->setDatecreation($faker->dateTimeBetween('-10 years', 'now'))
                    ->setAvis($faker->sentence)
                    ->setTempmax($faker->numberBetween(0,30))
                    ->setTempmin($faker->numberBetween(-10,0));
            $manager->persist($visite);
        }
        $manager->flush();
    }
}
