<?php

namespace App\Repository;

use App\Entity\Participant;
use App\Factory\ParticipantFactory;

final class ParticipantRepository extends AbstractRepository implements ParticipantInterface
{

    public function find(int $id): array
    {
        $getParticipant = $this->pdo->prepare('SELECT 
        p.id, p.last_name, p.first_name, p.mail, p.birth_date, p.img_link, 
        p.category_id, c.name as category, p.profile_id, pr.name as profile
        FROM participant p
        INNER JOIN category c ON p.category_id = c.id
        INNER JOIN profile pr ON p.profile_id = pr.id
        WHERE p.id = ?');

        $getParticipant->execute(array($id));

        return ParticipantFactory::fromDbCollection($getParticipant->fetch());
    }

    public function findByName(Participant $participant): array
    {
        $getAllParticipants = $this->pdo->prepare('SELECT 
        p.id, p.last_name, p.first_name, p.mail, p.birth_date, p.img_link, 
        p.category_id, c.name as category, p.profile_id, pr.name as profile
        FROM participant p
        INNER JOIN category c ON p.category_id = c.id
        INNER JOIN profile pr ON p.profile_id = pr.id
        WHERE p.last_name = ? AND p.first_name = ? AND p.birth_date = ? AND p.id <> ?');
        $getAllParticipants->execute(array(
                $participant->getLastName(),
                $participant->getFirstName(),
                $participant->getBirthDate()->format('Y-m-d'),
                $participant->getId()
            ));
        $dataParticipants = $getAllParticipants->fetchAll();

        return ParticipantFactory::arrayFromDbCollection($dataParticipants);
    }

    public function findAll(): array
    {
        $getAllParticipants = $this->pdo->prepare('SELECT
        p.id, p.last_name, p.first_name, p.mail, p.birth_date, p.img_link, 
        p.category_id, c.name as category, p.profile_id, pr.name as profile
        FROM participant p
        INNER JOIN category c ON p.category_id = c.id
        INNER JOIN profile pr ON p.profile_id = pr.id
        ORDER BY p.last_name');
        $getAllParticipants->execute();
        $dataParticipants = $getAllParticipants->fetchAll();

        return ParticipantFactory::arrayFromDbCollection($dataParticipants);
    }

    public function add(Participant $participant): bool
    {
        $addParticipant = $this->pdo->prepare('INSERT INTO 
        participant (last_name, first_name, mail, birth_date, img_link, category_id, profile_id) 
        VALUES(?, ?, ?, ?, ?, ?, ?)');
        
        return $addParticipant->execute(array(
            $participant->getLastName(),
            $participant->getFirstName(),
            $participant->getMail(),
            $participant->getBirthDate()->format('Y-m-d'),
            $participant->getImgLink(),
            $participant->getCategoryId(),
            $participant->getProfileId(),
        ));
    }

    public function update(Participant $participant): bool
    {
        $updateParticipant = $this->pdo->prepare('UPDATE participant 
        SET last_name = :last_name,
            first_name = :first_name,
            mail = :mail,
            birth_date = :birth_date,
            img_link = :img_link,
            category_id = :category_id,
            profile_id = :profile_id
         WHERE id = :id');

        return $updateParticipant->execute(array(
            'last_name' => $participant->getLastName(),
            'first_name' => $participant->getFirstName(),
            'mail' => $participant->getMail(),
            'birth_date' =>  $participant->getBirthDate()->format('Y-m-d'),
            'img_link' =>  $participant->getImgLink(),
            'category_id' =>  $participant->getCategoryId(),
            'profile_id' =>  $participant->getProfileId(),
            'id' => $participant->getId()
        ));
    }

    public function delete(int $id): bool
    {
        $deleteParticipant = $this->pdo->prepare('DELETE FROM participant WHERE id = :id');

        return $deleteParticipant->execute(array('id' => $id));
    }
}
