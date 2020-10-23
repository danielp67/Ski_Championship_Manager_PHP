<?php

namespace App\Container;

use App\Repository\ConnectRepository;
use Pimple\Container;
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
}
