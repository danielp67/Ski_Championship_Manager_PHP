<?php

namespace App\Model;

use DateTime;
use DateTimeInterface;
use Exception;

final class Participants
{
    private const PATTERN_MAIL = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
    private const PATTERN_NAME = '/^[a-zA-ZÀ-ÿ .-]{2,16}$/';
    private const PATTERN_DATE = '/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/';
    private const PATTERN_IMG = '/([^\\s]+(\\.(?i)(jpe?g|png|gif|bmp))$)/';
    private int $id;
    private string $lastName = '';
    private string $firstName = '';
    private string $mail = '';
    private DateTimeInterface $birthDate;
    private string $imgLink = '';
    private int $categoriesId;
    private int $profilsId;

    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Get the value of mail
     */ 
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * Get the value of birthDate
     */ 
    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * Get the value of imgLink
     */ 
    public function getImgLink(): ?string
    {
        return $this->imgLink;
    }

    /**
     * Get the value of categoriesId
     */ 
    public function getCategoriesId(): ?int
    {
        return $this->categoriesId;
    }

    /**
     * Get the value of profilsId
     */ 
    public function getProfilsId(): ?int
    {
        return $this->profilsId;
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
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName(string $lastName): self
    {
        $pattern = self::PATTERN_NAME;
        if (! preg_match($pattern, $lastName)) {
            throw new Exception('nom est invalide');
        }
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName(string $firstName): self
    {
        $pattern = self::PATTERN_NAME;
        if (! preg_match($pattern, $firstName)) {
            throw new Exception('prénom est invalide');
        }
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function setMail(string $mail): self
    {
        $pattern = self::PATTERN_MAIL;
        if (! preg_match($pattern, $mail)) {
            throw new Exception('mail est invalide');
        }
        $this->mail = $mail;

        return $this;
    }

    /**
     * Set the value of birthDate
     *
     * @return  self
     */ 
    public function setBirthDate(string $birthDate): self
    {
        $pattern = self::PATTERN_DATE;
        if (! preg_match($pattern, $birthDate)) {
            throw new Exception('date est invalide');
        }
        $date = DateTime::createFromFormat('d/m/Y', $birthDate);
        $this->birthDate = $date;

        return $this;
    }

    /**
     * Set the value of imgLink
     *
     * @return  self
     */ 
    public function setImgLink(string $imgLink): self
    {
        $pattern = self::PATTERN_IMG;
        if (! preg_match($pattern, $imgLink)) {
            throw new Exception('image est invalide');
        }
        $this->imgLink = $imgLink;

        return $this;
    }

    /**
     * Set the value of categoriesId
     *
     * @return  self
     */ 
    public function setCategoriesId(int $categoriesId): self
    {
        if (! is_int($categoriesId) || $categoriesId < 0) {
            throw new Exception('Catégorie Id invalide');
        }
        $this->categoriesId = $categoriesId;

        return $this;
    }

    /**
     * Set the value of profilsId
     *
     * @return  self
     */ 
    public function setProfilsId(int $profilsId): self
    {
        if (! is_int($profilsId) || $profilsId < 0) {
            throw new Exception('Profil Id invalide');
        }
        $this->profilsId = $profilsId;

        return $this;
    }
}