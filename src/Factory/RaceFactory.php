<?php

namespace App\Factory;

use App\Entity\Race;

abstract class RaceFactory
{
    static function fromDbCollection(array $dataRace): object
    {
        $race = new Race();
        $race->buildFromDb($dataRace);
        return $race;
    }

    static function arrayFromDbCollection(array $dataRaces): array
    {
        $dataRaces = array_map('self::fromDbCollection',$dataRaces );

        return $dataRaces;
    }

    static function fromRequestAdd(object $request): object
    {
        $race = new Race();
        $race->buildFromRequestAdd($request);

        return $race;
    }

    static function fromRequestUdpate(object $request): object
    {
        $race = new Race();
        $race->buildFromRequestUpdate($request);

        return $race;
    }
}
