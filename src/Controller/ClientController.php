<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/client", name="client")
 */
class ClientController extends AbstractController
{

    /**
     * @Route("/registration", name="client_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager)
    {
        $user = new Client(); //create new user
        $form = $this->createForm(RegistrationType::class, $user); //Create the view for user registration
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('client/registration.html.twig', [
            'page_title' => 'inscription',
            'formDataClient' => $form->createView()
        ]);
    }
}
