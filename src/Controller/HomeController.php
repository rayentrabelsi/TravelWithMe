<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/Home', name: 'app_transport')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'TransportController',
        ]);
    }

    #[Route('/transportR', name: 'app_transportR')]
    public function transport(): Response
    {
        return $this->render('transport.html.twig', [
            'controller_name' => 'TransportController',
        ]);
    }

    #[Route('/Forum', name: 'app_Forum')]
    public function Forum(): Response
    {
        return $this->render('forum.html.twig', [
            'controller_name' => 'TransportController',
        ]);
    }

    #[Route('/sign_in', name: 'app_sign_in')]
    public function sign_in(): Response
    {
        return $this->render('sign_in.html.twig', [
            'controller_name' => 'TransportController',
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function register(): Response
    {
        return $this->render('register.html.twig', [
            'controller_name' => 'TransportController',
        ]);
    }

    #[Route('/back', name: 'app_back')]
    public function back(): Response
    {
        return $this->render('back.html.twig', [
            'controller_name' => 'TransportController',
        ]);
    }
}