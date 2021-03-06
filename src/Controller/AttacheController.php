<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Attache;
use App\Form\AttacheFormType;
use App\Repository\AttacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AttacheController extends AbstractController
{
    #[Route('/attacheI', name: 'app_attacheI')]
    #[Route('/attache/{id}/edit', name: 'app_attacheE')]
    public function show(Attache $ac = null, Environment $twig, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder): Response{
        if (!$ac){
        $ac = new Attache();
        $ac->setRoles(['ROLE_AC']);
    }
       $form = $this->createForm(AttacheFormType::class,$ac);
       $form->handleRequest($request);
       $agreeTerms = $form->get('agreeTerms')->getData();

       if ($form->isSubmitted()  && $form->isValid() && $agreeTerms) {
        $test = $encoder->hashPassword($ac,"Passer");
        $ac->setPassword($test);
        $entityManager->persist($ac);
        $entityManager->flush();

           return new Response($this->redirectToRoute('app_attache'));
       }

       return new Response($twig->render('attache/insert.html.twig',[
           'form' => $form -> createView(),
           'editMode' => $ac->getId() !== null,
            'text'=> 'Ajouter Attaché',
            'textBtn' =>'Liste des Attachés',
            'link'  => '/attache',
            'size' => 6
       ]));
    }
    #[Route('/attache', name: 'app_attache')]
    public function index(AttacheRepository $repo): Response
    {   
        $attaches = $repo->findAll();
        return $this->render('attache/index.html.twig', [
            'controller_name' => 'AttacheController',
            'attaches' => $attaches,
            'text'=> 'Liste des Attachés',
            'textBtn' =>'Ajouter Attaché',
            'link'  => '/attacheI',
            'size' => 6
        ]);
    }
}
