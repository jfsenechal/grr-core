<?php
/**
 * Created by PhpStorm.
 * User: jfsenechal
 * Date: 20/03/19
 * Time: 16:38.
 */

namespace Grr\Core\Doctrine;

use DateTimeInterface;
use Doctrine\ORM\QueryBuilder;

class QueryHelper
{
    private QueryBuilder $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function addConstraint(DateTimeInterface $dateTime): void
    {
        $this->queryBuilder->andWhere('entry.startTime LIKE %:date%')
            ->setParameter('date', $dateTime);
    }
}
