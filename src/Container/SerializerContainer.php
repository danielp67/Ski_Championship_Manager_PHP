<?php

namespace App\Container;

abstract class SerializerContainer
{
    public static function serializeResultToCsv(array $dataToCsv): string
    {
        $dataNormalized = ['result' => $dataToCsv['result']->normalize(),
                           'participant' => $dataToCsv['participant']->normalize(),
                            'category' => $dataToCsv['category']->normalize(),
                            'profile' =>  $dataToCsv['profile']->normalize()];

        $context = ['no_headers' => true, 'csv_escape_char' => false, 'as_collection' => true];

        $serializer = FactoryContainer::csvSerializerInitializer();

        return $serializer->serialize($dataNormalized, 'csv', $context);
    }
}
