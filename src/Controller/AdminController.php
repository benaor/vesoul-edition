<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
    public function newBook(Request $request, EntityManagerInterface $manager){
        if ($request->request->count() > 0) {
            $book = new Book();
            $book->setTitle($request->request->get('title'))
                ->setIsbn($request->request->get('isbn'))
                ->setDescription($request->request->get('description'))
                ->setPrice($request->request->get('price'))
                ->setStock($request->request->get('stock'))
                ->setYear($request->request->get('year'))
                ->setImage($request->request->get('image'));

            $manager->persist($book);
            $manager->flush();
        }
        return $this->render('admin/books/new.html.twig', [
            'page_title' => 'Ajouter un livre dans la boutique',
        ]);
    }

}
