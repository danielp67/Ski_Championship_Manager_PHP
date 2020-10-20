<?php

namespace App\Repository;

use App\Repository\ProfileInterface;
use App\Model\ConnectModel;
use App\Model\Profile;

final class ProfileRepository implements ProfileInterface
{
    private object $dataBase;

    public function __construct()
    {
        $pdo = new ConnectModel();
        $this->dataBase = $pdo->dbConnect();
    }

    public function find(int $id): array
    {
        $getProfile = $this->dataBase->prepare('SELECT *
        FROM profile WHERE id = ?');
        $getProfile->execute(array($id));

        return $getProfile->fetchAll();
    }

    public function findbyName(Profile $profile): array
    {
        $getCategory = $this->dataBase->prepare('SELECT *
        FROM profile WHERE name = ?');
        $getCategory->execute(array($profile->getName()));

        return $getCategory->fetchAll();
    }

    public function findAll(): array
    {
        $getProfiles = $this->dataBase->prepare('SELECT *
        FROM profile');
        $getProfiles->execute();

        return $getProfiles->fetchAll();
    }

    public function add(Profile $profile): bool
    {
        $addProfile = $this->dataBase->prepare('INSERT INTO 
        profile (name) VALUES(?)');
        
        return $addProfile->execute(array($profile->getName()));
    }

    public function update(Profile $profile): bool
    {
        $updateProfile = $this->dataBase->prepare('UPDATE profile SET name = :name WHERE id = :id');

        return $updateProfile->execute(array(
            'name' => $profile->getName(),
            'id' => $profile->getId()  
        ));
    }

    public function delete(int $id): bool
    {
        $deleteProfile = $this->dataBase->prepare('DELETE FROM profile WHERE id = :id');

        return $deleteProfile->execute(array('id' => $id));
    }

}
