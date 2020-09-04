<?php

namespace App\Services;

use App\Entity\ChargingStation;
use App\Entity\Timespan;
use App\Model\ScheduleExceptionInterface;
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
        if ($exception)
            return $exception->isOpen();

        return $this->openingHoursService->isOpen($station, $date); // if not exception, return value based on main schedule
    }

    /**
     * get status change for the station
     */
    public function searchStatusChange(ChargingStation $station, DateTime $date): DateTime
    {
        $date = new \DateTime($date->format('Y-m-d h:i')); // round date to minutes

        $schedule = $this->getScheduleForDay($station, $date); // create schedule for the current day
        $nextChange = $this->findNextChange($schedule, $date); // search for next change in the day schedule

        // if didnt find, try recursiviley for following days
        if ($nextChange == null) {
            // if not found, continue in the next day
            $nextDay = clone $date;
            $nextDay->modify("+1 day"); // modify day to following day
            $nextDay->format('Y-m-d');
            $nextDay = new \DateTime($nextDay->format('Y-m-d')); // to remove time => set to 00:00
            return $this->searchStatusChange($station, $nextDay);
        }

        return $nextChange;
    }

    /**
     * search in the schedule array for change from positive to negative value or vice-versa
     */
    private function findNextChange(array $schedule, DateTime $date): ?DateTime
    {
        $now = intval($date->format("U")); // get current timestamp
        $defaultValue = $schedule[$now]; // get the default value - first in the array
        foreach($schedule as $key => $value) {
            // search for the current value if the value(index) is in the past
            if ($key < $now) {
                $defaultValue = $value;
            } else {
                // if one is negative and other positive => status changed from closed to open or vice versa
                if (($defaultValue < 0 && $value > 0) || ($defaultValue > 0 && $value < 0)) {
                    $time = new DateTime();
                    $time->setTimestamp($key);
                    return $time; // return datetime object
                }
                $now += 60; // add 1 minute
            }
        }

        return null; // if didnt find
    }

    /**
     * prepare full schedule of the day
     */
    private function getScheduleForDay(ChargingStation $station, DateTime $date): array
    {
        $schedule = $this->createEmptyDaySchedule($date); // create empty schedule first
        $openingHours = $this->openingHoursService->getOpeningHoursForDay($station, $date); // get default opening hours for station

        $schedule = $this->addTimespansToSchedule($schedule, $openingHours); // add default opening hours to the schedule

        // get the end of the date
        $nextDay = clone $date;
        $nextDay->modify("+1 day"); // modify day to following day
        $nextDay->format('Y-m-d');
        $nextDay = new \DateTime($nextDay->format('Y-m-d')); // to remove time => set to 00:00

        // get exceptions for the station
        $exceptions = $this->scheduleExceptionService->findAllStationExceptionsByDate($station, $date, $nextDay);

        // convert exception objects to timespan objects
        $exceptions = array_map(function ($item) {
            return self::convertExceptionToTimespan($item);
        }, $exceptions ?? []);

        // add exceptions to the schedule
        $schedule = $this->addTimespansToSchedule($schedule, $exceptions); // basic opening hours

        return $schedule;
    }

    /**
     * create an array for each minute in the day, with default value -1
     */
    private function createEmptyDaySchedule(DateTime $date): array
    {
        $minsInDay = 1440;
        $step = 60; // one minute
        $beginOfDay = strtotime("today", $date->format("U"));
        $endOfDay = $beginOfDay + ($minsInDay * $step);
        $schedule = [];
        for ($i = $beginOfDay; $i < $endOfDay; $i += $step) {
            $schedule[$i] = -1; // closed by default with priority 1
        }
        return $schedule;
    }

    /**
     * add to array
     * value is priority of the timestamp, negative if closed, positive if open
     */
    private function addTimespansToSchedule(array $schedule, array $timespans): array
    {
        $step = 60;
        foreach ($timespans as $timespan) {
            $start = max(intval($timespan->getFrom()->format("U")), array_key_first($schedule)); // get higher from values start of the timestamp and schedule first index
            $end = min($timespan->getTo()->format("U"), array_key_last($schedule)); // get lower from values start of the timestamp and schedule first index

            $value = ($timespan->isOpen()) ? $timespan->getPriority() : $timespan->getPriority() * -1; // negative priority if closed, positive if open

            for ($i = $start; $i < $end; $i += $step) {
                // override only if priority is same or higher
                if (abs($schedule[$i]) <= $timespan->getPriority())
                    $schedule[$i] = $value;

            }
        }

        return $schedule;
    }

    /**
     * convert ScheduleException object to Timespan object
     */
    private static function convertExceptionToTimespan(ScheduleExceptionInterface $exception): Timespan
    {
        return new Timespan($exception->getStart(), $exception->getEnd(), $exception->isOpen(), $exception->getPriority());
    }
}