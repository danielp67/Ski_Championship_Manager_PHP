<?php

namespace App\Factory;

use App\Entity\Participant;

final class ParticipantFactory
{
    static function fromDbCollection(array $dataParticipant): object
    {
        $Participant = new Participant();
        $Participant->buildFromDb($dataParticipant);
        
        return $Participant;
    }

    static function arrayFromDbCollection(array $dataParticipants): array
    {
        $dataParticipants = array_map('self::fromDbCollection', $dataParticipants); 

        return $dataParticipants;
    }

    static function fromRequestAdd(object $request): object
    {
        $Participant = new Participant();
        $Participant->buildFromRequestAdd($request);

        return $Participant;
    }

    static function fromRequestUdpate(object $request): object
    {
        $Participant = new Participant();
        $Participant->buildFromRequestUpdate($request);

        return $Participant;
    }
}
