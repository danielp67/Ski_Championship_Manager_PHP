<?php

namespace App\Repository;

use App\Entity\Result;
use App\Factory\ParticipantFactory;
use App\Factory\ResultFactory;

final class ResultRepository extends AbstractRepository implements ResultInterface
{

    public function find(int $id): object
    {
        $getResult = $this->pdo->prepare('SELECT *
        FROM result WHERE id = ? ');
        $getResult->execute(array($id));
        
        return ResultFactory::FromDbCollection($getResult->fetch());
    }

    public function findParticipantByRace(int $raceId): array
    {
        $getResults = $this->pdo->prepare('SELECT *
        FROM result r
        INNER JOIN participant p
        WHERE r.race_id = ? AND r.participant_id = p.id ORDER BY p.last_name');
        $getResults->execute(array($raceId));
        
        $dataResults = $getResults->fetchAll();
       // var_dump($dataResults);
        return ParticipantFactory::arrayFromDbCollection($dataResults);
    }

    public function findParticipantByNotRace(int $raceId): array
    {
        $getResults = $this->pdo->prepare('SELECT *
        FROM participant
        WHERE id NOT IN 
        (select participant_id from result where race_id =  ?)');
        $getResults->execute(array($raceId));
        
        $dataResults = $getResults->fetchAll();

        return ParticipantFactory::arrayFromDbCollection($dataResults);
    }

    public function findByName(Result $result): array
    {
        $getResults = $this->pdo->prepare('SELECT *
        FROM  result WHERE race_id = ? AND participant_id = ?');
        $getResults->execute(array(
            $result->getRaceId(),
            $result->getParticipantId()
        ));

        $dataResults = $getResults->fetchAll();

        return ResultFactory::arrayFromDbCollection($dataResults);
    }

    public function findAllParticipantsByRaceId(int $raceId): array
    {
        $getResults = $this->pdo->prepare('SELECT *
        FROM  result WHERE race_id = ?');
        $getResults->execute(array($raceId));

        $dataResults = $getResults->fetchAll();

        return ResultFactory::arrayFromDbCollection($dataResults);
    }

    public function findResultsByRaceId(int $raceId): array
    {
        $getResults = $this->pdo->prepare('SELECT *
        FROM  result r
        INNER JOIN participant p ON r.participant_id = p.id
        INNER JOIN profile pr ON p.profile_id = pr.id
        INNER JOIN category c ON p.category_id = c.id
        WHERE r.race_id = ? ORDER BY r.average_time');
        $getResults->execute(array($raceId));

        $dataResults = $getResults->fetchAll();
       // var_dump($dataResults);
      //  $results = ResultFactory::arrayFromDbCollectionWithParticipant($dataResults);
       // $participants = ParticipantFactory::arrayFromDbCollection($dataResults);

        return $dataResults;
    }

    public function findStageByRaceId(int $raceId): array
    {
        $getResults = $this->pdo->prepare('SELECT *
        FROM  result r
        INNER JOIN stage s ON s.result_id = r.id
        WHERE r.result_id = ?');
        $getResults->execute(array($raceId));

        $dataResults = $getResults->fetchAll();
       // var_dump($dataResults);
      //  $results = ResultFactory::arrayFromDbCollectionWithParticipant($dataResults);
       // $participants = ParticipantFactory::arrayFromDbCollection($dataResults);

        return $dataResults;
    }

    public function findResultsByRaceIdAndCategory(int $raceId, int $categoryId)
    {
        $getResults = $this->pdo->prepare('SELECT *
        FROM  result r
        INNER JOIN participant p ON r.participant_id = p.id
        INNER JOIN profile pr ON p.profile_id = pr.id
        INNER JOIN category c ON p.category_id = c.id
        WHERE r.race_id = :raceId AND p.category_id = :categoryId 
        ORDER BY r.average_time LIMIT 0, 3');
        $getResults->execute(array(  
           "raceId" => $raceId,
           "categoryId" => $categoryId));

        $dataResults = $getResults->fetchAll();
        //var_dump($dataResults);
       // return ResultFactory::arrayFromDbCollection($dataResults);
       return $dataResults;
    }

    public function findAll(): array
    {
        $getResults = $this->pdo->prepare('SELECT *
        FROM result');
        $getResults->execute();

        $dataResults = $getResults->fetchAll();

        return ResultFactory::arrayFromDbCollection($dataResults);
    }

    public function add(Result $result): bool
    {
        $addResult = $this->pdo->prepare('INSERT INTO 
        result (race_id, participant_id, average_time) VALUES(?, ?, ?)');
        
        return $addResult->execute(array(
            $result->getRaceId(),
            $result->getParticipantId(),
            $result->getAverageTime()->format('i:s.u')
            ));
    }

    public function update(Result $result): bool
    {
        $updateResult = $this->pdo->prepare('UPDATE result 
        SET race_id = :race_id, 
        participant_id = :participant_id, 
        average_time = :average_time 
        WHERE id = :id');

        return $updateResult->execute(array(
            'race_id' => $result->getRaceId(),
            'participant_id' =>  $result->getParticipantId(),
            'average_time' =>  $result->getAverageTime()->format('i:s.u'),
            'id' => $result->getId()
        ));
    }

    public function delete(int $id): bool
    {
        $deleteResult = $this->pdo->prepare('DELETE FROM result WHERE id = :id');

        return $deleteResult->execute(array('id' => $id));
    }
}
