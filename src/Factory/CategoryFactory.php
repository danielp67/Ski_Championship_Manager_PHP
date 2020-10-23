<?php

namespace App\Factory;

use App\Entity\Category;

final class CategoryFactory
{
    static function fromDbCollection(array $dataCategory): object
    {
        $category = new Category();
        $category->buildFromDb($dataCategory);

        return $category;
    }

    static function arrayFromDbCollection(array $dataCategories): array
    {
        $dataCategories = array_map('self::fromDbCollection', $dataCategories); 

        return $dataCategories;
    }

    static function fromRequestAdd(object $request): object
    {
        $category = new Category();
        $category->buildFromRequestAdd($request);

        return $category;
    }

    static function fromRequestUdpate(object $request): object
    {
        $category = new Category();
        $category->buildFromRequestUpdate($request);

        return $category;
    }

}
