<?php

namespace App\Factory;

use App\Entity\Profile;

final class ProfileFactory
{
    static function fromDbCollection(array $dataProfile): object
    {
        $profile = new Profile();
        $profile->buildFromDb($dataProfile);

        return $profile;
    }

    static function arrayFromDbCollection(array $dataProfiles): array
    {
        $dataProfiles = array_map('self::fromDbCollection',$dataProfiles );

        return $dataProfiles;
    }

    static function fromRequestAdd(object $request): object
    {
        $profile = new Profile();
        $profile->buildFromRequestAdd($request);

        return $profile;
    }

    static function fromRequestUdpate(object $request): object
    {
        $profile = new Profile();
        $profile->buildFromRequestUpdate($request);

        return $profile;
    }
}
