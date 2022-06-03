<?php

namespace App\DataFixtures;

use Faker\Generator;
use Faker\Factory;
use App\Entity\Attache;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AttacheFixtures extends Fixture
{   private Generator $faker;
    public function __construct(){
        $this->faker= Factory::create("fr_Fr");
    }
    public function load(ObjectManager $manager): void
    {
         for ($i=0; $i < 5; $i++) { 
            $ac = new Attache();
            $ac->setNomComplet($this->faker->name());
            $ac->setEmail($this->faker->email());
            $ac->setPassword($this->faker->password());
            $manager->persist($ac);
        }
        $manager->flush();
    }
}
