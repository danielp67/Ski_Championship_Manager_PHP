<?php

namespace App\Repository;

use App\Entity\Result;

interface ResultInterface
{
    public function find(int $id);
    public function findByName(Result $object);
    public function findAll();
    public function add(Result $object);
    public function update(Result $object);
    public function delete(int $id);
}
