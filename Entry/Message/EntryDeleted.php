<?php

namespace Grr\Core\Entry\Message;

final class EntryDeleted
{
    private int $entryId;

    public function __construct(int $entryId)
    {
        $this->entryId = $entryId;
    }

    public function getEntryId(): int
    {
        return $this->entryId;
    }
}
