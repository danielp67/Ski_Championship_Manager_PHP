<?php

use App\Controller\HomeController;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

require __DIR__.'/vendor/autoload.php';

// looks inside *this* directory
$fileLocator = new FileLocator([__DIR__.'/config/']);
$loader = new YamlFileLoader($fileLocator);
$routes = $loader->load('routes.yaml');





$route = new Route('/home', ['_controller' => HomeController::class]);
$routes = new RouteCollection();
$routes->add('home', $route);

$context = new RequestContext('/');

// Routing can match routes with incoming requests
$matcher = new UrlMatcher($routes, $context);
$parameters = $matcher->match('/home');
// $parameters = [
//     '_controller' => 'App\Controller\BlogController',
//     'slug' => 'lorem-ipsum',
//     '_route' => 'blog_show'
// ]

// Routing can also generate URLs for a given route
$generator = new UrlGenerator($routes, $context);
$url = $generator->generate('home', [
    'slug' => 'test',
]);
// $url = '/blog/my-blog-post'






echo date('Y-m-d H:i:s');
/*
$request = new Request();
$request2 = Request::createFromGlobals();

var_dump($request);
var_dump($request2);
*/
/*
    $router = new Router($_GET['url']);


    $router->get('home/loginPage', 'Home.loginPage');
    $router->get('home/newUserPage', 'Home.newUserPage');
    $router->get('/', 'Home.loginPage');


try {
    $router->run();

}
catch (Exception $error) { 

        $controller = new HomeController();
        $controller->errorPage($error);
}

*/