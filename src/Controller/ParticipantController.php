<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

final class ParticipantController extends AbstractController
{
    public function participantPage(): void
    {
        echo $this->twig->render('participantView.html.twig');
    }

    public function participantAdd(): void
    {
        echo $this->twig->render('participantAdd.html.twig');
    }

    public function participantCheck(): void
    {
        $request = Request::createFromGlobals();
        var_dump($request->request);
        var_dump($request->files);

        
      //  echo $this->twig->render('participantAdd.html.twig');
    }
}
