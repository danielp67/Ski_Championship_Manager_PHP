<?php

namespace App\Repository;

use App\Model\Race;

interface RaceInterface
{
    public function find(int $id);
    public function findByName(Race $object);
    public function findAll();
    public function add(Race $object);
    public function update(Race $object);
    public function delete(int $id);

}