<?php

namespace App\Controller;

use App\Entity\Rp;
use Twig\Environment;
use App\Form\RpFormType;
use App\Repository\RpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RpController extends AbstractController
{
    #[Route('/rpI', name: 'app_rpI')]
    public function show(Environment $twig, Request $request, EntityManagerInterface $entityManager): Response{
       $rp = new Rp();
       $form = $this->createForm(RpFormType::class,$rp);
       $form->handleRequest($request);
       $agreeTerms = $form->get('agreeTerms')->getData();

       if ($form->isSubmitted()  && $form->isValid() && $agreeTerms) {

           $entityManager->persist($rp);
           $entityManager->flush();

           return new Response("RP number ".$rp->getId(). "created");
       }

       return new Response($twig->render('rp/insert.html.twig',[
           'form' => $form -> createView(),
       ]));
    }
    
    #[Route('/rp', name: 'app_rp')]
    public function index(RpRepository $repo): Response
    {   $rps = $repo->findAll();
        return $this->render('rp/index.html.twig', [
            'controller_name' => 'RpController',
            'rps'=>$rps,
            'title' =>'Liste des Responasables Pédagoqiques'
        ]);
    }
}
