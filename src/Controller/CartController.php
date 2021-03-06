<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart")
     */
    public function cart(SessionInterface $session, BookRepository $bookRepo)
    {
        $panier = $session->get('panier', []);
    
        $panierWithData = [];

        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'book'=> $bookRepo->find($id),
                'quantity'=> $quantity
            ];
        }

        $total = 0;
        foreach ($panierWithData as $book) {
            $totalArticle = $book['book']->getPrice()*$book['quantity'];
            $total += $totalArticle;
        }

        return $this->render('cart/cart.html.twig', [
            'controller_name' => 'Votre Panier',
            'articlesInCart' => $panierWithData,
            'total'=> $total
        ]);

    }

    /**
     * @Route("/{id}/add", name="cart_add")
     */
    public function addToCart($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/{id}/remove", name="cart_remove")
     */
    public function removeToCart($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (($panier[$id]) > 1) {
            $panier[$id]--;
        } else {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/{id}/delete", name="cart_delete")
     */
    public function deleteCart($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])){
            unset($panier[$id]);
        } 

        $session->set('panier', $panier);
        return $this->redirectToRoute('cart');
    }
}
