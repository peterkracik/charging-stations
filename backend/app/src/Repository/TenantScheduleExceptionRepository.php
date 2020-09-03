<?php

namespace App\Repository;

use App\Entity\TenantScheduleException;
use App\Entity\Tenant;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 */
class TenantScheduleExceptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TenantScheduleException::class);
    }

    /**
     * get exception for the charging station
     * @var Tenant $station
     * @var DateTime $date
     */
    public function findOneByDate(Tenant $client, DateTime $date): ?TenantScheduleException
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.client = :id')
            ->andwhere(':date BETWEEN e.start AND e.end')
            ->setParameter('id', $client->getId())
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
