<?php

namespace App\Model;

final class ParticipantDb
{
    private object $dataBase;

    public function __construct()
    {
        $pdo = new ConnectDb();
        $this->dataBase = $pdo->dbConnect();
    }

    public function get(int $id): array
    {
        $getParticipant = $this->dataBase->prepare('SELECT *
        FROM participant WHERE id = ?');
        $getParticipant->execute(array($id));

        return $getParticipant->fetchAll();
    }

    public function getAll(): array
    {
        $getAllParticipants = $this->dataBase->prepare('SELECT *
        FROM participant');
        $getAllParticipants->execute();

        return $getAllParticipants->fetchAll();
    }

    public function add(Participant $participant): array
    {
        $addParticipant = $this->dataBase->prepare('INSERT INTO 
        participant (last_name, first_name, mail, birth_date, img_link, categories_id, profils_id) VALUES(?, ?, ?, ?, ?, ?, ?)');
        
        return $addParticipant->execute(array(
            $participant->getLastName(), 
            $participant->getFirstName(),
            $participant->getMail(),
            $participant->getBirthDate(),
            $participant->getImgLink(),
            $participant->getCategoryId(),
            $participant->getProfileId(),
        ));
    }

    public function update(Participant $participant): array
    {
        $updateParticipant = $this->dataBase->prepare('UPDATE participant 
        SET last_name = :last_name,
            first_name = :first_name,
            mail = :mail,
            birth_date = :birth_date,
            img_link = :img_link,
            categories_id = :categories_id,
            profils_id = :profils_id
         WHERE id = :id');

        return $updateParticipant->execute(array(
            'last_name' => $participant->getLastName(), 
            'first_name' => $participant->getFirstName(),
            'mail' => $participant->getMail(),
            'birth_date' =>  $participant->getBirthDate(),
            'img_link' =>  $participant->getImgLink(),
            'category_id' =>  $participant->getCategoryId(),
            'profile_id' =>  $participant->getProfileId(),
            'id' => $participant->getId()  
        ));
    }

    public function delete(int $id): array
    {
        $deleteParticipant = $this->dataBase->prepare('DELETE FROM participant WHERE id = :id');

        return $deleteParticipant->execute(array('id' => $id));
    }

}
