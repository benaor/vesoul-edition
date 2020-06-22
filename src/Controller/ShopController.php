<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    /**
     * @Route("/", name="shop-home")
     */
    public function index(BookRepository $bookRepository)
    {
        return $this->render('shop/shop.html.twig', [
            'page_title' => 'Boutique Vesoul-edition',
            'books' => $bookRepository->findAll()
        ]);
    }

    /**
     * @route("/book/{id}", name="show_book")
     */
    public function showBook(Book $book)
    {
        return $this->render('shop/show.html.twig', [
            'book' => $book
        ]);
    }
}
