<?php

namespace App\Services;

use App\Entity\ChargingStation;
use App\Entity\ScheduleException;
use App\Entity\StationScheduleException;
use App\Entity\Store;
use App\Entity\StoreScheduleException;
use App\Entity\Tenant;
use App\Entity\TenantScheduleException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ScheduleExceptionService
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * get exception for charging station
     */
    public function getStationExceptionByDate(ChargingStation $station, ?DateTime $date): ?ScheduleException
    {
        $date = $date ?? new DateTime();

        $this->repository = $this->entityManager->getRepository(StationScheduleException::class);
        $exception = $this->repository->findOneForStationByDate($station, $date);

        if ($exception)
            return $exception;

        return $this->getStoreExceptionByDate($station->getStore(), $date);
    }

    /**
     * get exception for store
     */
    public function getStoreExceptionByDate(Store $store, ?DateTime $date): ?ScheduleException
    {
        $date = $date ?? new DateTime();

        $this->repository = $this->entityManager->getRepository(StoreScheduleException::class);
        $exception = $this->repository->findOneForStationByDate($store, $date);
        if ($exception)
            return $exception;

        return $this->getTenantExceptionByDate($store->getTenant(), $date);
    }

    /**
     * get exception for tenant
     */
    public function getTenantExceptionByDate(Tenant $tenant, ?DateTime $date): ?ScheduleException
    {
        $date = $date ?? new DateTime();

        $this->repository = $this->entityManager->getRepository(TenantScheduleException::class);
        $exception = $this->repository->findOneForStationByDate($tenant, $date);
        return $exception;
    }

}