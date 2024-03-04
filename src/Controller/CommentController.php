<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\React;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comment')]
class CommentController extends AbstractController
{

    #[Route('/', name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository,PostRepository $postRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
            'posts' => $postRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $postId = $request->query->get('postId');
        $post = $entityManager->getRepository(Post::class)->find($postId);
        $react = new React(0,0);
        $comment = new Comment($react,0);
        $comment->setPost($post);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();


            flash()->addSuccess('Votre Commentaire est envoyé avec succés');
            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'postId' =>  $postId,
        ]);
    }
 #[Route('/reply', name: 'app_comment_reply', methods: ['GET', 'POST'])]
    public function reply(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parentId = $request->query->get('parentId');
        $postId = $request->query->get('postId');
        $parentComment = $entityManager->getRepository(Comment::class)->find($parentId);
        $react = new React(0,0);
        $comment = new Comment($react,0);
        $comment->setParentcomment($parentComment);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (isset($parentComment)) {
                $comment->setPost(null);
            }
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/reply.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'postId' =>  $postId,
        ]);
    }

    #[Route('/{id_comment}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {    // Récupérer les commentaires triés par date
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(
            ['createdAt' => 'ASC'] // Tri par date de création (ASC pour ascendant, DESC pour descendant)
        );

        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id_comment}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id_comment}', name: 'app_comment_delete', methods: ['POST'])]
    public function delete(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getIdcomment(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/signaler/{id}', name: 'comment_signaler')]
    public function signalercomment(comment $comment,Request $request,EntityManagerInterface $entityManager): Response
    {
        $comment -> incrementSignaler();
        $entityManager->flush();
        if($comment->getsignaler()>=3)
        { $entityManager->remove($comment);
            $entityManager->flush();
            $this->addFlash('success','le commentaire a été supprimé a cause de signalement repeté.');
        }
        else
        { $this->addFlash('success','le commentaire a été signaler avec succes');
    }
        return $this->redirectToRoute('app_Forum');
    }

    #[Route('/Like/{id}', name: 'comment_like')]
    public function likeComment(comment $comment,Request $request,EntityManagerInterface $entityManager): Response
    {
        if (!str_contains($comment->getReacts()->getUserlike(), $comment->getAuthorC())) {
            $comment->getReacts()->incrementLikes($comment->getAuthorC());
        }else
        {
            $comment->getReacts()->decrementLikes($comment->getAuthorC());

        }
        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirectToRoute('app_Forum');
    }
    #[Route('/disLike/{id}', name: 'comment_dislike')]
    public function dislikeComment(comment $comment,Request $request,EntityManagerInterface $entityManager): Response
    { if (!str_contains($comment->getReacts()->getUserdislike(), $comment->getAuthorC())) {
        $comment->getReacts()->incrementDislike($comment->getAuthorC());
    }else
    {
        $comment->getReacts()->decrementDislike($comment->getAuthorC());

    }
        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirectToRoute('app_Forum');
    }

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    private EntityManagerInterface $em;
}

