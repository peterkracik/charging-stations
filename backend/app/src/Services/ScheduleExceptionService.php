<?php

namespace App\Services;

use App\Entity\ChargingStation;
use App\Entity\Store;
use App\Entity\Tenant;
use App\Entity\Timespan;
use App\Entity\StationScheduleException;
use App\Entity\StoreScheduleException;
use App\Entity\TenantScheduleException;
use App\Model\ScheduleExceptionInterface;
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
    public function getStationExceptionByDate(ChargingStation $station, ?DateTime $date): ?ScheduleExceptionInterface
    {
        $date = $date ?? new DateTime();

        $repository = $this->entityManager->getRepository(StationScheduleException::class);
        $exception = $repository->findOneByDate($station, $date);

        if ($exception)
            return $exception;

        return $this->getStoreExceptionByDate($station->getStore(), $date);
    }

    /**
     * get exception for store
     */
    public function getStoreExceptionByDate(Store $store, ?DateTime $date): ?ScheduleExceptionInterface
    {
        $date = $date ?? new DateTime();

        $repository = $this->entityManager->getRepository(StoreScheduleException::class);
        $exception = $repository->findOneByDate($store, $date);
        if ($exception)
            return $exception;

        return $this->getTenantExceptionByDate($store->getTenant(), $date);
    }

    /**
     * get exception for tenant
     */
    public function getTenantExceptionByDate(Tenant $tenant, ?DateTime $date): ?ScheduleExceptionInterface
    {
        $date = $date ?? new DateTime();

        $repository = $this->entityManager->getRepository(TenantScheduleException::class);
        $exception = $repository->findOneByDate($tenant, $date);
        return $exception;
    }

    /**
     * find all exceptions for time range
     */
    public function findAllStationExceptionsByDate(ChargingStation $station, DateTime $dateFrom, DateTime $dateTo): array
    {
        $repository = $this->entityManager->getRepository(StationScheduleException::class);
        $stationExceptions = $repository->findAllByDate($station, $dateFrom, $dateTo); // get next exception for charging station

        // merge exceptions with parent object exceptions
        $storeExceptions = $this->findAllStoreExceptionsByDate($station->getStore(), $dateFrom, $dateTo);
        $exceptions = array_merge($stationExceptions, $storeExceptions);

        return $exceptions ?? [];
    }

    /**
     * find all exceptions for time range
     */
    public function findAllStoreExceptionsByDate(Store $store, DateTime $dateFrom, DateTime $dateTo): array
    {
        $repository = $this->entityManager->getRepository(StoreScheduleException::class);
        $storeExceptions = $repository->findAllByDate($store, $dateFrom, $dateTo); // get next exception for charging store

        // merge exceptions with parent object exceptions
        $tenantExceptions = $this->findAllTenantExceptionsByDate($store->getTenant(), $dateFrom, $dateTo);
        $exceptions = array_merge($tenantExceptions, $storeExceptions);

        return $exceptions ?? [];
    }

    /**
     * find all exceptions for time range
     */
    public function findAllTenantExceptionsByDate(Tenant $tenant, DateTime $dateFrom, DateTime $dateTo): array
    {
        $repository = $this->entityManager->getRepository(TenantScheduleException::class);
        $tenantExceptions = $repository->findAllByDate($tenant, $dateFrom, $dateTo); // get next exception for charging tenant

        return $tenantExceptions ?? [];
    }

}