<?php

namespace App\Factory;

use App\Entity\Stage;

abstract class StageFactory
{
    public static function fromDbCollection(array $dataStage): Stage
    {
        $stage = new Stage();
        $stage->buildFromDb($dataStage);
        return $stage;
    }

    public static function arrayFromDbCollection(array $dataStages): array
    {
        return array_map('self::fromDbCollection', $dataStages);
    }
}
