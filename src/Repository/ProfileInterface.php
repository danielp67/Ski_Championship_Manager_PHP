<?php

namespace App\Repository;

use App\Model\Profile;

interface ProfileInterface
{
    public function find(int $id);
    public function findByName(Profile $object);
    public function findAll();
    public function add(Profile $object);
    public function update(Profile $object);
    public function delete(int $id);
}
