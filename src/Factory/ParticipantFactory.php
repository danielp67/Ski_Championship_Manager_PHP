<?php

namespace App\Factory;

use App\Entity\Participant;

abstract class ParticipantFactory
{
    public static function fromDbCollection(array $dataParticipant): object
    {
        $participant = new Participant();
        $participant->buildFromDb($dataParticipant);
        
        return $participant;
    }

    public static function arrayFromDbCollection(array $dataParticipants): array
    {
        $dataParticipants = array_map('self::fromDbCollection', $dataParticipants);

        return $dataParticipants;
    }

    public static function fromRequestAdd(object $request): object
    {
        $participant = new Participant();
        $participant->buildFromRequestAdd($request);

        return $participant;
    }

    public static function fromRequestUdpate(object $request): object
    {
        $participant = new Participant();
        $participant->buildFromRequestUpdate($request);

        return $participant;
    }
}
