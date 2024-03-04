<?php

namespace App\Controller;

use App\Entity\MoyTransport;
use App\Form\MoyTransportType;
use App\Repository\MoyTransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/moy/transport')]
class MoyTransportController extends AbstractController
{
    #[Route('/', name: 'app_moy_transport_index', methods: ['GET'])]
    public function index(MoyTransportRepository $moyTransportRepository): Response
    {
        $moyTransports = $moyTransportRepository->findAll();    

        return $this->render('moy_transport/index.html.twig', [
         'moy_transports' => $moyTransports,
        ]);
    }

    #[Route('/new', name: 'app_moy_transport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, string $photoDir = 'public/assets/images/explore'): Response
    {
        $moyTransport = new MoyTransport();
        $form = $this->createForm(MoyTransportType::class, $moyTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moyTransport = $form->getData();
            
            if ($photo = $form['Transport_Picture']->getData()) {
                $fileName = uniqid() . '.' . $photo->guessExtension();
                $photo->move($photoDir, $fileName);
            }
            
            $moyTransport->setTransportPicture($fileName);
            
            $entityManager->persist($moyTransport);
            $entityManager->flush();

            return $this->redirectToRoute('app_moy_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moy_transport/new.html.twig', [
            'moy_transport' => $moyTransport,
            'form' => $form,
        ]);
    }

    #[Route('/show', name: 'app_moy_transport_show', methods: ['GET'])]
    public function show(MoyTransportRepository $moyTransportRepository): Response
    {
        $moyTransports = $moyTransportRepository->findAll();    

        return $this->render('moy_transport/show.html.twig', [
         'moy_transport' => $moyTransports,
        ]);
    }

    #[Route('/{id_transport}/edit', name: 'app_moy_transport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MoyTransport $moyTransport, EntityManagerInterface $entityManager,$photoDir = 'public/assets/images/explore'): Response
    {
        $form = $this->createForm(MoyTransportType::class, $moyTransport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moyTransport = $form->getData();
            
            if ($photo = $form['Transport_Picture']->getData()) {
                $fileName = uniqid() . '.' . $photo->guessExtension();
                $photo->move($photoDir, $fileName);
            }
            
            $moyTransport->setTransportPicture($fileName);
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
        if ($this->isCsrfTokenValid('delete'.$moyTransport->getIdtransport(), $request->request->get('_token'))) {
            $entityManager->remove($moyTransport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_moy_transport_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('posts/search', name: 'search_transport')]
    public function search_transport(Request $request, EntityManagerInterface $entityManager): Response
    {
        $searchQuery = $request->query->get('search_query');

        $moyTransports= $entityManager->getRepository(MoyTransport::class)
            ->createQueryBuilder('p')
            ->where('p.transport_model LIKE :query')
            ->orWhere('p.transport_description LIKE :query')
            ->setParameter('query', '%' . $searchQuery . '%')
            ->getQuery()
            ->getResult();

        return $this->render('moy_transport/index.html.twig', [
            'moy_transports' => $moyTransports,
        ]);
    }
}
