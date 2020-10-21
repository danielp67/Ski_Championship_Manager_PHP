<?php

namespace App\Repository;

use App\Model\ConnectModel;
use App\Model\Race;

final class RaceRepository implements RaceInterface
{
    private object $dataBase;

    public function __construct()
    {
        $pdo = new ConnectModel();
        $this->dataBase = $pdo->dbConnect();
    }

    public function find(int $id): array
    {
        $getRace = $this->dataBase->prepare('SELECT *
        FROM race WHERE id = ?');
        $getRace->execute(array($id));

        return $getRace->fetchAll();
    }

    public function findByName(Race $race): array
    {
        $getRace = $this->dataBase->prepare('SELECT *
        FROM  race WHERE location = ? AND date = ?');
        $getRace->execute(array(
            $race->getLocation(), 
            $race->getDate()
        ));

        return $getRace->fetchAll();
    }

    public function findAll(): array
    {
        $getRaces = $this->dataBase->prepare('SELECT *
        FROM race');
        $getRaces->execute();

        return $getRaces->fetchAll();
    }

    public function add(Race $race): bool
    {
        $addRace = $this->dataBase->prepare('INSERT INTO 
        race (location, date, status) VALUES(?, ?, ?)');
        
        return $addRace->execute(array(
            $race->getLocation(), 
            $race->getDate()->format('Y-m-d'),
            $race->getStatus()
            ));
    }

    public function update(Race $race): bool
    {
        $updateRace = $this->dataBase->prepare('UPDATE race SET location = :location, date = :date, status = :status WHERE id = :id');

        return $updateRace->execute(array(
            'location' => $race->getLocation(),
            'date' => $race->getDate()->format('Y-m-d'),
            'status' => $race->getStatus(),
            'id' => $race->getId()  
        ));
    }

    public function delete(int $id): bool
    {
        $deleteRace = $this->dataBase->prepare('DELETE FROM race WHERE id = :id');

        return $deleteRace->execute(array('id' => $id));
    }

}
