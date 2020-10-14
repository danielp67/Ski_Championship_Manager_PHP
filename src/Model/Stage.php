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
    private DateTimeInterface $time;

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
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id): self
    {
        if (! is_int($id) || $id < 0) {
            throw new Exception('Id invalide');
        }
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of stage
     *
     * @return  self
     */ 
    public function setStage(int $stage): self
    {
        if (! is_int($stage) || $stage < 0) {
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
        echo $timeStage;
        var_dump($date);
        $this->date = $date;

        return $this;
    }

}