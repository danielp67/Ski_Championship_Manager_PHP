<?php

namespace App\Entity;

use App\Entity\AbstractGroup;

final class Profile extends AbstractGroup
{
    /**
     * Set the object from Db
     * @param array $dataGroup
     * @return  self
     */
    public function buildFromDbParticipant(array $dataParticipant): self
    {
        $this->id = $dataParticipant['profile_id'];
        $this->name = $dataParticipant['profile'];

        return $this;
    }
}
