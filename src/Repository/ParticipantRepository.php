<?php

namespace App\Repository;

use App\Entity\Participant;
use App\Factory\ParticipantFactory;

final class ParticipantRepository extends AbstractRepository implements ParticipantInterface
{

    public function find(int $id): object
    {
        $getParticipant = $this->pdo->prepare('SELECT *
        FROM participant WHERE id = ?');
        $getParticipant->execute(array($id));
        return ParticipantFactory::fromDbCollection($getParticipant->fetch());
    }

    public function findByName(Participant $participant): array
    {
        $getAllParticipants = $this->pdo->prepare('SELECT *
        FROM participant WHERE last_name = "" AND first_name = "" AND birth_date = "" ');
        $getAllParticipants->execute();
        $dataParticipants = $getAllParticipants->fetchAll();

        return ParticipantFactory::arrayFromDbCollection($dataParticipants);
    }

    public function findAll(): array
    {
        $getAllParticipants = $this->pdo->prepare('SELECT *
        FROM participant ORDER BY last_name ');
        $getAllParticipants->execute();
        $dataParticipants = $getAllParticipants->fetchAll();

        return ParticipantFactory::arrayFromDbCollection($dataParticipants);
    }

    public function add(Participant $participant): array
    {
        $addParticipant = $this->pdo->prepare('INSERT INTO 
        participant (last_name, first_name, mail, birth_date, img_link, categories_id, profils_id) 
        VALUES(?, ?, ?, ?, ?, ?, ?)');
        
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
        $updateParticipant = $this->pdo->prepare('UPDATE participant 
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
        $deleteParticipant = $this->pdo->prepare('DELETE FROM participant WHERE id = :id');

        return $deleteParticipant->execute(array('id' => $id));
    }
}
