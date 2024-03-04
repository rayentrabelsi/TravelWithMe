<?php

namespace App\Controller;

use App\Entity\Accomodation;
use App\Form\AccomodationType;
use App\Repository\AccomodationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/accomodation')]
class AccomodationController extends AbstractController
{
    #[Route('/', name: 'app_accomodation_index', methods: ['GET'])]
    public function index(AccomodationRepository $accomodationRepository): Response
    {
        return $this->render('accomodation/index.html.twig', [
            'accomodations' => $accomodationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_accomodation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $accomodation = new Accomodation();
        $form = $this->createForm(AccomodationType::class, $accomodation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($accomodation);
            $entityManager->flush();

            return $this->redirectToRoute('app_accomodation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accomodation/new.html.twig', [
            'accomodation' => $accomodation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accomodation_show', methods: ['GET'])]
    public function show(Accomodation $accomodation): Response
    {
        return $this->render('accomodation/show.html.twig', [
            'accomodation' => $accomodation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_accomodation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Accomodation $accomodation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AccomodationType::class, $accomodation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_accomodation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('accomodation/edit.html.twig', [
            'accomodation' => $accomodation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accomodation_delete', methods: ['POST'])]
    public function delete(Request $request, Accomodation $accomodation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accomodation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($accomodation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_accomodation_index', [], Response::HTTP_SEE_OTHER);
    }
}
