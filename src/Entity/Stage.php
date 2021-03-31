<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Exception;

final class Stage
{
    private const PATTERN_TIME = '/^([0-9]{1,2}:[0-5]{1}[0-9]{1}.[0-9]{1,3})$/';
    private int $id;
    private int $resultId;
    private int $stageNb;
    private ?DateTimeInterface $time;

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of resultId
     */
    public function getResultId(): ?int
    {
        return $this->resultId;
    }

    /**
     * Get the value of stageNb
     */
    public function getStageNb(): ?int
    {
        return $this->stageNb;
    }

    /**
     * Get the value of time
     */
    public function getTime(): ?DateTimeInterface
    {
        return $this->time;
    }

    /**
     * Set the value of id
     * @param int $id
     * @return  self
     */
    public function setId(int $id): self
    {
        $this->id = $this->checkId($id);

        return $this;
    }

    /**
     * Set the value of resultId
     * @param int $resultId
     * @return  self
     */
    public function setResultId(int $resultId): self
    {
        $this->resultId = $this->checkId($resultId);

        return $this;
    }

    /**
     * Set the value of stageNb
     * @param int $stageNb
     * @throws Exception
     * @return  self
     */
    public function setStageNb(int $stageNb): self
    {
        if (! is_int($stageNb) || $stageNb < 1 || $stageNb > 2) {
            throw new Exception('Id invalide');
        }
        $this->stageNb = $stageNb;

        return $this;
    }

    /**
     * Set the value of time
     * @param string $timeStage
     * @throws Exception
     * @return  self
     */
    public function setTime(string $timeStage): self
    {
        $pattern = self::PATTERN_TIME;
        if (! preg_match($pattern, $timeStage)) {
            throw new Exception('temps est invalide');
        }
        $time = DateTime::createFromFormat('i:s.u', $timeStage);
        $this->time = $time;

        return $this;
    }

    /**
     * check the value if is int
     * @param int $int
     * @throws Exception
     * @return  int
     */
    private function checkId(int $int): int
    {
        if (! is_int($int) || $int < 0) {
            throw new Exception('Id invalide');
        }
        return $int;
    }

    public function buildFromDb(array $dataStage): Stage
    {
        $this->id = $dataStage['id'];
        $this->resultId = $dataStage['result_id'];
        $this->stageNb = $dataStage['stage_nb'];

       // var_dump(DateTime::createFromFormat('i:s.u', $dataStage['time']), $dataStage['time']);die();
        $this->time = is_null($dataStage['time']) ? null : DateTime::createFromFormat('i:s.u', $dataStage['time']);

        return $this;
    }
}
