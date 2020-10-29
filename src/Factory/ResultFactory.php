<?php

namespace App\Factory;

use App\Entity\Result;

abstract class ResultFactory
{
    public static function fromDbCollection(array $dataResult): object
    {
        $result = new Result();
        $result->buildFromDb($dataResult);

        return  $result;
    }

    public static function arrayFromDbCollection(array $dataResults): array
    {
        $dataResults = array_map('self::fromDbCollection', $dataResults);

        return $dataResults;
    }

    public static function arrayFromDbCollectionParticipant(array $dataResults): array
    {
        $dataResults = array_map('self::fromDbCollectionParticipant', $dataResults);

        return $dataResults;
    }

    public static function fromDbCollectionParticipant(array $dataResult): array
    {
        $result = self::fromDbCollection($dataResult);

        $participant = ParticipantFactory::fromDbCollection($dataResult);

        return  ['result' => $result] + $participant;
    }

    public static function fromRequestAdd(object $request): object
    {
        $result = new Result();
        $result->buildFromRequestAdd($request);

        return $result;
    }

    public static function fromRequestUdpate(object $request): object
    {
        $result = new Result();
        $result->buildFromRequestUpdate($request);

        return $result;
    }
}
