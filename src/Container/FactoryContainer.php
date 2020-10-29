<?php

namespace App\Container;

use App\Repository\ConnectRepository;
use Pimple\Container;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class FactoryContainer
{
    public static function twigInitializer()
    {
        $container = new Container();
        $container['twig'] = function () {
            $loader = new FilesystemLoader('src/View');
            return new Environment($loader, []);
        };
        return $container['twig'];
    }

    public static function pdoInitializer()
    {
        $container = new Container();
        $container['pdo'] = function () {
            $pdo = new ConnectRepository();
            return $pdo->dbConnect();
        };
        return $container['pdo'];
    }

    public static function csvSerializerInitializer()
    {
        $container = new Container();
        $container['csvSerializer'] = function () {
            $dateContext = array(DateTimeNormalizer::FORMAT_KEY => 'd/m/Y');
            $encoders = [new CsvEncoder(), new JsonEncoder()];
            $normalizers = [new DateTimeNormalizer($dateContext), new ObjectNormalizer(), new ArrayDenormalizer()];
            $serializer = new Serializer($normalizers, $encoders);
            return $serializer;
        };
        return $container['csvSerializer'];
    }
}
