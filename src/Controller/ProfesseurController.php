<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Professeur;
use App\Form\ProfesseurFormType;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfesseurController extends AbstractController
{
    #[Route('/professeurI', name: 'app_professeurI')]
    #[Route('/professeur/{id}/edit', name: 'app_professeurE')]
    public function show(Professeur $p = null, Environment $twig, Request $request, EntityManagerInterface $entityManager): Response{
       if (!$p) {        
        $p = new Professeur();
    }
       $form = $this->createForm(ProfesseurFormType::class,$p);
       $form->handleRequest($request);
       $agreeTerms = $form->get('agreeTerms')->getData();
        
       if ($form->isSubmitted()  && $form->isValid() && $agreeTerms) {

           $entityManager->persist($p);
           $entityManager->flush();

           return new Response("Professeur number ".$p->getId(). "created");
       }

       return new Response($twig->render('professeur/insert.html.twig',[
           'form' => $form -> createView(),
           'editMode' => $p->getId() !== null,
           'text'=> 'Ajouter Professeur',
            'textBtn' =>'Liste des Professeurs',
            'link'  => '/professeur',
            'size' => 6
       ]));
    }

    #[Route('/professeur', name: 'app_professeur')]
    public function index(ProfesseurRepository $repo): Response
    {   $profs = $repo->findAll();
        return $this->render('professeur/index.html.twig', [
            'controller_name' => 'ProfesseurController',
            "profs"=>$profs,
            'textBtn'=> 'Ajouter Professeur',
            'text' =>'Liste des Professeurs',
            'link'  => '/professeurI',
            'size' => 6
        ]);
    }
}
