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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RpController extends AbstractController
{
    #[Route('/rpI', name: 'app_rpI')]
    #[Route('/rp/{id}/edit', name: 'app_rpE')]
    public function show(Rp $rp = null, Environment $twig, Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $encoder): Response{
        if (!$rp){
             $rp = new Rp();
             $rp->setRoles(['ROLE_RP']);
        }
        $form = $this->createForm(RpFormType::class,$rp);
        $form->handleRequest($request);
        $agreeTerms = $form->get('agreeTerms')->getData();

       if ($form->isSubmitted()  && $form->isValid() && $agreeTerms) {

            $test = $encoder->hashPassword($rp,"Passer");
            $rp->setPassword($test);
           $entityManager->persist($rp);
           $entityManager->flush();

           return $this->redirectToRoute('app_rp');
       }

       return new Response($twig->render('rp/insert.html.twig',[
           'form' => $form -> createView(),
           'editMode' => $rp->getId() !== null,
           'text'=> 'Ajouter Responsable Pédagoqique',
            'textBtn' =>'Liste des Responsables Pédagoqiques',
            'link'  => '/rp',
            'size' => 6
           
       ]));
    }
    
    #[Route('/rp', name: 'app_rp')]
    public function index(RpRepository $repo): Response
    {   $rps = $repo->findAll();
        return $this->render('rp/index.html.twig', [
            'controller_name' => 'RpController',
            'rps'=>$rps,
            'textBtn'=> 'Ajouter Responsable Pédagoqique',
            'text' =>'Liste des Responsables Pédagoqiques',
            'link'  => '/rpI',
            'size' => 6
        ]);
    }
}
