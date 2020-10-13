<?php

namespace App\Controller;

use App\Model\Comment;
use App\Model\CommentModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

final class CommentController
{
    private object $comment;
    private object $commentModel;
    private object $session;

    public function __construct()
    {
        $this->session = new Session();
        if ($this->session->get('userId') === null){
            $response = new RedirectResponse('http://localhost/TP11_online_advisor_phppoo');
            $response->send();
        }
        $this->commentModel = new CommentModel();
        $this->comment = new Comment();
    }

    public function addComment(): void
    {  
        $request = Request::createFromGlobals();
        $checkComment = $this->comment->checkNewComment($request, $this->session->all());

        $newComment = $this->commentModel->createNewComment($checkComment);

        $response = new RedirectResponse('http://localhost/TP11_online_advisor_phppoo/item/getComments/'.$_SESSION['itemId']);
        $response->send();
    }
}
