<?php

namespace App\Entity;

use Exception;

abstract class AbstractGroup
{
    protected const PATTERN_GROUP = '/^[a-zA-ZÀ-ÿ0-9 \(\).-]{1,20}$/';
    protected int $id;
    protected string $name;


    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function getname(): ?string
    {
        return $this->name;
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
     * Set the value of name
     * @param string $name
     * @throws Exception
     * @return  self
     */
    public function setName(string $name): self
    {
        $pattern = self::PATTERN_GROUP;
        if (! preg_match($pattern, $name)) {
            throw new Exception('nom est invalide');
        }
        $this->name = $name;

        return $this;
    }

    /**
     * Set the object from Db
     * @param array $dataGroup
     * @return  self
     */
    public function buildFromDb(array $dataGroup): self
    {
        $this->id = $dataGroup['id'];
        $this->name = $dataGroup['name'];

        return $this;
    }

    /**
     * Set the object from RequestAdd
     * @param object $request
     * @return  self
     */
    public function buildFromRequestAdd(object $request): self
    {
        $this->setName($request->get('name'));

        return $this;
    }

    /**
     * Set the object from RequestUpdate
     * @param object $request
     * @return  self
     */
    public function buildFromRequestUpdate(object $request): self
    {
        $this->setId($request->get('nameId'));
        $this->buildFromRequestAdd($request);

        return $this;
    }
}
