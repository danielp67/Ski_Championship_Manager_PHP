<?php

namespace App\Controller;

use App\Model\CommentModel;
use App\Model\Item;
use App\Model\ItemModel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class ItemController
{
    private object $item;
    private object $itemModel;
    private object $session;

    public function __construct()
    {
        $this->session = new Session();
        if ($this->session->get('userId') === null){
            $response = new RedirectResponse('http://localhost/TP11_online_advisor_phppoo');
            $response->send();
        }
        $this->itemModel = new ItemModel();    
        $this->loader = new FilesystemLoader('src/View');
        $this->twig = new Environment($this->loader, []);
    }

    public function listItemPage(): void
    {
        $listItems = $this->itemModel->getItemsDb();
        echo $this->twig->render('listItemsView.html.twig', ['session' => $this->session->all(), 'Items' => $listItems]);
    }

    public function getComments($itemId): void
    {  
       
        $commentModel = new CommentModel();
        $getComments = $commentModel->getComments($itemId);
        $_SESSION['itemId'] = (int) $itemId;
        $this->session->set('itemId', (int) $itemId);

        $getItem = $this->itemModel->getItemDb($itemId);
        
        echo $this->twig->render('ItemView.html.twig', ['session' => $this->session->all(), 'Item' => $getItem, 'Comments' => $getComments]);
    }

    public function addNewItem(): void
    {
        $request = Request::createFromGlobals();
        $this->item = new Item($request->get('itemName'));
        $checkItem = $this->item->checkNewItem($request, $this->session->all());
       
        $newItem = $this->itemModel->createNewItem($checkItem);

        $response = new RedirectResponse('http://localhost/TP11_online_advisor_phppoo/item/listItemPage');
        $response->send();
    }
}
