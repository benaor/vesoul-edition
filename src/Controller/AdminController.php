<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="dashboard_admin")
     */
    public function adminDashboard()
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/books", name="admin_crud_books")
     */
    public function books(BookRepository $bookRepository)
    {
        return $this->render('admin/books.html.twig', [
            'page_title' => 'Gestion des Livres',
            'books' => $bookRepository->findAll()
        ]);
    }

    /**
     * @Route("/books/new", name="admin_new_book")
     * @Route("/books/edit/{id}", name="admin_edit_book")
     */
    public function formBook(Book $book = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$book) {
            $book = new Book();
        }

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($book->getImage() !==null) {
                $file = $form->get('image')->getData();
                $fileName = uniqid(). '.' . $file->guessExtension();
                // dd($file, $fileName);
                try {
                    dd($file->move($this->getParameter('images_directory', $file)));
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $book->setImage($fileName);
            }

            $manager->persist($book);
            $manager->flush();
            return $this->redirectToRoute('show_book', ['id' => $book->getId()]);
        }

        return $this->render('admin/books/new.html.twig', [
            'page_title' => 'Ajout/modification d\'un livre dans la boutique',
            'formNewBook' => $form->createView(),
            'editMode' => $book->getId() !== null
        ]);
    }

    /**
     * @Route("/books/delete/{id}", name="admin_delete_book")
     */
    public function deleteBook(Book $book, EntityManagerInterface $manager)
    {
        $manager->remove($book);
        $manager->flush();
        return $this->redirectToRoute('admin_crud_books');
    }

}
