<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomeController extends AbstractController
{

    public function homePage(Request $request, Response $response): Response
    {
        $content =  $this->twig->render('homeView.html.twig');
        $response->setContent($content);

        return $response;
    }

    public function errorPage(string $error): Response
    {
        $content = $this->twig->render('errorView.html.twig', ['error' => $error]);
        $response = new Response();
        $response->setContent($content);

        return $response;
    }
}
