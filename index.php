<?php

use App\Controller\HomeController;
use JsonSchema\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Loader\YamlFileLoader;

require __DIR__.'/vendor/autoload.php';

echo date('Y-m-d H:i:s');

try
{
    // Load routes from the yaml file
    $fileLocator = new FileLocator(array(__DIR__.'/config'));
    $loader = new YamlFileLoader($fileLocator);
    $routes = $loader->load('routes.yaml');
    // Init RequestContext object
    $context = new RequestContext();
    $context->fromRequest(Request::createFromGlobals());

    // Init UrlMatcher object
    $matcher = new UrlMatcher($routes, $context);
    // Find the current route
    $parameters = $matcher->match($context->getPathInfo());
/*
    // How to generate a SEO URL
    $generator = new UrlGenerator($routes, $context);
    $url = $generator->generate('home');
    var_dump($generator);
*/
    $params = explode('::', $parameters['_controller']);
    
    var_dump($params);

    if ($params[0] !== null) {

    $controller = $params[0];
    $action = $params[1];
    $controller = new $controller();

        if (method_exists($controller, $action)) {
           // $response = new Response();
           call_user_func_array([$controller,$action], $params);

        } else {
            // On envoie le code réponse 404
            http_response_code(404);
            $error = "La page recherchée n'existe pas";
            $controller = new HomeController();
            $controller->errorPage($error);
        }

    } else {
        // Ici aucun paramètre n'est défini
        // On instancie le contrôleur
        $controller = new HomeController();

        // On appelle la méthode index
        $controller->homePage();
    }
}
catch (Exception $error) { // S'il y a eu une erreur, alors...
  
    $controller = new HomeController();
    $controller->errorPage($error);
}
