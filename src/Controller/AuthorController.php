<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\AuthorType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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

#[Route('/showA/{id}', name: 'showA')]
public function showAuthor1($id,AuthorRepository $repo){
   $author=$repo->find($id);
   return $this->render('author/showA.html.twig',['author'=>$author]);
}

#[Route('/deleteAuthor/{id}', name: 'deleteAuthor')]
public function delete($id,AuthorRepository $repo,ManagerRegistry $manager){
   $author=$repo->find($id);
   $em=$manager->getManager();
   $em->remove($author);
   $em->flush();
   return $this->redirectToRoute('showAll');
}

#[Route('/addstatic', name: 'addstatic')]
public function addstatic(ManagerRegistry $manager){
$author=new Author();
$author->setUsername('foulen');
$author->setEmail('foulen@gmail.com');
$em=$manager->getManager();
$em->persist($author);
$em->flush();
return $this->redirectToRoute('showAll');
}

#[Route('/addA', name: 'addA')]
public function addA(Request $Request,ManagerRegistry $manager){
    $author=new Author();
    $form=$this->createForm(AuthorType::class,$author);
    $form->add('add',SubmitType::class);
    $form->handleRequest($Request);

    if($form->isSubmitted()){
        $em=$manager->getManager();
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute('showAll');
    }
    return $this->render('author/addAuthor.html.twig',['form'=>$form->createview()]);
}

#[Route('/updateAuth/{id}', name: 'updateAuth')]
public function updateAuth($id,AuthorRepository $repo,ManagerRegistry $manager,Request $Request){
      $author=$repo->find($id);
      $form=$this->createForm(AuthorType::class,$author);
      $form->add('update',SubmitType::class);
      $form->handleRequest($Request);

      if($form->isSubmitted()){
        $em=$manager->getManager();
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute('showAll');
    }
      return $this->render('author/update.html.twig',['form'=>$form->createview()]);
}

}
