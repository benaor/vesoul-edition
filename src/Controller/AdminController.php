<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
     * @Route("/books/edit/{id}", name="admin_edit_book")
     */
    public function newBook(Book $book = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$book) {
            $book = new Book();
        }
        else {
            $book->setTitle('test');
        }

        $form = $this->createFormBuilder($book)
            ->add('title', TextType::class, [
                'label' => 'Titre du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('isbn', TextType::class, [
                'label' => 'Code ISBN du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('stock', NumberType::class, [
                'label' => 'Nombre de livre en stock',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('year', NumberType::class, [
                'label' => 'Date de sortie du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('image', TextType::class, [
                'label' => 'image du livre',
                'label_attr' => [
                    'class' => 'font-weight-bold py-1 m-0 col-4'
                ],
                'attr' => [
                    'class' => 'my-1 col-7'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'enregistrer',
                'attr' => [
                    'class' => 'btn btn-secondary text-light'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($book);
            $manager->flush();
            return $this->redirectToRoute('show_book', ['id' => $book->getId()]);
        }

        return $this->render('admin/books/new.html.twig', [
            'page_title' => 'Ajout/modification d\'un livre dans la boutique',
            'formNewBook' => $form->createView()
        ]);
    }
}
