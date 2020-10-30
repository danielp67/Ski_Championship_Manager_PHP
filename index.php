<?php

use App\Controller\HomeController;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Loader\YamlFileLoader;


require __DIR__.'/vendor/autoload.php';


try
{
    // Load routes from the yaml file
    $fileLocator = new FileLocator(array(__DIR__.'/config'));
    $loader = new YamlFileLoader($fileLocator);
    $routes = $loader->load('routes.yaml');
    // Init RequestContext object
    $request =  Request::createFromGlobals();
    $context = new RequestContext();

    $context->fromRequest($request);

    // Init UrlMatcher object
    $matcher = new UrlMatcher($routes, $context);

    // Find the current route
    $parameters = $matcher->match($context->getPathInfo());
    
    $params = explode('::', $parameters['_controller']);
    $response = new Response();

    if ($params[0] !== null) {

    $controller = $params[0];
    $action = $params[1];
    $controller = new $controller();
    
        if (method_exists($controller, $action)) {
          
          $responseFromController = call_user_func_array([$controller,$action], [$request, $response]);
           if(! $responseFromController instanceof Response){
               throw new Exception('Not a Response instance');
           }
          $responseFromController->send();

        } else {
            $error = "La page recherchée n'existe pas";
            messageError($error);
        }

    } else {
        // Ici aucun paramètre n'est défini
        // On instancie le contrôleur
        $controller = new HomeController();
        // On appelle la méthode index
        $controller->homePage($request, $response);
    }
}
catch (Exception $error) { // S'il y a eu une erreur, alors...
    messageError($error);
    
}


function messageError($error){
            $response = new Response();
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            $controller = new HomeController();
            $controller->errorPage($error);
}


//$kernel = new Kernel();

//$kernel->handleRequest();

//init router

//init twig

//init ...