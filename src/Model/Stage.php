<?php

namespace App\Model;

use DateTime;
use DateTimeInterface;
use Exception;

class Stage
{
    private const PATTERN_TIME = '/^([0-9]{1,2}:[0-5]{1}[0-9]{1}.[0-9]{1,3})$/';
    private int $id;
    private int $stageNb;
    private DateTimeInterface $time;
    private int $participantId;
    private int $raceId;


    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
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
     * Get the value of participantId
     */ 
    public function getParticipantId(): ?int
    {
        return $this->participantId;
    }

    /**
     * Get the value of raceId
     */ 
    public function getRaceId(): ?int
    {
        return $this->raceId;
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
     * @param int $time
     * @throws Exception
     * @return  self
     */ 
    public function setTime(string $timeStage): self
    {
        $pattern = self::PATTERN_TIME;
        if (! preg_match($pattern, $timeStage)) {
            throw new Exception('temps est invalide');
        }
        $date = DateTime::createFromFormat('i:s.u', $timeStage);
        $this->time = $date;

        return $this;
    }

    /**
     * Set the value of participantId
     * @param int $participantId
     * @return  self
     */ 
    public function setParticipantId($participantId)
    {
        $this->participantId = $this->checkId($participantId);

        return $this;
    }

    /**
     * Set the value of raceId
     * @param int $raceId
     * @return  self
     */ 
    public function setRaceId($raceId)
    {
        $this->raceId = $this->checkId($raceId);

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

}