<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     */
    public function newBook(Request $request, EntityManagerInterface $manager)
    {

        $book = new Book();

        $form = $this->createFormBuilder($book)
            ->add('title')
            ->add('isbn')
            ->add('description')
            ->add('price')
            ->add('stock')
            ->add('year')
            ->add('image')
            ->getForm();

        return $this->render('admin/books/new.html.twig', [
            'page_title' => 'Ajouter un livre dans la boutique',
            'formNewBook' => $form->createView()
        ]);
    }
}
