<?php

namespace App\DataFixtures;

use App\Entity\Rp;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Classe;
use App\Entity\Attache;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ClasseFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(){
        $this->faker= Factory::create("fr_Fr");
    }
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i < 4; $i++) {
            $rp=new Rp();
            $rp->setNomComplet($this->faker->name());
            $rp->setEmail($this->faker->email());
            $rp->setPassword($this->faker->password());
            $manager->persist($rp); 
            $classe =new Classe();
            $classe->setNiveau('Licence '.$i);
            $classe->setFiliere('Réseaux Télécoms');
            $classe->setLibelle('Licence '.$i.'Réseaux Télécoms');
            $classe->setRp($rp);
            $manager->persist($classe);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
