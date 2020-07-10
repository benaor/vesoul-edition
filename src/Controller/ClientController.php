<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\RegistrationType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/client")
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
            $client->setPassword($encoded)
            ->setRoles('ROLE_USER');
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
        return $this->render('client/login.html.twig', [
            'page_title' => 'Connexion'
        ]);
    }

    /**
     * @Route("/logout", name="client_logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/infos", name="client_infos")
     */
    public function infoClient(ClientRepository $clientRepository)
    {
        $client = $this->getUser();       
        return $this->render('client/infoClient.html.twig', [
            'page_title' => 'informations client',
            'client' => $client
        ]);
    }

    /**
     * @Route("/edit/{id}", name="client_edit")
     */
    public function informationsClient(Client $client = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        if (!$client) {
            $client = new Client();
        }

        $form = $this->createForm(RegistrationType::class, $client); //Create the view for Client registration
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($client, $client->getPassword());
            $client->setPassword($encoded);
            $manager->persist($client);
            $manager->flush();
            $this->redirectToRoute('client_login'); //Redirect after registration
        }

        return $this->render('client/editClient.html.twig', [
            'page_title' => 'modifier les informations personnelles',
            'formDataClient' => $form->createView(),
            'client' => $client
        ]);
    }
}
