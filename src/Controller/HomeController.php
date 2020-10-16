<?php

namespace App\Controller;

final class HomeController extends ManagerController
{
    /**
     * @Route("/home")
     */
    public function homePage(): void
    {
        echo $this->twig->render('homeView.html.twig', ['newUser' => false ]);
    }

    public function errorPage($error): void
    {   
        $error = 'Erreur : ' . $error->getMessage();
        echo $this->twig->render('errorView.html.twig', ['error' => $error]);
    }
}
