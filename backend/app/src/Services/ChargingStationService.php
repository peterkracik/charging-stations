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

    /**
     * get status change for the station
     */
    public function statusChange(ChargingStation $station, DateTime $date): DateTime
    {
        $scheduledTime = $this->openingHoursService->getNextChangeInSchedule($station, $date); // get next scheduled opening time
        $exception = $this->scheduleExceptionService->getNextStationException($station, $date); // get next eception

        if (!$exception) return $scheduledTime; // if exception doesnt exist

        return self::getMinDate($date, [$scheduledTime, $exception->getStart(), $exception->getEnd()]); // get the smallest one;
    }


    public static function getMinDate($currentDate, array $dates): DateTime
    {
        // sort first
        usort($dates, function ($a, $b) {
            return $a < $b ? -1 : 1;
        });

        foreach($dates as $date) {
            if ($date > $currentDate) return $date;
        }
    }

}