<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Etudiant;
use App\Entity\Inscription;
use App\Form\EtudiantFormType;
use App\Form\InscriptionFormType;
use App\Repository\AnneeRepository;
use App\Repository\ClasseRepository;
use App\Repository\AttacheRepository;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EtudiantController extends AbstractController
{
    #[Route('/etudiantI', name: 'app_etudiantI')]
    #[Route('/etudiant/{id}/edit', name: 'app_etudiantE')]
     public function show(Etudiant $et = null, Environment $twig, Request $request, EntityManagerInterface $entityManager,RequestStack $session,ClasseRepository $classeR,AnneeRepository $anneeR,AttacheRepository $acR,UserPasswordHasherInterface $encoder): Response{
        if (!$et) {
            $et= new Etudiant();
            $ins = new Inscription(); 
            $et->setRoles(['ROLE_ETUDIANT']);
        }
        $ins->setEtudiant($et);
        $form = $this->createForm(InscriptionFormType::class,$ins);
        $form->handleRequest($request);

        if ($form->isSubmitted()  && $form->isValid()) {
            $test = $encoder->hashPassword($et,"Passer");
            $et->setPassword($test);
            $ins->setAttache($this->getUser());
            $entityManager->persist($et);
            $entityManager->persist($ins);
            $entityManager->flush();

            return new Response($this->redirectToRoute('app_etudiant'));
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


     #[Route('/etudiant/{id}/Reinscrire', name: 'app_etudiantR')]
     public function reinscrire(Etudiant $et, Environment $twig,Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder): Response{
        $ins = new Inscription();
        $ins->setEtudiant($et);
        $form = $this->createForm(InscriptionFormType::class,$ins);
        $form->handleRequest($request);

        if ($form->isSubmitted()  && $form->isValid()) {
            $test = $encoder->hashPassword($et,"Passer");
            $et->setPassword($test);
            $ins->setAttache($this->getUser());
            $entityManager->persist($et);
            $entityManager->persist($ins);
            $entityManager->flush();

            return new Response($this->redirectToRoute('app_etudiant'));
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
