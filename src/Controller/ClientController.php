<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\RegistrationType;
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
    public function registration()
    {
        $user = new Client(); //create new user
        $form = $this->createForm(RegistrationType::class, $user); //Create the view for user registration

        return $this->render('client/registration.html.twig', [
            'page_title' => 'inscription',
            'form' => $form->createView()
        ]);
    }
}
