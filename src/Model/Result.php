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


   
}