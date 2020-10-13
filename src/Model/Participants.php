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
    private string $lastName = '';
    private string $firstName = '';
    private string $mail = '';
    private DateTimeInterface $birthDate;
    private string $imgLink = '';
    private int $categoriesId;
    private int $profilsId;

    /**
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get the value of mail
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Get the value of birthDate
     */ 
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Get the value of imgLink
     */ 
    public function getImgLink()
    {
        return $this->imgLink;
    }

    /**
     * Get the value of categoriesId
     */ 
    public function getCategoriesId()
    {
        return $this->categoriesId;
    }

    /**
     * Get the value of profilsId
     */ 
    public function getProfilsId()
    {
        return $this->profilsId;
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
    public function setImgLink($imgLink)
    {
        $pattern = self::PATTERN_IMG;
        if (! preg_match($pattern, $imgLink)) {
            throw new Exception('image est invalide');
        }
        $this->imgLink = $imgLink;

        return $this;
    }
}
