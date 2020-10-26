<?php

namespace App\Repository;

use App\Entity\Stage;

interface StageInterface
{
    public function find(int $id);
    public function findByName(Stage $object);
    public function findAll();
    public function add(Stage $object);
    public function update(Stage $object);
    public function delete(int $id);
}
