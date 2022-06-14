<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Etudiant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EtudiantFixtures extends Fixture
{
    private Generator $faker;
    public function __construct(UserPasswordHasherInterface $encoder){
        $this->faker=Factory::create("fr_Fr");
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        /* $etudiant = new Etudiant;
        $etudiant->setNomComplet('Rawane Meissa Sow');
        $etudiant->setAdresse('Sacré coeur');
        $etudiant->setSexe('Masculin');
        $etudiant->setEmail('Sow@gmail.com');
        $etudiant->setPassword('Passer');
        $etudiant->setMatricule('et'.date('Ymdhms'));
        $manager->persist($etudiant);
        $manager->flush(); */
       /*  for ($i=0; $i < 3; $i++) {
            $et = new Etudiant();
            $mdp = "Passer";
            $test = $this->encoder->hashPassword($et,$mdp);
            $et->setNomComplet($this->faker->name());
            $et->setEmail($this->faker->email());
            $et->setPassword($test);
            $et->setAdresse('Sacré coeur');
            $et->setSexe('Masculin');
            $et->setMatricule("et".date('Ymdhms').$this->faker->name()[0]);
            $manager->persist($et);
        } */
        $manager->flush();
    }
}
