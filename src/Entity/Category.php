<?php

namespace App\Entity;

use App\Entity\AbstractGroup;

final class Category extends AbstractGroup
{
      /**
     * Set the object from Db
     * @param array $dataGroup
     * @return  self
     */
    public function buildFromDbParticipant(array $dataParticipant): self
    {
        $this->id = $dataParticipant['category_id'];
        $this->name = $dataParticipant['category'];

        return $this;
    }
}
