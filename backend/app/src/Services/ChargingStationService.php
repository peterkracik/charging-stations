<?php

namespace App\Services;

use App\Entity\ChargingStation;
use DateTime;

class ChargingStationService
{

    /**
     * @var OpeningHoursService
     */
    private $openingHoursService;

    /**
     * @var ScheduleExceptionService
     */
    private $scheduleExceptionService;


    public function __construct(
        OpeningHoursService $openingHoursService,
        ScheduleExceptionService $scheduleExceptionService
    ) {
        $this->openingHoursService = $openingHoursService;
        $this->scheduleExceptionService = $scheduleExceptionService;
    }

    /**
     * return availability of the station for the current date/time
     *
     */
    public function isOpen(ChargingStation $station, DateTime $date): bool
    {
        $exception = $this->scheduleExceptionService->getStationExceptionByDate($station, $date); // get exception for the object

        // exception has priority over the main schedule
        if ($exception) {
            return $exception->isOpen();
        }

        return $this->openingHoursService->isOpen($station, $date); // if not exception, return value based on main schedule
    }

}