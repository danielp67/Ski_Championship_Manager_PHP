<?php

use App\Controller\HomeController;
use App\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

require __DIR__.'/vendor/autoload.php';


echo date('Y-m-d H:i:s');
$params = explode('/', $_GET['url']);
var_dump($params);
/*
$request = new Request();
$request2 = Request::createFromGlobals();

var_dump($request);
var_dump($request2);
*/

    $router = new Router($_GET['url']);


    $router->get('home/loginPage', 'Home.loginPage');
    $router->get('home/newUserPage', 'Home.newUserPage');
    $router->get('/', 'Home.loginPage');


    $router->get('race', 'Race.racePage');

    $router->get('participant', 'Participant.participantPage');

    $router->post('user/addNewUser', 'User.addNewUser');

    $router->get('item/listItemPage', 'Item.listItemPage');
    $router->post('item/addNewItem', 'Item.addNewItem');


    $router->get('item/getComments/:id', 'Item.getComments');
    $router->post('comment/addComment/:id', 'Comment.addComment');


    $router->get('user/sessionDestroy', 'User.sessionDestroy');

    $router->get('home/errorPage', 'Home.errorPage');


try {
    $router->run();

}
catch (Exception $error) { 

        $controller = new HomeController();
        $controller->errorPage($error);
}

