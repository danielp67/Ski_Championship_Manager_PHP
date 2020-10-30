<?php

namespace App\Container;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class SerializerContainer
{
    public static function serializerResultToCsv($dataToCsv)
    {
        $dateContext = array(DateTimeNormalizer::FORMAT_KEY => 'd/m/Y');
        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer($dateContext), new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $dataResult = $serializer->normalize(
            $dataToCsv['result'],
            null,
            [AbstractNormalizer::ATTRIBUTES => ['id'] ]
        );

        $dataParticipant = $serializer->normalize(
            $dataToCsv['participant'],
            null,
            [AbstractNormalizer::ATTRIBUTES => ['lastName', 'firstName', 'birthDate'] ]
        );

        $dataCategory = $serializer->normalize(
            $dataToCsv['category'],
            null,
            [AbstractNormalizer::ATTRIBUTES => ['name'] ]
        );

        $dataProfile = $serializer->normalize(
            $dataToCsv['profile'],
            null,
            [AbstractNormalizer::ATTRIBUTES => ['name'] ]
        );
       
        $dataNormalized = ['result' => $dataResult,
                            'pparticipant' => $dataParticipant,
                            'category' => $dataCategory,
                            'profile' =>  $dataProfile];

        $context = ['no_headers' => true, 'csv_escape_char' => false, 'as_collection' => true];

      //  var_dump( $dataNormalized);
        $dataToCsv = $serializer->serialize($dataNormalized, 'csv', $context);
       // var_dump( $dataToCsv);
        return $dataToCsv;
    }
}
