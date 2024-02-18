<?php

namespace App\Controller;

use App\Entity\MoyTransport;
use App\Form\MoyTransportType;
use App\Repository\MoyTransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/moy/transport')]
class MoyTransportController extends AbstractController
{
    #[Route('/', name: 'app_moy_transport_index', methods: ['GET'])]
    public function index(MoyTransportRepository $moyTransportRepository): Response
    {
        return $this->render('moy_transport/index.html.twig', [
            'moy_transports' => $moyTransportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_moy_transport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $moyTransport = new MoyTransport();
        $form = $this->createForm(MoyTransportType::class, $moyTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($moyTransport);
            $entityManager->flush();

            return $this->redirectToRoute('app_moy_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moy_transport/new.html.twig', [
            'moy_transport' => $moyTransport,
            'form' => $form,
        ]);
    }

    #[Route('/{id_transport}', name: 'app_moy_transport_show', methods: ['GET'])]
    public function show(MoyTransport $moyTransport): Response
    {
        return $this->render('moy_transport/show.html.twig', [
            'moy_transport' => $moyTransport,
        ]);
    }

    #[Route('/{id_transport}/edit', name: 'app_moy_transport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MoyTransport $moyTransport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MoyTransportType::class, $moyTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_moy_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moy_transport/edit.html.twig', [
            'moy_transport' => $moyTransport,
            'form' => $form,
        ]);
    }

    #[Route('/{id_transport}', name: 'app_moy_transport_delete', methods: ['POST'])]
    public function delete(Request $request, MoyTransport $moyTransport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moyTransport->getIdTransport(), $request->request->get('_token'))) {
            $entityManager->remove($moyTransport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_moy_transport_index', [], Response::HTTP_SEE_OTHER);
    }
}
