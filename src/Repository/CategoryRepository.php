<?php

namespace App\Repository;

use App\Model\Category;
use App\Model\ConnectModel;

final class CategoryRepository implements CategoryInterface
{
    private object $dataBase;

    public function __construct()
    {
        $pdo = new ConnectModel();
        $this->dataBase = $pdo->dbConnect();
    }

    public function find(int $id): array
    {
        $getCategory = $this->dataBase->prepare('SELECT *
        FROM category WHERE id = ?');
        $getCategory->execute(array($id));

        return $getCategory->fetchAll();
    }

    public function findbyName(Category $category): array
    {
        $getCategory = $this->dataBase->prepare('SELECT *
        FROM category WHERE name = ?');
        $getCategory->execute(array($category->getName()));

        return $getCategory->fetchAll();
    }

    public function findAll(): array
    {
        $getAllCategories = $this->dataBase->prepare('SELECT *
        FROM category');
        $getAllCategories->execute();

        return $getAllCategories->fetchAll();
    }

    public function add(Category $category): bool
    {
        $addCategory = $this->dataBase->prepare('INSERT INTO 
        category (name) VALUES(?)');
        
        return $addCategory->execute(array($category->getName()));
    }

    public function update(Category $category): bool
    {
        $updateCategory = $this->dataBase->prepare('UPDATE category SET name = :name WHERE id = :id');

        return $updateCategory->execute(array(
            'name' => $category->getName(),
            'id' => $category->getId()  
        ));
    }

    public function delete(int $id): bool
    {
        $deleteCategory = $this->dataBase->prepare('DELETE FROM category WHERE id = :id');

        return $deleteCategory->execute(array('id' => $id));
    }

}
