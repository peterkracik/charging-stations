<?php

namespace App\Repository;

use App\Entity\TenantScheduleException;
use App\Entity\Store;
use App\Entity\Tenant;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScheduleException|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduleException|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduleException[]    findAll()
 * @method ScheduleException[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TenantScheduleExceptionRepository extends ScheduleExceptionRepository
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
    public function findOneForTenantByDate(Tenant $station, DateTime $date): ?TenantScheduleException
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.tenant_id = :id')
            ->andwhere(':date BETWEEN e.start AND e.end')
            ->setParameter('id', $station->getId())
            ->setParameter('date', $date)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
