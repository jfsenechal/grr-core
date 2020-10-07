<?php

namespace Grr\Core\Contrat\Front;

use DateTimeInterface;
use Grr\Core\Contrat\Entity\AreaInterface;
use Grr\Core\Contrat\Entity\RoomInterface;
use Symfony\Component\HttpFoundation\Response;

interface ViewInterface
{
    const VIEW_MONTHLY = 'monthly';
    const VIEW_WEEKLY = 'weekly';
    const VIEW_DAILY = 'daily';

    /**
     * Bind data.
     */
    public function bindData(): void;

    /**
     * Reponse rendue.
     */
    public function render(DateTimeInterface $dateSelected, AreaInterface $area, ?RoomInterface $room = null): Response;

    /**
     * Pour quelle vue.
     */
    public static function getDefaultIndexName(): string;
}