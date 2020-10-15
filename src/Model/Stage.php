<?php

namespace App\Model;

use DateTime;
use DateTimeInterface;
use Exception;

class Stage
{
    private const PATTERN_TIME = '/^([0-9]{1,2}:[0-5]{1}[0-9]{1}.[0-9]{1,3})$/';
    private int $id;
    private int $stage;
    private ?DateTimeInterface $time;
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
     * Get the value of stage
     */ 
    public function getStage(): ?int
    {
        return $this->stage;
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
     *
     * @return  self
     */ 
    public function setId(int $id): self
    {
        $this->id = $this->checkId($id);

        return $this;
    }

    /**
     * Set the value of stage
     *
     * @return  self
     */ 
    public function setStage(int $stage): self
    {
        if (! is_int($stage) || $stage < 1 || $stage > 2) {
            throw new Exception('Id invalide');
        }
        $this->stage = $stage;

        return $this;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime(string $timeStage): self
    {
        $pattern = self::PATTERN_TIME;
        if (! preg_match($pattern, $timeStage)) {
            throw new Exception('temps est invalide');
        }
        $date = DateTime::createFromFormat('i:s.u', $timeStage);
        var_dump($date);
        $this->time = $date;

        return $this;
    }

    /**
     * Set the value of participantId
     *
     * @return  self
     */ 
    public function setParticipantId($participantId)
    {
        $this->participantId = $this->checkId($participantId);

        return $this;
    }

    /**
     * Set the value of raceId
     *
     * @return  self
     */ 
    public function setRaceId($raceId)
    {
        $this->raceId = $this->checkId($raceId);

        return $this;
    }

    /**
     * check the value if is int
     *
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