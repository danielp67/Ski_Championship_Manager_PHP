<?php

namespace App\Model;

interface Crud
{
    public function get(int $id);
    public function getAll();
    public function add($object);
    public function update($object);
    public function delete(int $id);

}