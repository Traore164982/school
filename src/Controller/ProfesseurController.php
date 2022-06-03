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
    public function show(Environment $twig, Request $request, EntityManagerInterface $entityManager): Response{
       $p = new Professeur();
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
       ]));
    }

    #[Route('/professeur', name: 'app_professeur')]
    public function index(ProfesseurRepository $repo): Response
    {   $profs = $repo->findAll();
        return $this->render('professeur/index.html.twig', [
            'controller_name' => 'ProfesseurController',
            "profs"=>$profs,
            "title" => "Liste des Professeurs"
        ]);
    }
}
