<?php

namespace App\Controller;

use App\Model\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class CategoryController
{
    private CategoryRepository $categoryRepository;
    public object $loader;
    public object $twig;


    public function __construct()
    {
        $this->loader = new FilesystemLoader('src/View');
        $this->twig = new Environment($this->loader, []);
        $this->categoryRepository = new CategoryRepository();
    }


    public function categoryPage(): void
    {
        $allCategory = $this->categoryRepository->findAll();
        echo $this->twig->render('categoryView.html.twig', ['categories' => $allCategory]);
    }

    public function categoryAdd(): void
    {
        $request = Request::createFromGlobals();
        $name = $request->get('name');
        $newCategory = new Category();
        $newCategory->setName($name);
        $checkCategory = $this->categoryRepository->findbyName($newCategory);
        if (empty($checkCategory)) {
            $addCategory = $this->categoryRepository->add($newCategory);
        }
        $response = new RedirectResponse('http://127.1.2.3/category');
        $response->send();
    }

    public function categoryCheck(): void
    {
        $request = Request::createFromGlobals();
        var_dump($request->request);
        var_dump($request->files);

        echo $this->twig->render('categoryView.html.twig');
    }

    public function categoryUpdate(): void
    {
        $request = Request::createFromGlobals();
        $updateCategory = new Category();
        $updateCategory->setName($request->get('name'));
        $updateCategory->setId($request->get('nameId'));
        $checkCategory = $this->categoryRepository->findbyName($updateCategory);
        if (empty($checkCategory)) {
            $addCategory = $this->categoryRepository->update($updateCategory);
        }
        $response = new RedirectResponse('http://127.1.2.3/category');
        $response->send();
    }

    public function categoryDelete(): void
    {
        $request = Request::createFromGlobals();
        $id = (int) $request->get('nameId');
        $deleteCategory = $this->categoryRepository->delete($id);
        $response = new RedirectResponse('http://127.1.2.3/category');
        $response->send();
    }
}
