<?php

namespace App\Factory;

use App\Entity\Category;

abstract class CategoryFactory
{
    public static function fromDbCollection(array $dataCategory): object
    {
        $category = new Category();
        $category->buildFromDb($dataCategory);

        return $category;
    }

    public static function arrayFromDbCollection(array $dataCategories): array
    {
        $dataCategories = array_map('self::fromDbCollection', $dataCategories);

        return $dataCategories;
    }

    public static function fromDbCollectionParticipant(array $dataParticipant): object
    {
        $category = new Category();
        $category->buildFromDbParticipant($dataParticipant);

        return $category;
    }

    public static function fromRequestAdd(object $request): object
    {
        $category = new Category();
        $category->buildFromRequestAdd($request);

        return $category;
    }

    public static function fromRequestUdpate(object $request): object
    {
        $category = new Category();
        $category->buildFromRequestUpdate($request);

        return $category;
    }
}
