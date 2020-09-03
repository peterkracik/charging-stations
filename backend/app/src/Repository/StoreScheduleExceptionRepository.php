<?php

namespace App\Repository;

use App\Entity\StoreScheduleException;
use App\Entity\Store;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 */
class StoreScheduleExceptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoreScheduleException::class);
    }

    /**
     * get exception for the charging station
     * @var Store $station
     * @var DateTime $date
     */
    public function findOneByDate(Store $client, DateTime $date): ?StoreScheduleException
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
