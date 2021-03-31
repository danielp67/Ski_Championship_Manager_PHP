<?php

namespace App\Factory;

use App\Entity\Participant;

abstract class ParticipantFactory
{
    public static function fromDbCollection(array $dataParticipant): array
    {
        $participant = new Participant();
        $participant->buildFromDb($dataParticipant);

        $category = CategoryFactory::fromDbCollectionParticipant($dataParticipant);
        $profile = ProfileFactory::fromDbCollectionParticipant($dataParticipant);

        return ['participant' => $participant,
                'category' => $category,
                'profile' => $profile];
    }

    public static function arrayFromDbCollection(array $dataParticipants): array
    {
        return array_map('self::fromDbCollection', $dataParticipants);
    }

    public static function fromRequestAdd(object $request): object
    {
        $participant = new Participant();
        $participant->buildFromRequestAdd($request);

        return $participant;
    }

    public static function fromRequestUpdate(object $request): Participant
    {
        $participant = new Participant();
        $participant->buildFromRequestUpdate($request);

        return $participant;
    }
}
