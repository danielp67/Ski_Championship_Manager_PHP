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

    public function homeLogo(Request $request, Response $response): Response
    {
        $localDirectory =  $request->server->get('DOCUMENT_ROOT');
        $theImage = $localDirectory . '/data/img/logo.png';
        $response->headers->set('content-type', 'image/jpeg');
        $response->setContent(file_get_contents($theImage));
        
        return $response;
    }


    public function homePicture(Request $request, Response $response): Response
    {
        $localDirectory =  $request->server->get('DOCUMENT_ROOT');

        $params = explode('/', $request->getPathInfo());
        $theImage = $localDirectory . '/data/img/ski' . $params[3] . '.jpg';
        $response->headers->set('content-type', 'image/jpeg');
        $response->setContent(file_get_contents($theImage));

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
