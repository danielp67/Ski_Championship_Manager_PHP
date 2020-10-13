<?php

namespace App\Model;

final class ParticipantsModel
{
    private object $dataBase;

    public function __construct()
    {
        $pdo = new ConnectModel();
        $this->dataBase = $pdo->dbConnect();
    }

    public function getParticipant(int $id): array
    {
        $getParticipant = $this->dataBase->prepare('SELECT *
        FROM participants WHERE id = ?');
        $getParticipant->execute(array($id));

        return $getParticipant->fetchAll();
    }

    public function getAllParticipants(): array
    {
        $getAllParticipants = $this->dataBase->prepare('SELECT *
        FROM participants');
        $getAllParticipants->execute();

        return $getAllParticipants->fetchAll();
    }

    public function addParticipant(Participants $participant): array
    {
        $addParticipant = $this->dataBase->prepare('INSERT INTO 
        participants (last_name, first_name, mail, birth_date, img_link, categories_id, profils_id) VALUES(?, ?, ?, ?, ?, ?, ?)');
        
        return $addParticipant->execute(array(
            $participant->getLastName(), 
            $participant->getFirstName(),
            $participant->getMail(),
            $participant->getBirthDate(),
            $participant->getImgLink(),
            $participant->getCategoriesId(),
            $participant->getProfilsId(),
        ));
    }

    public function updateParticipant(Participants $participant): array
    {
        $updateParticipant = $this->dataBase->prepare('UPDATE participants 
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
            'categories_id' =>  $participant->getCategoriesId(),
            'profils_id' =>  $participant->getProfilsId(),
            'id' => $participant->getId()  
        ));
    }

    public function deleteParticipant(Participants $participant): array
    {
        $deleteParticipant = $this->dataBase->prepare('DELETE FROM participants WHERE id = :id');

        return $deleteParticipant->execute(array('id' => $participant->getId()));
    }

}
