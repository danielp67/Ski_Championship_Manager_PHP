<?php

namespace App\Controller;

final class RaceController extends ManagerController
{
    public function racePage(): void
    {
        echo $this->twig->render('raceView.html.twig');
    }

    public function errorPage($error): void
    {   
        $error = 'Erreur : ' . $error->getMessage();
        echo $this->twig->render('errorView.html.twig', ['error' => $error]);
    }
}
