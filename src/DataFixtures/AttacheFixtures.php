<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Attache;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AttacheFixtures extends Fixture
{   private Generator $faker;
    public function __construct(UserPasswordHasherInterface $encoder){
        $this->faker= Factory::create("fr_Fr");
        $this->encoder= $encoder;
    }
    public function load(ObjectManager $manager): void
    {
         for ($i=0; $i < 1; $i++) { 
            $ac = new Attache();
            $mdp = "Passer";
            $test = $this->encoder->hashPassword($ac,$mdp);
            $ac->setNomComplet($this->faker->name());
            $ac->setEmail($this->faker->email());
            $ac->setPassword($test);
            $manager->persist($ac);
        }
        $manager->flush();
    }
}
