<?php

namespace App\Kernel;

final class Kernel
{
    /**
     * Set the object from Db
     *
     * @param array $dataGroup
     *
     * @return  self
     */
    public function buildFromDbParticipant(array $dataParticipant): self
    {
        $this->id = $dataParticipant['category_id'];
        $this->name = $dataParticipant['category'];

        return $this;
    }
}
