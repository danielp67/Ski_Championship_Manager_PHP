<?php

namespace App\Model;

use DateTime;
use DateTimeInterface;
use Exception;

final class Epreuves
{
    protected const PATTERN_GROUP = '/^[a-zA-ZÀ-ÿ0-9 .-]{2,16}$/';
    private const PATTERN_DATE = '/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/';
    protected int $id;
    protected string $location;
    protected DateTimeInterface $date;

    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of location
     */ 
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * Get the value of date
     */ 
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
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
     * Set the value of location
     *
     * @return  self
     */ 
    public function setLocation(string $location): self
    {
        $pattern = self::PATTERN_GROUP;
        if (! preg_match($pattern, $location)) {
            throw new Exception('location est invalide');
        }
        $this->location = $location;

        return $this;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate(string $dateLocation): self
    {
        $pattern = self::PATTERN_DATE;
        if (! preg_match($pattern, $dateLocation)) {
            throw new Exception('date est invalide');
        }
        $date = DateTime::createFromFormat('d/m/Y', $dateLocation);
        $this->date = $date;

        return $this;
    }
}