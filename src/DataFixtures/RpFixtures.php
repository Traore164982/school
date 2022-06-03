<?php

namespace App\DataFixtures;

use App\Entity\Rp;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RpFixtures extends Fixture
{
    private Generator $faker;
    public function __construct(){
        $this->faker= Factory::create("fr_Fr");
    }
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 5; $i++) {
            $rp = new Rp();
            $rp->setNomComplet($this->faker->name());
            $rp->setEmail($this->faker->email());
            $rp->setPassword($this->faker->password());
            $manager->persist($rp);
        }
        $manager->flush();
    }
}
