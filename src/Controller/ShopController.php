<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
