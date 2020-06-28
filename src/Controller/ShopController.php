<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Book;
use App\Form\AvisType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("/search", name="searchBar")
     */
    public function search(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            $title = $request->query->get('book');
            $conn = $this->get('database_connection');
            $query = "SELECT * FROM book WHERE book.title LIKE '%'.$title.'%";
            $rows = $conn->fetchAll($query);
            return new JsonResponse(array('data' => json_encode($rows)));
        }
    }
}
