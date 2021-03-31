<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Exception;

final class Race
{
    private const PATTERN_GROUP = '/^[a-zA-ZÀ-ÿ0-9 \(\).-]{1,20}$/';
    private const PATTERN_DATE = '/^\d{4}(\-)(((0)[0-9])|((1)[0-2]))(\-)([0-2][0-9]|(3)[0-1])$/';
    private ?int $id = null;
    private string $location;
    private DateTimeInterface $date;
    private int $status;

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
     * Get the value of status
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * Set the value of id
     * @param int $id
     * @throws Exception
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
     * @param string $location
     * @throws Exception
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
     * @param string $date
     * @throws Exception
     * @return  self
     */
    public function setDate(string $dateLocation): self
    {
        $pattern = self::PATTERN_DATE;
        if (! preg_match($pattern, $dateLocation)) {
            throw new Exception('date est invalide');
        }
        $date = DateTime::createFromFormat('Y-m-d', $dateLocation);
        $this->date = $date;

        return $this;
    }

    /**
     * Set the value of status
     * @param int $status
     * @throws Exception
     * @return  self
     */
    public function setStatus(int $status): self
    {
        if (! is_int($status) || $status < 0 || $status > 3) {
            throw new Exception('Status invalide');
        }
        $this->status = $status;

        return $this;
    }

    /**
     * Set the object from Db
     * @param array $dataRace
     * @return  self
     */
    public function buildFromDb(array $dataRace): self
    {
        $this->id = $dataRace['id'];
        $this->location = $dataRace['location'];
        $this->date = DateTime::createFromFormat('Y-m-d', $dataRace['date']);
        $this->status = $dataRace['status'];

        return $this;
    }

    /**
     * Set the object from RequestAdd
     * @param object $request
     * @return  self
     */
    public function buildFromRequestAdd(object $request): self
    {
        $this->setLocation($request->get('location'));
        $this->setDate($request->get('date'));
        $this->setStatus(0);

        return $this;
    }

    /**
     * Set the object from RequestUpdate
     * @param object $request
     * @return  self
     */
    public function buildFromRequestUpdate(object $request): self
    {
        $this->buildFromRequestAdd($request);
        $this->setId($request->get('id'));
        
        return $this->setStatus($request->get('status'));
    }
}
