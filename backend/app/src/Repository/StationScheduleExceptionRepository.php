<?php

namespace App\Repository;

use App\Entity\ChargingStation;
use App\Entity\StationScheduleException;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 */
class StationScheduleExceptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StationScheduleException::class);
    }

    /**
     * get exception for the charging station
     * @var ChargingStation $station
     * @var DateTime $date
     */
    public function findOneByDate(ChargingStation $client, DateTime $date): ?StationScheduleException
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
