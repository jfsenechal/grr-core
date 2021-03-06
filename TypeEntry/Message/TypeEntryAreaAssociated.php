<?php

namespace Grr\Core\TypeEntry\Message;

final class TypeEntryAreaAssociated
{
    private int $areaId;

    public function __construct(int $areaId)
    {
        $this->areaId = $areaId;
    }

    public function getAreaId(): int
    {
        return $this->areaId;
    }
}
