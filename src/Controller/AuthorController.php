<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }  
    
    #[Route('/show/{name}', name: 'app_author1')]
    public function showAuthor($name){
        return $this->render('author/show.html.twig', ['n'=>$name]);
    }
   
    #[Route('/showAll', name: 'showAll')]
    public function showAll(AuthorRepository $repo ){
        $list=$repo->findAll();
        return $this->render('author/showAll.html.twig',['Authors'=>$list]);
    }

    #[Route('/showlist', name: 'showlist')]
    public function list(){
        $authors = array(
            array('id' => 1, 'picture' => '/images/victor-hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );
            return $this->render('author/list.html.twig', ['authors' => $authors]);
    }

    #[Route('/showAuthor/{id}', name:'ray')]
    public function authorDetails($id) {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );

        $foundAuthor = null;

        foreach ($authors as $author) {
            if ($author['id'] == $id) {
                $foundAuthor = $author;
                break; // Stop the loop once the author is found
            }
        }

        if ($foundAuthor !== null) {
            return $this->render('author/showAuthor.html.twig', [
                'author' => $foundAuthor,
            ]);
        } else {
            return new Response("Author not found");
        }
    }

    #[Route('/AddStatique', name: 'Add_Statique')]
public function addstatiqu(AuthorRepository $repository): Response
{
    $author1 = new Author();
    $author1->setUsername("test");
    $author1->setEmail("test@gmail.com");

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($author1);
    $entityManager->flush();

    $list = $repository->findAll();

    return $this->render('author/showAll.html.twig', [
        'Authors' => $list
    ]);
}

}
