<?php

namespace App\Model;

final class ProfileModel
{
    private object $dataBase;

    public function __construct()
    {
        $pdo = new ConnectModel();
        $this->dataBase = $pdo->dbConnect();
    }

    public function get(int $id): array
    {
        $getProfile = $this->dataBase->prepare('SELECT *
        FROM profile WHERE id = ?');
        $getProfile->execute(array($id));

        return $getProfile->fetchAll();
    }

    public function getAll(): array
    {
        $getProfiles = $this->dataBase->prepare('SELECT *
        FROM profile');
        $getProfiles->execute();

        return $getProfiles->fetchAll();
    }

    public function add(Profile $profile): array
    {
        $addProfile = $this->dataBase->prepare('INSERT INTO 
        profile (name) VALUES(?)');
        
        return $addProfile->execute(array($profile->getName()));
    }

    public function update(Profile $profile): array
    {
        $updateProfile = $this->dataBase->prepare('UPDATE profile SET name = :name WHERE id = :id');

        return $updateProfile->execute(array(
            'name' => $profile->getName(),
            'id' => $profile->getId()  
        ));
    }

    public function delete(int $id): array
    {
        $deleteProfile = $this->dataBase->prepare('DELETE FROM profile WHERE id = :id');

        return $deleteProfile->execute(array('id' => $id));
    }

}
