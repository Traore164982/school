<?php

namespace App\DataFixtures;

use App\Entity\Rp;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Classe;
use App\Entity\Attache;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClasseFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(UserPasswordHasherInterface $encoder){
        $this->faker= Factory::create("fr_Fr");
        $this->encoder= $encoder;
    }
    public function load(ObjectManager $manager): void
    {

        for ($i=1; $i < 4; $i++) {
            $rp=new Rp();
            $rp->setNomComplet($this->faker->name());
            $rp->setEmail($this->faker->email());
            $mdp="Passer";
            $test = $this->encoder->hashPassword($rp,$mdp);
            $rp->setPassword($test);
            $manager->persist($rp); 
            $classe =new Classe();
            $classe->setNiveau('Licence '.$i);
            $classe->setFiliere('Réseaux Informatiques');
            $classe->setLibelle('Licence '.$i.'Réseaux Informatiques');
            $classe->setRp($rp);
            $manager->persist($classe);
        } 
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
