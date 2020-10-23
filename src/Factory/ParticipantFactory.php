<?php

namespace App\Factory;

use App\Entity\Participant;

abstract class ParticipantFactory
{
    public static function fromDbCollection(array $dataParticipant): object
    {
        $Participant = new Participant();
        $Participant->buildFromDb($dataParticipant);
        
        return $Participant;
    }

    public static function arrayFromDbCollection(array $dataParticipants): array
    {
        $dataParticipants = array_map('self::fromDbCollection', $dataParticipants);

        return $dataParticipants;
    }

    public static function fromRequestAdd(object $request): object
    {
        $Participant = new Participant();
        $Participant->buildFromRequestAdd($request);

        return $Participant;
    }

    public static function fromRequestUdpate(object $request): object
    {
        $Participant = new Participant();
        $Participant->buildFromRequestUpdate($request);

        return $Participant;
    }
}
