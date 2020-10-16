<?php

namespace App\Model;

use DateInterval;
use DateTime;
use DateTimeInterface;
use Exception;

final class Participant
{
    private const PATTERN_MAIL = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
    private const PATTERN_NAME = '/^[a-zA-ZÀ-ÿ .-]{2,16}$/';
    private const PATTERN_DATE = '/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/';
    private const PATTERN_IMG = '/([^\\s]+(\\.(?i)(jpe?g|png|gif|bmp))$)/';
    private int $id;
    private string $lastName;
    private string $firstName;
    private string $mail;
    private DateTimeInterface $birthDate;
    private string $imgLink;
    private int $categoryId;
    private int $profileId;

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
     * 
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
     * Get the value of categoryId
     */ 
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     * Get the value of profileId
     */ 
    public function getProfileId(): ?int
    {
        return $this->profileId;
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
     * Set the value of lastName
     * @param string $lastName
     * @return  self
     */ 
    public function setLastName(string $lastName): self
    {
        $this->lastName = $this->checkStringMatchPattern(self::PATTERN_NAME, $lastName);

        return $this;
    }

    /**
     * Set the value of firstName
     * @param string $firstName
     * @return  self
     */ 
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $this->checkStringMatchPattern(self::PATTERN_NAME, $firstName);

        return $this;
    }

    /**
     * Set the value of mail
     * @param string $mail
     * @return  self
     */ 
    public function setMail(string $mail): self
    {
        $this->mail = $this->checkStringMatchPattern(self::PATTERN_MAIL, $mail);

        return $this;
    }

    /**
     * Set the value of birthDate
     * @param string $birthDate
     * @throws Exception
     * @return  self
     */ 
    public function setBirthDate(string $birthDate): self
    {
        $checkDate = $this->checkStringMatchPattern(self::PATTERN_DATE, $birthDate);
        $date = DateTime::createFromFormat('d/m/Y', $checkDate);
        $maxAge100 = (new DateTime())->sub(new DateInterval('P100Y'));
        $minAge3 = (new DateTime())->sub(new DateInterval('P3Y'));
        if($date<$maxAge100 || $date>$minAge3){
            throw new Exception('Date de naissance non valide');
        }
        $this->birthDate = $date;

        return $this;
    }

    /**
     * Set the value of imgLink
     * @param string $imgLink
     * @return  self
     */ 
    public function setImgLink(string $imgLink): self
    {
        $this->imgLink = $this->checkStringMatchPattern(self::PATTERN_IMG, $imgLink);

        return $this;
    }

    /**
     * Set the value of categoryId
     * @param int $categoryId
     * @return  self
     */ 
    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $this->checkId($categoryId);

        return $this;
    }

    /**
     * Set the value of profileId
     * @param int $profileId
     * @return  self
     */ 
    public function setProfileId(int $profileId): self
    {
        $this->profileId = $this->checkId($profileId);

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

    /**
     * check the string value if match pattern
     * @param string $pattern
     * @param string  $string
     * @throws Exception
     * @return  string
     */ 
    private function checkStringMatchPattern(string $pattern, string $string): string
    {
        if (! preg_match($pattern, $string)) {
            throw new Exception('format non valide');
        }
        return $string;
    }
}