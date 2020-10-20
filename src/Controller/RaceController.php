<?php

namespace App\Controller;

use App\Model\Race;
use Symfony\Component\HttpFoundation\Request;

final class RaceController extends ManagerController
{
    public function racePage(): void
    {
        echo $this->twig->render('raceView.html.twig');
    }

    public function raceAdd(): void
    {
        echo $this->twig->render('raceAdd.html.twig');
    }

    public function raceCheck(): void
    {
        $request = Request::createFromGlobals();
        var_dump($request->request);
        $race = new Race();
    }

    public function errorPage($error): void
    {   
        $error = 'Erreur : ' . $error->getMessage();
        echo $this->twig->render('errorView.html.twig', ['error' => $error]);
    }
}
