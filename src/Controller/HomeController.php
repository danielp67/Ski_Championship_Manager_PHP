<?php

namespace App\Controller;

final class HomeController extends ManagerController
{
    public function loginPage(): void
    {
        echo $this->twig->render('homeView.html.twig', ['newUser' => false ]);
    }

    public function newUserPage(): void
    {
        echo $this->twig->render('homeView.html.twig', ['newUser' => true]);
    }

    public function errorPage($error): void
    {   
        $error = 'Erreur : ' . $error->getMessage();
        echo $this->twig->render('errorView.html.twig', ['error' => $error]);
    }
}
