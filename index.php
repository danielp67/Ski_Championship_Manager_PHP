<?php

use App\Controller\HomeController;
use App\Kernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



require __DIR__.'/vendor/autoload.php';


try
{  
    $request =  Request::createFromGlobals();
    $kernel = new Kernel();
    $params = $kernel->handleRequest($request);
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
    }
}
catch (Exception $error) { // S'il y a eu une erreur, alors...
    messageError($error);
    
}finally{

    $request =  Request::createFromGlobals();
    $response = new Response();
        // Ici aucun paramètre n'est défini
        // On instancie le contrôleur
        $controller = new HomeController();
        // On appelle la méthode index
        $controller->homePage($request, $response);

}


function messageError(string $error): void
{
    $response = new Response();
    $response->setStatusCode(Response::HTTP_NOT_FOUND);
    $controller = new HomeController();
    $controller->errorPage($error);
}
