<?php

namespace App\Controller;

use App\Form\Voyage1Type;
use App\Entity\Voyage;
use App\Form\AjoutFrontType;
use App\Repository\VoyageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/voyagefront")
 */
class VoyageFrontController extends AbstractController
{
    /**
     * @Route("/", name="app_voyage_front_index", methods={"GET"})
     */
    public function index(VoyageRepository $voyageRepository): Response
    {
        return $this->render('voyage_front/index.html.twig', [
            'voyages' => $voyageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_voyage_front_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VoyageRepository $voyageRepository): Response
    {
        $voyage = new Voyage();
        $form = $this->createForm(AjoutFrontType::class, $voyage); // Use AjoutFrontType here
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Assuming add() persists the entity
            $voyageRepository->add($voyage);
            return $this->redirectToRoute('app_voyage_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voyage_front/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_voyage_front_show", methods={"GET"})
     */
    public function show(Voyage $voyage): Response
    {
        return $this->render('voyage_front/show.html.twig', [
            'voyage' => $voyage,
        ]);
    }

     /**
     * @Route("/{id}/edit", name="app_voyage_front_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Voyage $voyage, VoyageRepository $voyageRepository): Response
    {
        $form = $this->createForm(AjoutFrontType::class, $voyage); // Use AjoutFrontType here
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voyageRepository->add($voyage);
            return $this->redirectToRoute('app_voyage_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voyage_front/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_voyage_front_delete", methods={"POST"})
     */
    public function delete(Request $request, Voyage $voyage, VoyageRepository $voyageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyage->getId(), $request->request->get('_token'))) {
            $voyageRepository->remove($voyage);
        }

        return $this->redirectToRoute('app_voyage_front_index', [], Response::HTTP_SEE_OTHER);
    }
}
