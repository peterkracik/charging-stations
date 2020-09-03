<?php

namespace App\Repository;

use App\Entity\ChargingStation;
use App\Entity\ScheduleException;
use App\Entity\Store;
use App\Entity\Tenant;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScheduleException|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduleException|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduleException[]    findAll()
 * @method ScheduleException[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleExceptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScheduleException::class);
    }
}
