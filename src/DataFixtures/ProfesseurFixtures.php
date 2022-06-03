<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Professeur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfesseurFixtures extends Fixture
{
    private Generator $faker;
    public function __construct(){
        $this->faker = Factory::create("fr_Fr");
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 5; $i++) {
            $prof = new Professeur();
            $prof->setNomComplet($this->faker->name());
            $prof->setGrade("Ingenieur");
            $manager->persist($prof);
        }

        $manager->flush();
    }
}
