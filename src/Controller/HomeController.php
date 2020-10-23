<?php

namespace App\Controller;

final class HomeController extends AbstractController
{

    public function homePage(): void
    {
        echo $this->twig->render('homeView.html.twig');
    }

    public function errorPage($error): void
    {
        echo $this->twig->render('errorView.html.twig', ['error' => $error]);
    }
}
