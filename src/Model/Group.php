<?php

namespace App\Model;

use Exception;

abstract class Group
{
    protected const PATTERN_GROUP = '/^[a-zA-ZÀ-ÿ0-9 .-]{2,16}$/';
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
     * Set the value of name
     *
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

}