<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Etudiant;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EtudiantFixtures extends Fixture
{
    private Generator $faker;
    public function __construct(){
        $this->faker=Factory::create("fr_Fr");
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
    }
}
