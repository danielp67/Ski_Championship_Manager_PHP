<?php

namespace App\Model;

final class CategoryDb
{
    private object $dataBase;

    public function __construct()
    {
        $pdo = new ConnectDb();
        $this->dataBase = $pdo->dbConnect();
    }

    public function get(int $id): array
    {
        $getCategory = $this->dataBase->prepare('SELECT *
        FROM category WHERE id = ?');
        $getCategory->execute(array($id));

        return $getCategory->fetchAll();
    }

    public function getAll(): array
    {
        $getAllCategories = $this->dataBase->prepare('SELECT *
        FROM category');
        $getAllCategories->execute();

        return $getAllCategories->fetchAll();
    }

    public function add(Category $category): array
    {
        $addCategory = $this->dataBase->prepare('INSERT INTO 
        category (name) VALUES(?)');
        
        return $addCategory->execute(array($category->getName()));
    }

    public function update(Category $category): array
    {
        $updateCategory = $this->dataBase->prepare('UPDATE category SET name = :name WHERE id = :id');

        return $updateCategory->execute(array(
            'name' => $category->getName(),
            'id' => $category->getId()  
        ));
    }

    public function delete(Category $category): array
    {
        $deleteCategory = $this->dataBase->prepare('DELETE FROM category WHERE id = :id');

        return $deleteCategory->execute(array('id' => $category->getId()));
    }

}
