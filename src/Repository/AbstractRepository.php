<?php

namespace App\Repository;

abstract class AbstractRepository
{
    protected object $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
}
