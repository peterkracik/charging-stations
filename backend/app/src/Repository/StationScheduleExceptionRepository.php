<?php

namespace App\Repository;

use App\Entity\ChargingStation;
use App\Entity\StationScheduleException;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScheduleException|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduleException|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduleException[]    findAll()
 * @method ScheduleException[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationScheduleExceptionRepository extends ScheduleExceptionRepository
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
    public function findOneForStationByDate(ChargingStation $station, DateTime $date): ?StationScheduleException
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.station_id = :id')
            ->andwhere(':date BETWEEN e.start AND e.end')
            ->setParameter('id', $station->getId())
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
