<?php

namespace App\Factory;

use App\Entity\Stage;

abstract class StageFactory
{
    public static function fromDbCollection(array $dataStage): object
    {
        $stage = new Stage();
        $stage->buildFromDb($dataStage);
        return $stage;
    }

    public static function arrayFromDbCollection(array $dataStages): array
    {
        $dataStages = array_map('self::fromDbCollection', $dataStages);

        return $dataStages;
    }

    public static function fromRequestAdd(object $request): object
    {
        $stage = new Stage();
        $stage->buildFromRequestAdd($request);

        return $stage;
    }

    public static function fromRequestUdpate(object $request): object
    {
        $stage = new Stage();
        $stage->buildFromRequestUpdate($request);

        return $stage;
    }
}
