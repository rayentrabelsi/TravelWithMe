<?php

namespace App\Controller;

use App\Entity\TransportReservation;
use App\Form\TransportReservationType;
use App\Repository\TransportReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transport/reservation')]
class TransportReservationController extends AbstractController
{
    #[Route('/', name: 'app_transport_reservation_index', methods: ['GET'])]
    public function index(TransportReservationRepository $transportReservationRepository): Response
    {
        return $this->render('transport_reservation/index.html.twig', [
            'transport_reservations' => $transportReservationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_transport_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transportReservation = new TransportReservation();
        $form = $this->createForm(TransportReservationType::class, $transportReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transportReservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_transport_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transport_reservation/new.html.twig', [
            'transport_reservation' => $transportReservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id_reservation}', name: 'app_transport_reservation_show', methods: ['GET'])]
    public function show(TransportReservation $transportReservation): Response
    {
        return $this->render('transport_reservation/show.html.twig', [
            'transport_reservation' => $transportReservation,
        ]);
    }

    #[Route('/{id_reservation}/edit', name: 'app_transport_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TransportReservation $transportReservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransportReservationType::class, $transportReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transport_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transport_reservation/edit.html.twig', [
            'transport_reservation' => $transportReservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id_reservation}', name: 'app_transport_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, TransportReservation $transportReservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transportReservation->getIdreservation(), $request->request->get('_token'))) {
            $entityManager->remove($transportReservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transport_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
