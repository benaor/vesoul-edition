<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Book;
use App\Form\AvisType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 */
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
    public function showBook(Book $book, Request $request, EntityManagerInterface $manager)
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $avis->setCreatedAt(new \DateTime())
                ->setBook($book);
            $manager->persist($avis);
            $manager->flush();
            return $this->redirectToRoute('show_book', ['id' => $book->getId()]);
        }
        return $this->render('shop/show.html.twig', [
            'book' => $book,
            'formAvis' => $form->createView()
        ]);
    }

    /**
     * @Route("/search/{searchValue}", name="searchBar")
     */
    public function search(Request $request, BookRepository $bookRepository, string $searchValue)
    {
        $books = [];
        
        if( strlen( $searchValue ) >= 1 ){
            $books = $bookRepository->findTitle($searchValue);
        }
        
        $response = new Response();
        if( count($books) > 0 ){
            
            // return new JsonResponse(['books' => $book])
            $response->setContent(json_encode([
                'books' => $books,
            ]));
            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');

        }else{
            
            $response->headers->set('Content-Type', 'text/plain');
            $response->setStatusCode(Response::HTTP_NO_CONTENT);

        }

        return $response;

    }
}
