<?php

namespace App\Repository;

use App\Container\FactoryContainer;


abstract class AbstractRepository
{
    protected object $pdo;

    public function __construct()
    {
        $this->pdo = FactoryContainer::pdoInitializer();
        
    }
}
