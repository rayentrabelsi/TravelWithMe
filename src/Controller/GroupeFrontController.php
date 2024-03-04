<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Form\GroupeType;
use App\Form\Groupe1Type;
use App\Repository\GroupeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/groupefront")
 */
class GroupeFrontController extends AbstractController
{
    /**
     * @Route("/", name="app_groupe_front_index", methods={"GET"})
     */
    public function index(GroupeRepository $groupeRepository): Response
    {
        return $this->render('groupe_front/index.html.twig', [
            'groupes' => $groupeRepository->findAll(),
        ]);
    }

    /**
     * @Route("new", name="app_groupe_front_new", methods={"GET", "POST"})
     */
    public function new(Request $request, GroupeRepository $groupeRepository): Response
    {
        $groupe = new Groupe();
        $form = $this->createForm(Groupe1Type::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupeRepository->add($groupe);
            return $this->redirectToRoute('app_groupe_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('groupe_front/new.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_groupe_front_show", methods={"GET"})
     */
    public function show(Groupe $groupe): Response
    {
        return $this->render('groupe_front/show.html.twig', [
            'groupe' => $groupe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_groupe_front_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Groupe $groupe, GroupeRepository $groupeRepository): Response
    {
        $form = $this->createForm(Groupe1Type::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupeRepository->add($groupe);
            return $this->redirectToRoute('app_groupe_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('groupe_front/edit.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_groupe_front_delete", methods={"POST"})
     */
    public function delete(Request $request, Groupe $groupe, GroupeRepository $groupeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupe->getId(), $request->request->get('_token'))) {
            $groupeRepository->remove($groupe);
        }

        return $this->redirectToRoute('app_groupe_front_index', [], Response::HTTP_SEE_OTHER);
    }
}
