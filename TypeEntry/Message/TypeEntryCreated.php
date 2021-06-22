<?php

namespace Grr\Core\TypeEntry\Message;

final class TypeEntryCreated
{
    private int $typeEntryId;

    public function __construct(int $typeEntryId)
    {
        $this->typeEntryId = $typeEntryId;
    }

    public function getTypeEntryId(): int
    {
        return $this->typeEntryId;
    }
}
