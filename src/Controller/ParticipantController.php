<?php

namespace App\Controller;

final class ParticipantController extends ManagerController
{
    public function participantPage(): void
    {
        echo $this->twig->render('participantView.html.twig');
    }

    public function errorPage($error): void
    {   
        $error = 'Erreur : ' . $error->getMessage();
        echo $this->twig->render('errorView.html.twig', ['error' => $error]);
    }
}
