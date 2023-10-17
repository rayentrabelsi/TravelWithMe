<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\BookType;
use App\Entity\Book;
use App\Entity\Author;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/addB', name: 'addB')]
    public function addBook(Request $request,ManagerRegistry $manager)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $book->setPublished(true);
            $author = $book->getAuthors();
            $author->setNbBooks($author->getNbBooks() + 1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->persist($author); 
            $em->flush();
    
            return $this->redirectToRoute('addB');
        }
    
        return $this->render('book/addBook.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    #[Route('/books', name: 'list_books')]
public function listBooks(BookRepository $repo): Response
{
    $publishedBooks = $repo->findBy(['published' => true]);
    $unpublishedBooks = $repo->findBy(['published' => false]);

    $publishedCount = count($publishedBooks);
    $unpublishedCount = count($unpublishedBooks);

    $allBooks = $repo->findAll(); 

    return $this->render('book/list_books.html.twig', [
        'publishedBooks' => $publishedBooks,
        'unpublishedBooks' => $unpublishedBooks,
        'publishedCount' => $publishedCount,
        'unpublishedCount' => $unpublishedCount,
        'allBooks' => $allBooks,
    ]);
}

#[Route('/editBook/{ref}', name: 'edit_book')]
    public function editBook($ref, BookRepository $repo, Request $request): Response
    {
        $book = $repo->find($ref);
        $form = $this->createForm(BookType::class, $book);
        $form->add('Save',SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('list_books');
        }

        return $this->render('book/updateB.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/deleteB/{ref}', name: 'deleteB')]
public function delete($ref,BookRepository $repo,ManagerRegistry $manager){
   $book=$repo->find($ref);
   $em=$manager->getManager();
   $em->remove($book);
   $em->flush();
   return $this->redirectToRoute('list_books');
}

#[Route('/showB/{ref}', name: 'showB')]
public function showBook($ref,BookRepository $repo){
   $book=$repo->find($ref);
   return $this->render('book/showB.html.twig',['book'=>$book]);
}

}
