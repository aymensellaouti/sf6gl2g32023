<?php

namespace App\Controller;

use App\Service\PremierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route(
        '/first/{section<[0-1]?\d{1,2}>}',
        name: 'app_first',
//        requirements: ['section' => '[0-1]?\d{1,2}'],
        defaults: ['section' => 'GL2G3']
    )]
    public function index($section, Request $request, SessionInterface $session): Response
    {


        if($session->has('nbVisite')) {
            $nbVisite = $session->get('nbVisite');
            $nbVisite++;
            $welcomingMessage = "Merci pour votre fidélité c'est votre $nbVisite éme viste";
            $session->set('nbVisite', $nbVisite);

        } else {
            $session->set('nbVisite', 1);
            $this->addFlash('success', 'Premier accès');
            $welcomingMessage = "Bienvenu";
        }
        $premierService = new PremierService();
        return $this->render('first/index.html.twig', [
            'message' => $premierService->sayHello($section),
            'welcomingMessage' => $welcomingMessage
        ]);
    }

    #[Route('hello')]
    public function hello() {
        return new Response('<h1>Hello</h1>');
    }
}
