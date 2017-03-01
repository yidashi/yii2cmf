<?php

namespace common\traits;

trait EntityTrait
{
    public $entity;
    public $entityId;

    public function getEntityId()
    {
        if ($this->entityId == null) {
            $this->entityId = $this->owner->getPrimaryKey();
        }

        return $this->entityId;
    }

    public function getEntity()
    {
        if ($this->entity == null) {
            $this->entity = get_class($this->owner);
        }

        return ltrim($this->entity,"\\");
    }
}