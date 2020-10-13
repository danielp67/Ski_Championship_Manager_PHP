<?php

namespace App\Model;

final class CategoriesModel
{
    private object $dataBase;

    public function __construct()
    {
        $pdo = new ConnectModel();
        $this->dataBase = $pdo->dbConnect();
    }

    public function getCategorie(int $id): array
    {
        $getCategorie = $this->dataBase->prepare('SELECT *
        FROM categories WHERE id = ?');
        $getCategorie->execute(array($id));

        return $getCategorie->fetchAll();
    }

    public function getAllCategories(): array
    {
        $getAllCategories = $this->dataBase->prepare('SELECT *
        FROM categories');
        $getAllCategories->execute();

        return $getAllCategories->fetchAll();
    }

    public function addCategorie(Categories $categorie): array
    {
        $addCategorie = $this->dataBase->prepare('INSERT INTO 
        categories (name) VALUES(?)');
        
        return $addCategorie->execute(array($categorie->getName()));
    }

    public function updateCategorie(Categories $categorie): array
    {
        $updateCategorie = $this->dataBase->prepare('UPDATE categories SET name = :name WHERE id = :id');

        return $updateCategorie->execute(array(
            'name' => $categorie->getName(),
            'id' => $categorie->getId()  
        ));
    }

    public function deleteCategorie(Categories $categorie): array
    {
        $deleteCategorie = $this->dataBase->prepare('DELETE FROM categories WHERE id = :id');

        return $deleteCategorie->execute(array('id' => $categorie->getId()));
    }

}
