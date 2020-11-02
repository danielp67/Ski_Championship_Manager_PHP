<?php

namespace App\Factory;

use App\Entity\Profile;

abstract class ProfileFactory
{
    public static function fromDbCollection(array $dataProfile): object
    {
        $profile = new Profile();
        $profile->buildFromDb($dataProfile);

        return $profile;
    }

    public static function arrayFromDbCollection(array $dataProfiles): array
    {
        return array_map('self::fromDbCollection', $dataProfiles);
    }

    public static function fromDbCollectionParticipant(array $dataParticipant): object
    {
        $profile = new Profile();
        $profile->buildFromDbParticipant($dataParticipant);

        return $profile;
    }

    public static function fromRequestAdd(object $request): object
    {
        $profile = new Profile();
        $profile->buildFromRequestAdd($request);

        return $profile;
    }

    public static function fromRequestUdpate(object $request): object
    {
        $profile = new Profile();
        $profile->buildFromRequestUpdate($request);

        return $profile;
    }
}
