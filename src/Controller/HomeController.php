<?php

namespace App\Controller;

final class HomeController extends ManagerController
{

    public function homePage($request, $response): void
    {   
       echo $this->twig->render('homeView.html.twig', ['newUser' => false ]);
    }

    public function errorPage($error): void
    {   
        $error = 'Erreur : ' . $error->getMessage();
        echo $this->twig->render('errorView.html.twig', ['error' => $error]);
    }
}
