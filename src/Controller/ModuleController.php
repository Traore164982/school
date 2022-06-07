<?php

namespace App\Controller;

use App\Entity\Module;
use Twig\Environment;
use App\Form\ModuleFormType;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    #[Route('/moduleI', name: 'app_moduleI')]
    #[Route('/module/{id}/edit', name: 'app_moduleE')]
    public function show(Module $m=null, Environment $twig, Request $request, EntityManagerInterface $entityManager): Response{
        if (!$m) {        
        $m = new Module();
    }
       $form = $this->createForm(ModuleFormType::class,$m);
       $form->handleRequest($request);
       $agreeTerms = $form->get('agreeTerms')->getData();
        
       if ($form->isSubmitted()  && $form->isValid() && $agreeTerms) {

           $entityManager->persist($m);
           $entityManager->flush();

           return new Response("Module number ".$m->getId(). "created");
       }

       return new Response($twig->render('module/insert.html.twig',[
           'form' => $form -> createView(),
           'editMode' => $m->getId() !== null,
           'text'=> 'Ajouter Module',
            'textBtn' =>'Liste des Modules',
            'link'  => '/module',
            'size' => 6
       ]));
    }
    #[Route('/module', name: 'app_module')]
    public function index(ModuleRepository $repo): Response
    {
        $modules = $repo->findAll();
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
            'modules' => $modules,
            'text'=> 'liste des Modules',
            'textBtn' =>'Ajouter Module',
            'link'  => '/moduleI',
            'size' => 6
        ]);
    }
}
