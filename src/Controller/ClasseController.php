<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Classe;
use App\Form\ClasseFormType;
use App\Repository\ClasseRepository;
use COM;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClasseController extends AbstractController
{
    #[Route('/classeI', name: 'app_classeI')]
    #[Route('/classe/{id}/edit', name: 'app_classeE')]
    public function show(Classe $classe = null, Environment $twig, Request $request, EntityManagerInterface $entityManager): Response{
        if (!$classe) {
            $classe = new Classe();
            
        }
        $form = $this->createForm(ClasseFormType::class,$classe);
       $form->handleRequest($request);
       $agreeTerms = $form->get('agreeTerms')->getData();

       if ($form->isSubmitted()  && $form->isValid() && $agreeTerms) {

           $entityManager->persist($classe);
           $entityManager->flush();

           return new Response("Classe number ".$classe->getId(). "created");
       }

       return new Response($twig->render('classe/insert.html.twig',[
           'form' => $form -> createView(),
           'editMode' => $classe->getId() !== null,
           'text'=> 'Ajouter Classe',
           'textBtn' =>'Liste des CLasses',
           'link'  => '/classe',
           'size' => 6
       ]));
    }
    #[Route('/classe', name: 'app_classe')]
    public function index(ClasseRepository $repo): Response
    {   $classes = $repo->findAll();
        return $this->render('classe/index.html.twig', [
            'controller_name' => 'ClasseController',
            'classes' => $classes,
            'text'=> 'Ajouter Classe',
            'textBtn' =>'Liste des Classes',
            'link'  => '/classeI',
            'size' => 6
        ]);
    }
}
