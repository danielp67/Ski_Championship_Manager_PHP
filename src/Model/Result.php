<?php

namespace App\Model;

use DateTime;
use DateTimeInterface;
use Exception;

class Result
{
    private const PATTERN_TIME = '/^([0-9]{1,2}:[0-5]{1}[0-9]{1}.[0-9]{1,3})$/';
    private int $id;
    private int $participantId;
    private int $raceId;
    private DateTimeInterface $averageTime;

    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
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
     * Get the value of averageTime
     */ 
    public function getAverageTime(): ?DateTimeInterface
    {
        return $this->averageTime;
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
     * Set the value of participantId
     * @param int $participantId
     * @return  self
     */ 
    public function setParticipantId(int $participantId): self
    {
        $this->participantId = $this->checkId($participantId);

        return $this;
    }

    /**
     * Set the value of raceId
     * @param int $raceId
     * @return  self
     */ 
    public function setRaceId(int $raceId): self
    {
        $this->raceId = $this->checkId($raceId);

        return $this;
    }

    /**
     * Set the value of averageTime
     * @param DateTimeInterface $averageTime
     * @throws Exception
     * @return  self
     */ 
    public function setAverageTime(string $averageTime): self
    {
        $pattern = self::PATTERN_TIME;
        if (! preg_match($pattern, $averageTime)) {
            throw new Exception('temps est invalide');
        }
        $time = DateTime::createFromFormat('i:s.u', $averageTime);
        $this->averageTime = $time;

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