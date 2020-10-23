<?php

namespace App\Controller;

use App\Factory\CategoryFactory;
use App\Repository\CategoryRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class CategoryController extends AbstractController
{

    public function categoryPage(): void
    {
        $categoryRepository = new CategoryRepository();
        $allCategory = $categoryRepository->findAll();
        echo $this->twig->render('categoryView.html.twig', ['categories' => $allCategory]);
    }

    public function categoryAdd($request): void
    {
        $categoryRepository = new CategoryRepository();
        $newCategory = CategoryFactory::fromRequestAdd($request);
        $checkCategory = $categoryRepository->findbyName($newCategory);
        if (! empty($checkCategory)) {
            
        }
        $addCategory = $categoryRepository->add($newCategory);
        $response = new RedirectResponse('http://127.1.2.3/category');
        $response->send();
    }

    public function categoryUpdate($request): void
    {
        $categoryRepository = new CategoryRepository();

        $updateCategory = CategoryFactory::fromRequestUdpate($request);
        $checkCategory = $categoryRepository->findbyName($updateCategory);
        if (! empty($checkCategory)) {
            throw new Exception('Nom déjà existant');
        }
        $addCategory = $categoryRepository->update($updateCategory);
        $response = new RedirectResponse('http://127.1.2.3/category');
        $response->send();
    }

    public function categoryDelete($request): void
    {
        $categoryRepository = new CategoryRepository();

        $deleteCategory = $categoryRepository->delete($request->get('nameId'));
        $response = new RedirectResponse('http://127.1.2.3/category');
        $response->send();
    }
}
