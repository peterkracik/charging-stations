<?php

namespace App\Services;

use App\Entity\ChargingStation;
use App\Entity\StationScheduleException;
use App\Entity\Store;
use App\Entity\StoreScheduleException;
use App\Entity\Tenant;
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
     * find next exception
     */
    public function getNextStationException(ChargingStation $station, ?DateTime $date): ?ScheduleExceptionInterface
    {
        $date = $date ?? new DateTime();

        $repository = $this->entityManager->getRepository(StationScheduleException::class);
        $stationException = $repository->findNextByDate($station, $date); // get next exception for charging station
        $storeException = $this->getNextStoreException($station->getStore(), $date); // get next exception for store
        return self::compareExceptions($date, $stationException, $storeException); // return the smallest one
    }

    /**
     * find next exception
     */
    public function getNextStoreException(Store $store, ?DateTime $date): ?ScheduleExceptionInterface
    {
        $date = $date ?? new DateTime();

        $repository = $this->entityManager->getRepository(StoreScheduleException::class);
        $storeException = $repository->findNextByDate($store, $date);
        $tenantException = $this->getNextTenantException($store->getTenant(), $date);

        return self::compareExceptions($date, $storeException, $tenantException); // return the smallest one
    }

    /**
     * find next exception for tennt
     */
    public function getNextTenantException(Tenant $tenant, ?DateTime $date): ?ScheduleExceptionInterface
    {
        $date = $date ?? new DateTime();

        $repository = $this->entityManager->getRepository(TenantScheduleException::class);
        $exception = $repository->findNextByDate($tenant, $date);
        return $exception;
    }

    /**
     * returns scheduledexception which is closed to change the status (open -> close, close -> open)
     */
    private static function compareExceptions(DateTime $date, ?ScheduleExceptionInterface $exception1, ?ScheduleExceptionInterface $exception2): ?ScheduleExceptionInterface
    {
        if (!$exception1) return $exception2; // early return
        if (!$exception2) return $exception1; // early return

        // get pivot dates
        $comp_date_1 = ($date < $exception1->getStart()) ? $exception1->getStart() : $exception1->getEnd(); // get start if not alrady started, else end
        $comp_date_2 = ($date < $exception2->getStart()) ? $exception2->getStart() : $exception2->getEnd(); // get start if not alrady started, else end

        // returns the smaller one
        return ($comp_date_1 < $comp_date_2) ? $exception1 : $exception2;

    }
}