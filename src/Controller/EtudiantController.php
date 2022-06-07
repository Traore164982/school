<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Etudiant;
use App\Form\EtudiantFormType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EtudiantController extends AbstractController
{
    #[Route('/etudiantI', name: 'app_etudiantI')]
    #[Route('/etudiant/{id}/edit', name: 'app_etudiantE')]
     public function show(Etudiant $et = null, Environment $twig, Request $request, EntityManagerInterface $entityManager): Response{
        if (!$et) {
            $et = new Etudiant();
        }
        $form = $this->createForm(EtudiantFormType::class,$et);
        $form->handleRequest($request);
        $agreeTerms = $form->get('agreeTerms')->getData();

        if ($form->isSubmitted()  && $form->isValid() && $agreeTerms) {
            $entityManager->persist($et);
            $entityManager->flush();

            return new Response($twig->render('etudiant/insert.html.twig',[
                'form' => $form -> createView(),
                'editMode' => $et->getId() !== null,
                'text'=> 'Ajouter Etudiant',
                'textBtn' =>'Ajouter Etudiant',
                'link'  => '/etudiant',
                'size' => 6
            ]));
        }

        return new Response($twig->render('etudiant/insert.html.twig',[
            'form' => $form -> createView(),
            'editMode' => $et->getId() !== null,
            'text'=> 'Ajouter Etudiant',
            'textBtn' =>'Liste des Etudiants',
            'link'  => '/etudiant',
            'size' => 6
        ]));
     }

      #[Route('/etudiant', name: 'app_etudiant')]
    public function index(EtudiantRepository $repo): Response
    {
        $etudiants = $repo->findAll();
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        'etudiants'=>$etudiants,
        'text'=> 'Liste des Etudiants',
        'textBtn' =>'Ajouter Etudiant',
        'link'  => '/etudiantI',
        'size' => 6
        ]);
    }
}
