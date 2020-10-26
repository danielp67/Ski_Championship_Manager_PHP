<?php

namespace App\Controller;

use App\Container\FactoryContainer;

abstract class AbstractController
{
    protected object $twig;
    protected object $pdo;
    protected object $serializer;


    public function __construct()
    {
        $this->twig = FactoryContainer::twigInitializer();
        $this->pdo = FactoryContainer::pdoInitializer();
        $this->serializer = FactoryContainer::csvSerializerInitializer();
    }
}
