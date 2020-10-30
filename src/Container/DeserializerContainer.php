<?php

namespace App\Container;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


final class DeserializerContainer
{
    public function deserializeFromCsv($request)
    {
        $data = $request->files->get('file');
        $dateContext = array(DateTimeNormalizer::FORMAT_KEY => 'd/m/Y');
        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer($dateContext), new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
           var_dump(file_get_contents($data));
           $context = ['csv_delimiter' => ';'];

           $result2 = $serializer->deserialize(file_get_contents($data), 'App\Entity\Stage[]', 'csv', $context);
          
           var_dump($result2);

           return $result2;
    }
}
