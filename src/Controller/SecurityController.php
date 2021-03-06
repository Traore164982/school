<?php

namespace App\Controller;

use App\Repository\AnneeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

   /*  #[Route('/connexion', name: 'security_login')]
    public function login(Request $request): Response
    {
        if ($request->isMethod('POST')) {            
            var_dump($request);
        }
        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    } */
    #[Route(path: '/', name: 'home')]
    public function home(AnneeRepository $anneeR): Response{
        /* $anneeR->findOneBy(["etat"=>1]);
        dd($anneeR); */
        return $this->render('security/home.html.twig');
    }



   #[Route(path: '/login', name: 'app_login')]
   public function login(AuthenticationUtils $authenticationUtils): Response
   {
       /* if ($this->getUser()) {
            return $this->redirectToRoute('target_path');
        } */

       // get the login error if there is one
       $error = $authenticationUtils->getLastAuthenticationError();
       // last username entered by the user
       $lastUsername = $authenticationUtils->getLastUsername();

       return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
   }

   #[Route(path: '/logout', name: 'app_logout')]
   public function logout(): void
   {
       throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
   }
}
