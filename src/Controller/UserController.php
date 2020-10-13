<?php

namespace App\Controller;

use App\Model\User;
use App\Model\UserModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

final class UserController extends ManagerController
{
    private object $user;
    private object $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function logUser(): void
    {
        $request = Request::createFromGlobals();
        $this->user = new User($request->get('login'));
        $userLogin = $this->user->getUserLogin();

        $getUserDb = $this->userModel->getUserDb($userLogin);

        $checkUser = $this->user->checkLogUser($request->get('pass'), $getUserDb);

        if ($checkUser) {
            $getUserDb = $this->user->getUser();
            $this->userModel->updateUserDateLog($getUserDb);
            $this->sessionStart($getUserDb);
        }
    }

    public function addNewUser(): void
    {
        $request = Request::createFromGlobals();
        $this->user = new User($request->get('login'));
        $newUser = $this->user->checkNewUser($request);
        $checkUser = $this->userModel->createNewUser($newUser);
        $getUserDb = $this->userModel->getUserDb($newUser['login']);

        $this->user->setUserId($getUserDb['id']);

        if ($checkUser) {
        $getUserDb = $this->user->getUser();
        $this->sessionStart($getUserDb);
        }
    }

    public function sessionStart($user): void
    {
        $session = new Session();
        $session->set('userId', $user['id']);
        $session->set('login', $user['login']);
        $session->set('lastLoginAt', $user['lastLoginAt']);

        $_SESSION['userId'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['lastLoginAt'] = $user['lastLoginAt'];
       
        $response = new RedirectResponse('http://localhost/TP11_online_advisor_phppoo/item/listItemPage');
        $response->send();
        //header('Location: http://localhost/TP11_online_advisor_phppoo/item/listItemPage');

    }

    public function sessionDestroy(): void
    {
        $session = new Session();
        $session->invalidate();
        $response = new RedirectResponse('http://localhost/TP11_online_advisor_phppoo');
        $response->send();
        //header('Location: http://localhost/TP11_online_advisor_phppoo');
    }
}
