<?php

namespace App\Repository;

use App\Factory\ProfileFactory;
use App\Repository\ProfileInterface;
use App\Entity\Profile;

final class ProfileRepository extends AbstractRepository implements ProfileInterface
{

    public function find(int $id): object
    {
        $getProfile = $this->pdo->prepare('SELECT *
        FROM profile WHERE id = ?');
        $getProfile->execute(array($id));

        return ProfileFactory::FromDbCollection($getProfile->fetch());
    }

    public function findbyName(Profile $profile): array
    {
        $getProfiles = $this->pdo->prepare('SELECT *
        FROM profile WHERE name = ?');
        $getProfiles->execute(array($profile->getName()));
        $dataProfile = $getProfiles->fetchAll();

        return ProfileFactory::arrayFromDbCollection($dataProfile);
    }

    public function findAll(): array
    {
        $getProfiles = $this->pdo->prepare('SELECT *
        FROM profile');
        $getProfiles->execute();
        $dataProfile = $getProfiles->fetchAll();

        return ProfileFactory::arrayFromDbCollection($dataProfile);
    }

    public function add(Profile $profile): bool
    {
        $addProfile = $this->pdo->prepare('INSERT INTO 
        profile (name) VALUES(?)');
        
        return $addProfile->execute(array($profile->getName()));
    }

    public function update(Profile $profile): bool
    {
        $updateProfile = $this->pdo->prepare('UPDATE profile SET name = :name WHERE id = :id');

        return $updateProfile->execute(array(
            'name' => $profile->getName(),
            'id' => $profile->getId()
        ));
    }

    public function delete(int $id): bool
    {
        $deleteProfile = $this->pdo->prepare('DELETE FROM profile WHERE id = :id');

        return $deleteProfile->execute(array('id' => $id));
    }
}
