<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VoyageRepository;

class HomeController extends AbstractController
{
    #[Route('/Home', name: 'app_transport')]
    public function index(VoyageRepository $voyageRepository): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'TransportController',
            'voyages' => $voyageRepository->findAllWithDetails(),
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
    public function Forum(PostRepository $postRepository,CommentRepository $commentRepository): Response
    {
        // Fetch posts from the repository
        $posts = $postRepository->findAll();
        return $this->render('forum.html.twig', [
            'controller_name' => 'TransportController',
            'posts' => $posts,
            'comments1' => $commentRepository->findAll(),
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

    #[Route('/stats', name: 'app_stats')]
    public function statistiquess(CalendarRepository $transprepo)
    {
        $transprepo = $transprepo->findAll();

        $transpId = [];
        
        foreach( $transprepo as $transport_reservations){
            $transpId[] = $transport_reservations->getTransport()->getTransportModel();
            $occurrences = array_count_values($transpId);
        }


        return $this->render('stats.html.twig', [
            'transpId' => json_encode($transpId),
            'transpIdCount' => json_encode($occurrences),
        ]);
    }

    #[Route('/statsC', name: 'app_statsC')]
    public function statistiques(CommentRepository $transprepo)
    {
        $transprepo = $transprepo->findAll();

        $transpId = [];
        
        foreach( $transprepo as $transport_reservations){
            $transpId[] = $transport_reservations->getPost()->getAuthor();
            $occurrences = array_count_values($transpId);
        }


        return $this->render('statsC.html.twig', [
            'transpId' => json_encode($transpId),
            'transpIdCount' => json_encode($occurrences),
        ]);
    }

    #[Route('/localisation', name: 'app_localisation')]
    public function localisation(): Response
    {
        return $this->render('localisation.html.twig', [
            'controller_name' => 'TransportController',
        ]);
    }
}