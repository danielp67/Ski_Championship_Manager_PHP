<?php

namespace App\Repository;

use App\Model\Category;

interface CategoryInterface
{
    public function find(int $id);
    public function findByName(Category $object);
    public function findAll();
    public function add(Category $object);
    public function update(Category $object);
    public function delete(int $id);

}