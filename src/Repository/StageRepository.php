<?php

namespace App\Repository;

use App\Entity\Stage;
use App\Factory\StageFactory;

final class StageRepository extends AbstractRepository implements StageInterface
{

    public function find(int $id): object
    {
        $getStage = $this->pdo->prepare('SELECT *
        FROM stage WHERE id = ? ');
        $getStage->execute(array($id));
        
        return StageFactory::FromDbCollection($getStage->fetch());
    }

    public function findByName(Stage $stage): array
    {
        $getStages = $this->pdo->prepare('SELECT *
        FROM  stage WHERE result_id = ? AND stage_nb = ?');
        $getStages->execute(array(
            $stage->getResultId(),
            $stage->getStageNb()
        ));

        $dataStages = $getStages->fetchAll();

        return StageFactory::arrayFromDbCollection($dataStages);
    }

    public function findByResultId(int $resultId): array
    {
        $getStages = $this->pdo->prepare('SELECT *
        FROM  stage WHERE result_id = ?');
        $getStages->execute(array($resultId));

        $dataStages = $getStages->fetchAll();
        var_dump($dataStages);
        return StageFactory::arrayFromDbCollection($dataStages);
    }

    public function findByResultIdAndStageNb(Stage $stage): array
    {
        $getStages = $this->pdo->prepare('SELECT *
        FROM  stage WHERE result_id = ? AND stage_nb = ?');
        $getStages->execute(array(
            $stage->getResultId(),
            $stage->getStageNb()
        ));

        $dataStages = $getStages->fetchAll();

        return StageFactory::arrayFromDbCollection($dataStages);
    }

    public function findAll(): array
    {
        $getStages = $this->pdo->prepare('SELECT *
        FROM stage ORDER BY date DESC');
        $getStages->execute();

        $dataStages = $getStages->fetchAll();

        return StageFactory::arrayFromDbCollection($dataStages);
    }

    public function add(Stage $stage): bool
    {
        $addStage = $this->pdo->prepare('INSERT INTO 
        stage (result_id, stage_nb, time) VALUES(?, ?, ?)');
        
        return $addStage->execute(array(
            $stage->getResultId(),
            $stage->getStageNb(),
            $stage->getTime()->format('i:s.u')
            ));
    }

    public function update(Stage $stage): bool
    {
        $updateStage = $this->pdo->prepare('UPDATE stage 
        SET result_id = :result_id, 
            stage_nb = :stage_nb, 
            time = :time 
        WHERE id = :id');

        return $updateStage->execute(array(
            'result_id' => $stage->getResultId(),
            'stage_nb' => $stage->getStageNb(),
            'time' => $stage->getTime()->format('i:s.u'),
            'id' => $stage->getId()
        ));
    }

    public function updateTime(Stage $stage): bool
    {
        $updateStage = $this->pdo->prepare('UPDATE stage 
        SET time = :time 
        WHERE result_id = :result_id AND  stage_nb = :stage_nb');

        return $updateStage->execute(array(
            'time' => $stage->getTime()->format('i:s.u'),
            'result_id' => $stage->getResultId(),
            'stage_nb' => $stage->getStageNb()
        ));
    }

    public function delete(int $id): bool
    {
        $deleteStage = $this->pdo->prepare('DELETE FROM stage WHERE id = :id');

        return $deleteStage->execute(array('id' => $id));
    }

    public function deleteByResultId(Stage $stage): bool
    {
        $deleteStage = $this->pdo->prepare('DELETE FROM stage WHERE result_id = :result_id');

        return $deleteStage->execute(array('result_id' => $stage->getResultId()));
    }
}
