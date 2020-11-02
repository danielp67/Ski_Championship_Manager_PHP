<?php

namespace App\Controller;

use App\Container\FactoryContainer;
use App\Factory\CategoryFactory;
use App\Repository\CategoryRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController extends AbstractController
{
    public function categoryPage(Request $request, Response $response): Response
    {
        $categoryRepository = new CategoryRepository($this->pdo);
        $allCategory = $categoryRepository->findAll();
        $content =  $this->twig->render('categoryView.html.twig', ['categories' => $allCategory]);
        $response->setContent($content);

        return $response;
    }

    public function categoryAdd(Request $request): Response
    {
        $categoryRepository = new CategoryRepository($this->pdo);
        $newCategory = CategoryFactory::fromRequestAdd($request);
        $checkCategory = $categoryRepository->findbyName($newCategory);
        if (! empty($checkCategory)) {
        }
        $addCategory = $categoryRepository->add($newCategory);
        $serverHost = $request->server->get('HTTP_HOST');

        return new RedirectResponse('http://' . $serverHost . '/category');
    }

    public function categoryUpdate(Request $request): Response
    {
        $categoryRepository = new CategoryRepository($this->pdo);

        $updateCategory = CategoryFactory::fromRequestUdpate($request);
        $checkCategory = $categoryRepository->findbyName($updateCategory);
        if (! empty($checkCategory)) {
            throw new Exception('Nom déjà existant');
        }
        $addCategory = $categoryRepository->update($updateCategory);
        $serverHost = $request->server->get('HTTP_HOST');
        
        return new RedirectResponse('http://' . $serverHost . '/category');
    }

    public function categoryDelete(Request $request): Response
    {
        $categoryRepository = new CategoryRepository($this->pdo);
        $deleteCategory = $categoryRepository->delete($request->get('nameId'));
        $serverHost = $request->server->get('HTTP_HOST');
        
        return new RedirectResponse('http://' . $serverHost . '/category');
    }
}
