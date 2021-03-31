<?php

namespace App\Container;

abstract class DeserializerContainer
{
    public static function deserializeStagesFromCsv(string $fileContent): array
    {
        $serializer = FactoryContainer::csvSerializerInitializer();
        $context = ['csv_delimiter' => ';'];

        return $serializer->deserialize($fileContent, 'App\Entity\Stage[]', 'csv', $context);
    }
}
