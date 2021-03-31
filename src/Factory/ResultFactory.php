<?php

namespace App\Factory;

use App\Entity\Result;

abstract class ResultFactory
{
    public static function fromDbCollection(array $dataResult): Result
    {
        $result = new Result();
        $result->buildFromDb($dataResult);

        return $result;
    }

    public static function arrayFromDbCollection(array $dataResults): array
    {
        return array_map('self::fromDbCollection', $dataResults);
    }

    public static function fromDbCollectionParticipant(array $dataResult): array
    {
        $result = self::fromDbCollection($dataResult);

        $participant = ParticipantFactory::fromDbCollection($dataResult);

        return ['result' => $result] + $participant;
    }

    public static function arrayFromDbCollectionParticipant(array $dataResults): array
    {
        return array_map('self::fromDbCollectionParticipant', $dataResults);
    }

    public static function fromRequestAdd(array $dataResult): Result
    {
        $result = new Result();
        $result->buildFromRequestAdd($dataResult);

        return $result;
    }

    public static function arrayfromRequestAdd(array $dataResults): array
    {
        return array_map('self::fromRequestAdd', $dataResults);
    }

    public static function fromRequestUdpate(array $dataResults): Result
    {
        $result = new Result();
        $result->buildFromRequestUpdate($dataResults);

        return $result;
    }
}
