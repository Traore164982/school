<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Demande;
use App\Form\DemandeFormType;
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeController extends AbstractController
{
    #[Route('/demandeI', name: 'app_demandeI')]
    #[Route('/demande/{id}/edit', name: 'app_demandeE')]
    public function show(Demande $demande, Environment $twig, Request $request, EntityManagerInterface $entityManager): Response{
        if (!$demande){
             $demande = new Demande();
        }
        $form = $this->createForm(DemandeFormType::class,$demande);
       $form->handleRequest($request);
       $agreeTerms = $form->get('agreeTerms')->getData();

       if ($form->isSubmitted()  && $form->isValid() && $agreeTerms) {

           $entityManager->persist($demande);
           $entityManager->flush();

           return new Response("RP number ".$demande->getId(). "created");
       }

       return new Response($twig->render('demande/insert.html.twig',[
           'form' => $form -> createView(),
           'editMode' => $demande->getId() !== null,
           'text'=> 'Ajouter Demande',
            'textBtn' =>'Liste des Demandes',
            'link'  => '/demande',
            'size' => 6
           
       ]));
    }
    #[Route('/demande', name: 'app_demande')]
    public function index(DemandeRepository $repo): Response
    {
        $demandes = $repo->findAll();
        return $this->render('demande/index.html.twig', [
            'controller_name' => 'DemandeController',
            'demandes'=>$demandes,
            'text'=> 'Liste des Demandes',
            'textBtn' =>'Ajouter Demandes',
            'link'  => '/demandeI',
            'size' => 6
        ]);
    }
}
