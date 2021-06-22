<?php

namespace Grr\Core\Setting\Message;

final class SettingDeleted
{
    private array $settingsId;

    public function __construct(array $settingsId)
    {
        $this->settingsId = $settingsId;
    }

    public function getSettingId(): array
    {
        return $this->settingsId;
    }
}
