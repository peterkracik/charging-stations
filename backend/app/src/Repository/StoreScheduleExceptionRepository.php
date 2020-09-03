<?php

namespace App\Repository;

use App\Entity\StoreScheduleException;
use App\Entity\Store;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScheduleException|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduleException|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduleException[]    findAll()
 * @method ScheduleException[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoreScheduleExceptionRepository extends ScheduleExceptionRepository
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
    public function findOneForStoreByDate(Store $station, DateTime $date): ?StoreScheduleException
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.store_id = :id')
            ->andwhere(':date BETWEEN e.start AND e.end')
            ->setParameter('id', $station->getId())
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
