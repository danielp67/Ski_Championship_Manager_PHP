<?php

namespace App\Repository;

use App\Entity\Participant;

interface ParticipantInterface
{
    public function find(int $id);
    public function findByName(Participant $object);
    public function findAll();
    public function add(Participant $object);
    public function update(Participant $object);
    public function delete(int $id);
}
