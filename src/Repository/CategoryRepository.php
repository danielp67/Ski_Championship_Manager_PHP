<?php

namespace App\Repository;

use App\Entity\Category;
use App\Factory\CategoryFactory;
use App\Repository\CategoryInterface;

final class CategoryRepository extends AbstractRepository implements CategoryInterface
{
    public function find(int $id): object
    {
        $getCategory = $this->pdo->prepare('SELECT *
        FROM category WHERE id = ?');
        $getCategory->execute(array($id));

        return CategoryFactory::FromDbCollection($getCategory->fetch());
    }

    public function findbyName(Category $category): array
    {
        $getAllCategories = $this->pdo->prepare('SELECT *
        FROM category WHERE name = ?');
        $getAllCategories->execute(array($category->getName()));
        $dataCategories = $getAllCategories->fetchAll();
        return CategoryFactory::arrayFromDbCollection($dataCategories);
    }

    public function findAll(): array
    {
        $getAllCategories = $this->pdo->prepare('SELECT *
        FROM category');
        $getAllCategories->execute();
        $dataCategories = $getAllCategories->fetchAll();
        return CategoryFactory::arrayFromDbCollection($dataCategories);
    }

    public function add(Category $category): bool
    {
        $addCategory = $this->pdo->prepare('INSERT INTO 
        category (name) VALUES(?)');

        return $addCategory->execute(array($category->getName()));
    }

    public function update(Category $category): bool
    {
        $updateCategory = $this->pdo->prepare('UPDATE category SET name = :name WHERE id = :id');

        return $updateCategory->execute(array(
            'name' => $category->getName(),
            'id' => $category->getId()
        ));
    }

    public function delete(int $id): bool
    {
        $deleteCategory = $this->pdo->prepare('DELETE FROM category WHERE id = :id');

        return $deleteCategory->execute(array('id' => $id));
    }
}
