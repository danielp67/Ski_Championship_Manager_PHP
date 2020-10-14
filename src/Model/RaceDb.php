<?php

namespace App\Model;

final class RaceDb
{
    private object $dataBase;

    public function __construct()
    {
        $pdo = new ConnectDb();
        $this->dataBase = $pdo->dbConnect();
    }

    public function get(int $id): array
    {
        $getRace = $this->dataBase->prepare('SELECT *
        FROM race WHERE id = ?');
        $getRace->execute(array($id));

        return $getRace->fetchAll();
    }

    public function getAll(): array
    {
        $getRaces = $this->dataBase->prepare('SELECT *
        FROM race');
        $getRaces->execute();

        return $getRaces->fetchAll();
    }

    public function add(Race $race): array
    {
        $addRace = $this->dataBase->prepare('INSERT INTO 
        race (location, date) VALUES(?)');
        
        return $addRace->execute(array(
            $race->getLocation(), 
            $race->getDate()
            ));
    }

    public function update(Race $race): array
    {
        $updateRace = $this->dataBase->prepare('UPDATE race SET location = :location, date = :date WHERE id = :id');

        return $updateRace->execute(array(
            'location' => $race->getLocation(),
            'date' => $race->getDate(),
            'id' => $race->getId()  
        ));
    }

    public function delete(int $id): array
    {
        $deleteRace = $this->dataBase->prepare('DELETE FROM race WHERE id = :id');

        return $deleteRace->execute(array('id' => $id));
    }

}
