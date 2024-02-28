<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }



    
    #[Route('grade/{id}', name: 'grade_admin')]
public function grade_admin(User $user, EntityManagerInterface $em)
{
    $roles = $user->getRoles();

    if (in_array('ROLE_ADMIN', $roles)) {
        // User already has ROLE_ADMIN, so remove it
        $roles = array_diff($roles, ['ROLE_ADMIN']);
    } else {
        // User doesn't have ROLE_ADMIN, so add it
        $roles[] = 'ROLE_ADMIN';
    }

    // Set the updated roles and save to database
    $user->setRoles($roles);
    $em->flush();

    $this->addFlash('success', "La modification a bien été pris en compte");
    return $this->redirectToRoute('app_user_index');
}


#[Route('/block/{id}', name: 'block_user')]
    public function block(User $user, EntityManagerInterface $entityManager): Response
    {
        // Check if the user is an admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Only administrators can toggle user status.');
        }

        // Toggle user status between blocked and unblocked
        if (in_array('ROLE_BLOCKED', $user->getRoles(), true)) {
            // Unblock the user
            $user->setRoles(['ROLE_USER']);
            $message = 'User unblocked successfully.';
        } else {
            // Block the user

            $roles = $user->getRoles();

            if (in_array('ROLE_USER', $roles)) {
                // User already has ROLE_USER, so remove it
                $roles = array_diff($roles, ['ROLE_USER']);
            }

            if (in_array('ROLE_ADMIN', $roles)) {
                // User already has ROLE_ADMIN, so remove it
                $roles = array_diff($roles, ['ROLE_ADMIN']);
            }

            
            $roles[] = 'ROLE_BLOCKED';
            $user->setRoles($roles);

            //$user->setRoles(['ROLE_BLOCKED']);
            $message = 'User blocked successfully.';

            
        }

        // Save changes to the database
        $entityManager->flush();

        // Flash a success message
        $this->addFlash('success', $message);

        // Redirect back to the user list or any other route
        return $this->redirectToRoute('app_user_index');
    }

}
