<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('todo')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(SessionInterface $session): Response
    {
        if (!$session->has('todos')) {
            $todos = array(
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            );
            $session->set('todos', $todos);
            $this->addFlash('info', "Bienvenu dans notre Gestionnaire de Todo");
        }
        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }

    #[Route('/delete/{name}', name: 'app_delete_todo')]
    public function delete(SessionInterface $session, $name): Response
    {
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', "Le Todo $name a été supprimé avec succès");
            } else {
                $this->addFlash('error', "Le Todo $name n'existe pas");
            }
        } else {
            $this->addFlash('error', "Rabi iehdik");
        }
        return $this->redirectToRoute('app_todo');
    }
}
