<?php

namespace App\Repository;

use App\Entity\ChargingStation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChargingStation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChargingStation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChargingStation[]    findAll()
 * @method ChargingStation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChargingStationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChargingStation::class);
    }

    // /**
    //  * @return ChargingStation[] Returns an array of ChargingStation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChargingStation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
