<?php

namespace App\DataFixtures;

use App\Entity\Rp;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RpFixtures extends Fixture
{
    private Generator $faker;
    public function __construct(UserPasswordHasherInterface $encoder){
        $this->faker= Factory::create("fr_Fr");
        $this->encoder= $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 1; $i++) {
            $rp = new Rp();
            $mdp = "Passer";
            $test = $this->encoder->hashPassword($rp,$mdp);
            $rp->setNomComplet($this->faker->name());
            $rp->setEmail($this->faker->email());
            $rp->setPassword($test);
            $manager->persist($rp);
        }
        $manager->flush();
    }
}
