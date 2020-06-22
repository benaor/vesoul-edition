<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/client", name="client")
 */
class ClientController extends AbstractController
{

    /**
     * @Route("/registration", name="client_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $client = new Client(); //create new Client
        $form = $this->createForm(RegistrationType::class, $client); //Create the view for Client registration
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($encoded);
            $manager->persist($client);
            $manager->flush();
            $this->redirectToRoute('client_login'); //Redirect after registration
        }

        return $this->render('client/registration.html.twig', [
            'page_title' => 'inscription',
            'formDataClient' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="client_login")
     */
    public function login()
    {
        return $this->render("client/login.html.twig", [
            'page_title' => 'Connexion'
        ]);
    }

    /**
     * @Route("/logout", name="client_logout")
     */
    public function logout()
    {
    }
}
